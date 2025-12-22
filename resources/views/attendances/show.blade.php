@extends('layouts.app')
@section('title', 'Détails Présence')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">📍 Détails de la Présence</h1>
        <a href="{{ route('attendances.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg">← Retour</a>
    </div>

    <div class="bg-black rounded-lg shadow-xl p-8 border border-neutral-800">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Employé</p>
                <p class="text-2xl font-bold text-white">{{ $attendance->employee?->first_name }} {{ $attendance->employee?->last_name }}</p>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Filiale</p>
                @if($attendance->employee?->filiale)
                    <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full font-semibold">
                        {{ $attendance->employee->filiale->name }}
                    </span>
                @else
                    <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full font-semibold">
                        🏢 Maison Mère
                    </span>
                @endif
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Agence</p>
                @if($attendance->employee?->agence)
                    <span class="inline-block bg-green-900 text-green-200 px-3 py-1 rounded-full font-semibold">
                        {{ $attendance->employee->agence->name }}
                    </span>
                @else
                    <span class="text-neutral-500">—</span>
                @endif
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Département</p>
                @if($attendance->employee?->department)
                    <span class="inline-block bg-purple-900 text-purple-200 px-3 py-1 rounded-full font-semibold">
                        {{ $attendance->employee->department->name }}
                    </span>
                @else
                    <span class="text-neutral-500">—</span>
                @endif
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Date</p>
                <p class="text-lg font-semibold text-white">{{ $attendance->attendance_date?->format('d/m/Y') ?? '—' }}</p>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Heure d'arrivée</p>
                <p class="text-lg font-semibold text-cyan-400">{{ $attendance->check_in ?? '—' }}</p>
            </div>

            <div>
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Heure de départ</p>
                <p class="text-lg font-semibold text-orange-400">{{ $attendance->check_out ?? '—' }}</p>
            </div>

            <div class="md:col-span-2">
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Statut</p>
                @if($attendance->status === 'present')
                    <span class="inline-block bg-green-900 text-green-200 px-4 py-2 rounded-lg font-semibold text-lg">✅ Présent</span>
                @elseif($attendance->status === 'absent')
                    <span class="inline-block bg-red-900 text-red-200 px-4 py-2 rounded-lg font-semibold text-lg">❌ Absent</span>
                @elseif($attendance->status === 'late')
                    <span class="inline-block bg-yellow-900 text-yellow-200 px-4 py-2 rounded-lg font-semibold text-lg">⏳ En retard</span>
                @endif
            </div>

            @if($attendance->attachment)
            <div class="md:col-span-2">
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-2">Justificatif</p>
                <a href="{{ Storage::url($attendance->attachment) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded-lg font-semibold transition">
                    📎 Télécharger le justificatif
                </a>
            </div>
            @endif
        </div>

        <div class="flex gap-4 mt-8 pt-8 border-t border-neutral-700">
            <a href="{{ route('attendances.edit', $attendance->id) }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg font-bold transition">✏️ Modifier</a>
            <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette présence?')">
                @csrf @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold transition">🗑️ Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection