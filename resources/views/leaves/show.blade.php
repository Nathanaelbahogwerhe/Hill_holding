@extends('layouts.app')
@section('title', 'Détails Congé')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">🏖️ Détails du Congé</h1>
        <a href="{{ route('leaves.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg">← Retour</a>
    </div>

    <div class="bg-black rounded-lg shadow-xl p-8 border border-neutral-800">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Employé</p>
                <p class="text-2xl font-bold text-white">{{ $leave->employee?->first_name }} {{ $leave->employee?->last_name }}</p>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Filiale</p>
                @if($leave->employee?->filiale)
                    <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full font-semibold">
                        {{ $leave->employee->filiale->name }}
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
                    {{ $leave->employee?->department?->name ?? '—' }}
                </span>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Type de Congé</p>
                <span class="inline-block bg-orange-900 text-orange-200 px-3 py-1 rounded-full font-semibold">
                    {{ $leave->leaveType?->name ?? '—' }}
                </span>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Date de début</p>
                <p class="text-lg font-semibold text-white">{{ $leave->start_date?->format('d/m/Y') ?? '—' }}</p>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Date de fin</p>
                <p class="text-lg font-semibold text-white">{{ $leave->end_date?->format('d/m/Y') ?? '—' }}</p>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Durée</p>
                <p class="text-lg font-semibold text-cyan-400">{{ $leave->start_date?->diffInDays($leave->end_date) ?? 0 }} jours</p>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Statut</p>
                @if($leave->status === 'pending')
                    <span class="inline-block bg-yellow-900 text-yellow-200 px-4 py-2 rounded-lg font-semibold">⏳ En attente</span>
                @elseif($leave->status === 'approved')
                    <span class="inline-block bg-green-900 text-green-200 px-4 py-2 rounded-lg font-semibold">✅ Approuvé</span>
                @elseif($leave->status === 'rejected')
                    <span class="inline-block bg-red-900 text-red-200 px-4 py-2 rounded-lg font-semibold">❌ Rejeté</span>
                @endif
            </div>

            @if($leave->attachment)
            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Justificatif</p>
                <a href="{{ Storage::url($leave->attachment) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded-lg font-semibold transition">
                    📎 Télécharger
                </a>
            </div>
            @endif
        </div>

        <div class="flex gap-4 pt-8 border-t border-neutral-700">
            <a href="{{ route('leaves.edit', $leave->id) }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg font-bold transition">✏️ Modifier</a>
            <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr?')">
                @csrf @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold transition">🗑️ Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection