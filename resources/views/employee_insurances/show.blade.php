@extends('layouts.app')
@section('title', 'Détails Assurance')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-blue-400">🛡️ Détails de l'Assurance</h1>
        <a href="{{ route('employee_insurances.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">← Retour</a>
    </div>

    <div class="bg-slate-900 rounded-lg shadow-xl p-8 border border-slate-700">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <p class="text-slate-400 text-sm uppercase font-semibold mb-2">Employé</p>
                <p class="text-2xl font-bold text-gray-100">{{ $insurance->employee?->first_name }} {{ $insurance->employee?->last_name }}</p>
            </div>

            <div>
                <p class="text-slate-400 text-sm uppercase font-semibold mb-2">Filiale</p>
                @if($insurance->employee?->filiale)
                    <span class="inline-block bg-blue-900 text-blue-200 px-3 py-1 rounded-full font-semibold">
                        {{ $insurance->employee->filiale->name }}
                    </span>
                @else
                    <span class="inline-block bg-purple-900 text-purple-200 px-3 py-1 rounded-full font-semibold">
                        🏢 Maison Mère
                    </span>
                @endif
            </div>

            <div>
                <p class="text-slate-400 text-sm uppercase font-semibold mb-2">Département</p>
                <span class="inline-block bg-purple-900 text-purple-200 px-3 py-1 rounded-full font-semibold">
                    {{ $insurance->employee?->department?->name ?? '—' }}
                </span>
            </div>

            <div>
                <p class="text-slate-400 text-sm uppercase font-semibold mb-2">Plan d'Assurance</p>
                <span class="inline-block bg-indigo-900 text-indigo-200 px-3 py-1 rounded-full font-semibold">
                    {{ $insurance->insurancePlan?->name ?? '—' }}
                </span>
            </div>

            <div>
                <p class="text-slate-400 text-sm uppercase font-semibold mb-2">Date de début</p>
                <p class="text-lg font-semibold text-gray-100">{{ $insurance->start_date?->format('d/m/Y') ?? '—' }}</p>
            </div>

            <div>
                <p class="text-slate-400 text-sm uppercase font-semibold mb-2">Date de fin</p>
                <p class="text-lg font-semibold text-gray-100">{{ $insurance->end_date?->format('d/m/Y') ?? '—' }}</p>
            </div>

            <div>
                <p class="text-slate-400 text-sm uppercase font-semibold mb-2">Statut</p>
                @if($insurance->status === 'active')
                    <span class="inline-block bg-green-900 text-green-200 px-4 py-2 rounded-lg font-semibold">✅ Actif</span>
                @else
                    <span class="inline-block bg-red-900 text-red-200 px-4 py-2 rounded-lg font-semibold">❌ Inactif</span>
                @endif
            </div>
        </div>

        <div class="flex gap-4 pt-8 border-t border-slate-700">
            <a href="{{ route('employee_insurances.edit', $insurance->id) }}" class="px-6 py-3 bg-cyan-600 hover:bg-cyan-700 text-white rounded-lg font-bold transition">✏️ Modifier</a>
            <form action="{{ route('employee_insurances.destroy', $insurance->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr?')">
                @csrf @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold transition">🗑️ Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection