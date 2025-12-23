@extends('layouts.app')
@section('title', 'Détails Filiale')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">

    {{-- En-tête --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">🏛️ {{ $filiale->name }}</h1>
        <div class="space-x-2">
            <a href="{{ route('filiales.edit', $filiale->id) }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-bold transition">✏️ Éditer</a>
            <a href="{{ route('filiales.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl transition">← Retour</a>
        </div>
    </div>

    {{-- Informations principales --}}
    <div class="bg-black text-white rounded-2xl shadow-lg border border-neutral-800 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-neutral-400 text-sm uppercase">Code</p>
                <p class="text-lg font-semibold">{{ $filiale->code ?? '—' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Localisation</p>
                <p class="text-lg font-semibold">{{ $filiale->location ?? '—' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Départements</p>
                <p class="text-2xl font-bold text-[#D4AF37]">{{ $filiale->departments->count() }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Agences</p>
                <p class="text-2xl font-bold text-[#D4AF37]">{{ $filiale->agences->count() }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-neutral-400 text-sm uppercase">Employés</p>
                <p class="text-2xl font-bold text-[#D4AF37]">{{ $filiale->employees->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Départements --}}
    @if($filiale->departments->count() > 0)
    <div class="bg-black text-white rounded-2xl shadow-lg border border-neutral-800 p-6 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-4">📂 Départements ({{ $filiale->departments->count() }})</h2>
        <div class="space-y-2">
            @foreach($filiale->departments as $dept)
                <div class="bg-neutral-900 p-3 rounded-xl flex justify-between items-center border border-neutral-800">
                    <div>
                        <p class="font-semibold text-white">{{ $dept->name }}</p>
                        <p class="text-xs text-neutral-400">{{ $dept->code ?? '—' }}</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        <span class="bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full text-xs font-semibold">{{ $dept->employees->count() }} employés</span>
                        <a href="{{ route('departments.show', $dept->id) }}" class="text-[#D4AF37] hover:text-yellow-500 text-sm font-bold">Voir →</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Agences --}}
    @if($filiale->agences->count() > 0)
    <div class="bg-black text-white rounded-2xl shadow-lg border border-neutral-800 p-6 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-4">🏢 Agences ({{ $filiale->agences->count() }})</h2>
        <div class="space-y-2">
            @foreach($filiale->agences as $agence)
                <div class="bg-neutral-900 p-3 rounded-xl flex justify-between items-center border border-neutral-800">
                    <div>
                        <p class="font-semibold text-white">{{ $agence->name }}</p>
                        <p class="text-xs text-neutral-400">{{ $agence->location ?? 'Localisation non définie' }}</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        <span class="bg-green-900 text-green-200 px-3 py-1 rounded-full text-xs font-semibold">{{ $agence->employees->count() ?? 0 }} employés</span>
                        <a href="{{ route('agences.show', $agence->id) }}" class="text-[#D4AF37] hover:text-yellow-500 text-sm font-bold">Voir →</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Employés --}}
    @if($filiale->employees->count() > 0)
    <div class="bg-black text-white rounded-2xl shadow-lg border border-neutral-800 p-6 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-4">👥 Employés ({{ $filiale->employees->count() }})</h2>
        <div class="space-y-2">
            @foreach($filiale->employees->take(20) as $emp)
                <div class="bg-neutral-900 p-3 rounded-xl flex justify-between items-center border border-neutral-800">
                    <div>
                        <p class="font-semibold text-white">{{ $emp->first_name }} {{ $emp->last_name }}</p>
                        <p class="text-xs text-neutral-400">{{ $emp->position?->name ?? 'Poste non défini' }}</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        @if($emp->department)
                            <span class="bg-purple-900 text-purple-200 px-2 py-1 rounded text-xs font-semibold">{{ $emp->department->name }}</span>
                        @endif
                        @if($emp->agence)
                            <span class="bg-green-900 text-green-200 px-2 py-1 rounded text-xs font-semibold">{{ $emp->agence->name }}</span>
                        @endif
                        <a href="{{ route('employees.show', $emp->id) }}" class="text-[#D4AF37] hover:text-yellow-500 text-sm font-bold">Voir →</a>
                    </div>
                </div>
            @endforeach
            @if($filiale->employees->count() > 20)
                <p class="text-center text-neutral-500 text-sm">+ {{ $filiale->employees->count() - 20 }} autres employés</p>
            @endif
        </div>
    </div>
    @endif

    {{-- Supprimer filiale --}}
    <div class="mt-8 pt-4 border-t border-neutral-700">
        <form action="{{ route('filiales.destroy', $filiale->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette filiale ?')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold transition">🗑️ Supprimer</button>
        </form>
    </div>
</div>
@endsection
