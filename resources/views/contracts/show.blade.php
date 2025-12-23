@extends('layouts.app')
@section('title', 'Détails Contrat')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">📋 Détails du Contrat</h1>
        <a href="{{ route('contracts.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl">← Retour</a>
    </div>

    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Employé</p>
                <p class="text-2xl font-bold text-white">{{ $contract->employee?->first_name }} {{ $contract->employee?->last_name }}</p>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Filiale</p>
                @if($contract->employee?->filiale)
                    <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full font-semibold">
                        {{ $contract->employee->filiale->name }}
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
                    {{ $contract->employee?->department?->name ?? '—' }}
                </span>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Type de Contrat</p>
                <span class="inline-block bg-indigo-900 text-indigo-200 px-3 py-1 rounded-full font-semibold">
                    {{ $contract->contract_type }}
                </span>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Date de début</p>
                <p class="text-lg font-semibold text-white">{{ $contract->start_date?->format('d/m/Y') ?? '—' }}</p>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Date de fin</p>
                <p class="text-lg font-semibold text-white">{{ $contract->end_date?->format('d/m/Y') ?? '—' }}</p>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Salaire</p>
                <p class="text-2xl font-bold text-[#D4AF37]">{{ number_format($contract->salary ?? 0, 0, ',', ' ') }} FBu</p>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Durée</p>
                @if($contract->end_date)
                    <p class="text-lg font-semibold text-cyan-400">{{ $contract->start_date?->diffInMonths($contract->end_date) }} mois</p>
                @else
                    <p class="text-lg font-semibold text-green-400">Indéterminé</p>
                @endif
            </div>
        </div>

        @if($contract->description)
            <div class="bg-neutral-900 rounded-xl p-6 mb-8 border border-neutral-800">
                <h3 class="text-xl font-bold text-[#D4AF37] mb-4">Description</h3>
                <p class="text-neutral-300 whitespace-pre-wrap">{{ $contract->description }}</p>
            </div>
        @endif

        @if($contract->attachment)
            <div class="bg-neutral-900 rounded-xl p-6 mb-8 border border-neutral-800">
                <h3 class="text-xl font-bold text-[#D4AF37] mb-4">Document du Contrat</h3>
                <a href="{{ Storage::url($contract->attachment) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-[#D4AF37] hover:bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 text-black rounded-xl font-semibold transition">
                    📎 Télécharger le document
                </a>
            </div>
        @endif

        <div class="flex gap-4 pt-8 border-t border-neutral-700">
            <a href="{{ route('contracts.edit', $contract->id) }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-bold transition">✏️ Modifier</a>
            <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr?')">
                @csrf @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold transition">🗑️ Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection