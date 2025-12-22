@extends('layouts.app')
@section('title', 'Détails Département')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">🏢 {{ $department->name }}</h1>
        <div class="space-x-2">
            <a href="{{ route('departments.edit', $department->id) }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg font-bold">✏️ Éditer</a>
            <a href="{{ route('departments.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg">← Retour</a>
        </div>
    </div>

    <div class="bg-black rounded-lg shadow-xl p-8 border border-neutral-800 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-neutral-400 text-sm uppercase">Code</p>
                <p class="text-lg font-semibold text-white">{{ $department->code ?? '—' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Filiale</p>
                @if($department->filiale)
                    <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full text-sm font-semibold">{{ $department->filiale->name }}</span>
                @else
                    <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full text-sm font-semibold">🏢 Maison Mère</span>
                @endif
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Agence</p>
                @if($department->agence)
                    <span class="inline-block bg-green-900 text-green-200 px-3 py-1 rounded-full text-sm font-semibold">{{ $department->agence->name }}</span>
                @else
                    <span class="text-neutral-500">—</span>
                @endif
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Nombre d'Employés</p>
                <p class="text-2xl font-bold text-[#D4AF37]">{{ $department->employees->count() }}</p>
            </div>
        </div>
    </div>

    @if($department->employees->count() > 0)
    <div class="bg-black rounded-lg shadow-xl p-8 border border-neutral-800">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6">👥 Employés ({{ $department->employees->count() }})</h2>
        <div class="space-y-2">
            @foreach($department->employees as $emp)
            <div class="bg-neutral-900 p-3 rounded-lg flex justify-between items-center border border-neutral-800">
                <div>
                    <p class="text-white font-semibold">{{ $emp->first_name }} {{ $emp->last_name }}</p>
                    <p class="text-neutral-400 text-xs">{{ $emp->position?->name ?? 'Poste non défini' }}</p>
                </div>
                <div class="flex gap-2 items-center">
                    @if($emp->agence)
                        <span class="bg-green-900 text-green-200 px-2 py-1 rounded text-xs font-semibold">{{ $emp->agence->name }}</span>
                    @endif
                    <a href="{{ route('employees.show', $emp->id) }}" class="text-[#D4AF37] hover:text-yellow-500 text-sm font-bold">Voir →</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="mt-8 pt-6 border-t border-neutral-700">
        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression de ce département ?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold transition">🗑️ Supprimer</button>
        </form>
    </div>
</div>
@endsection