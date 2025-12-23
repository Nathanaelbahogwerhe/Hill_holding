@extends('layouts.app')
@section('title', 'Détails Fiche de Paie')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">💰 Fiche de Paie</h1>
        <a href="{{ route('payrolls.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl">← Retour</a>
    </div>

    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Employé</p>
                <p class="text-2xl font-bold text-white">{{ $payroll->employee?->first_name }} {{ $payroll->employee?->last_name }}</p>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Filiale</p>
                @if($payroll->employee?->filiale)
                    <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full font-semibold">
                        {{ $payroll->employee->filiale->name }}
                    </span>
                @else
                    <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full font-semibold">
                        🏢 Maison Mère
                    </span>
                @endif
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Département</p>
                <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full font-semibold">
                    {{ $payroll->employee?->department?->name ?? '—' }}
                </span>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Mois</p>
                <p class="text-lg font-semibold text-white">{{ \Carbon\Carbon::parse($payroll->month)->translatedFormat('F Y') }}</p>
            </div>
        </div>

        <div class="bg-neutral-900 rounded-xl p-6 mb-8 border border-neutral-800">
            <h3 class="text-xl font-bold text-[#D4AF37] mb-4">Détails de la Paie</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border-l-4 border-[#D4AF37] pl-4">
                    <p class="text-neutral-400 text-sm uppercase mb-1">Salaire de base</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($payroll->base_salary ?? 0, 0, ',', ' ') }} FBu</p>
                </div>

                <div class="border-l-4 border-green-600 pl-4">
                    <p class="text-neutral-400 text-sm uppercase mb-1">Primes</p>
                    <p class="text-2xl font-bold text-green-400">{{ number_format($payroll->bonuses ?? 0, 0, ',', ' ') }} FBu</p>
                </div>

                <div class="border-l-4 border-cyan-600 pl-4">
                    <p class="text-neutral-400 text-sm uppercase mb-1">Allocations</p>
                    <p class="text-2xl font-bold text-cyan-400">{{ number_format($payroll->allowances ?? 0, 0, ',', ' ') }} FBu</p>
                </div>

                <div class="border-l-4 border-red-600 pl-4">
                    <p class="text-neutral-400 text-sm uppercase mb-1">Déductions</p>
                    <p class="text-2xl font-bold text-red-400">-{{ number_format($payroll->deductions ?? 0, 0, ',', ' ') }} FBu</p>
                </div>

                <div class="border-l-4 border-[#D4AF37] pl-4 md:col-span-2">
                    <p class="text-neutral-400 text-sm uppercase mb-1">Salaire net</p>
                    <p class="text-3xl font-bold text-[#D4AF37]">{{ number_format($payroll->net_salary ?? 0, 0, ',', ' ') }} FBu</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Date de paiement</p>
                <p class="text-lg font-semibold text-white">{{ $payroll->payment_date?->format('d/m/Y') ?? '—' }}</p>
            </div>

            @if($payroll->attachment)
            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Pièce jointe</p>
                <a href="{{ Storage::url($payroll->attachment) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#D4AF37] hover:bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 text-black rounded-xl font-semibold transition">
                    📎 Télécharger le fichier
                </a>
            </div>
            @endif
        </div>

        <div class="flex gap-4 pt-8 border-t border-neutral-700">
            <a href="{{ route('payrolls.edit', $payroll->id) }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-bold transition">✏️ Modifier</a>
            <form action="{{ route('payrolls.destroy', $payroll->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr?')">
                @csrf @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold transition">🗑️ Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection