@extends('layouts.app')
@section('title', 'Détails Assurance')

@section('content')
<div class="px-6 py-6">
    <!-- Header avec gradient -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-5xl font-bold mb-2 bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">
                    🛡️ Détails de l'Assurance
                </h2>
                <p class="text-neutral-400">Informations complètes de la couverture d'assurance</p>
            </div>
            <a href="{{ route('employee_insurances.index') }}" 
               class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-semibold transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour
            </a>
        </div>
    </div>

    <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8">
        <!-- Informations principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-neutral-800/50 rounded-xl p-6 border border-neutral-700">
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Employé
                </p>
                <p class="text-3xl font-bold text-white">{{ $insurance->employee?->first_name }} {{ $insurance->employee?->last_name }}</p>
                <p class="text-neutral-400 text-sm mt-2">{{ $insurance->employee?->email }}</p>
            </div>

            <div class="bg-neutral-800/50 rounded-xl p-6 border border-neutral-700">
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Filiale
                </p>
                @if($insurance->employee?->filiale)
                    <span class="inline-block bg-gradient-to-r from-blue-900/50 to-blue-800/50 border border-blue-500/30 text-blue-300 px-4 py-2 rounded-xl font-semibold text-lg">
                        {{ $insurance->employee->filiale->name }}
                    </span>
                @else
                    <span class="inline-block bg-gradient-to-r from-[#D4AF37]/20 to-yellow-500/20 border border-[#D4AF37]/30 text-[#D4AF37] px-4 py-2 rounded-xl font-semibold text-lg">
                        🏢 Maison Mère
                    </span>
                @endif
            </div>

            <div class="bg-neutral-800/50 rounded-xl p-6 border border-neutral-700">
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Département
                </p>
                <span class="inline-block bg-gradient-to-r from-purple-900/50 to-purple-800/50 border border-purple-500/30 text-purple-300 px-4 py-2 rounded-xl font-semibold text-lg">
                    {{ $insurance->employee?->department?->name ?? '—' }}
                </span>
            </div>

            <div class="bg-neutral-800/50 rounded-xl p-6 border border-neutral-700">
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Plan d'Assurance
                </p>
                <span class="inline-block bg-gradient-to-r from-indigo-900/50 to-indigo-800/50 border border-indigo-500/30 text-indigo-300 px-4 py-2 rounded-xl font-semibold text-lg">
                    {{ $insurance->insurancePlan?->name ?? '—' }}
                </span>
            </div>
        </div>

        <!-- Détails de la couverture -->
        <div class="bg-gradient-to-br from-neutral-800/70 to-neutral-900/70 rounded-2xl p-6 mb-8 border border-[#D4AF37]/20">
            <h3 class="text-2xl font-bold text-[#D4AF37] mb-6 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Période de Couverture
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="border-l-4 border-green-500 pl-4">
                    <p class="text-neutral-400 text-sm uppercase mb-1">Date de début</p>
                    <p class="text-2xl font-bold text-green-400">{{ $insurance->start_date?->format('d/m/Y') ?? '—' }}</p>
                    <p class="text-xs text-neutral-500 mt-1">{{ $insurance->start_date?->diffForHumans() }}</p>
                </div>

                <div class="border-l-4 border-red-500 pl-4">
                    <p class="text-neutral-400 text-sm uppercase mb-1">Date de fin</p>
                    <p class="text-2xl font-bold text-red-400">{{ $insurance->end_date?->format('d/m/Y') ?? '—' }}</p>
                    @if($insurance->end_date)
                        <p class="text-xs text-neutral-500 mt-1">{{ $insurance->end_date->diffForHumans() }}</p>
                    @endif
                </div>

                <div class="border-l-4 border-[#D4AF37] pl-4">
                    <p class="text-neutral-400 text-sm uppercase mb-1">Statut</p>
                    @if($insurance->status === 'active' || ($insurance->start_date <= now() && (!$insurance->end_date || $insurance->end_date >= now())))
                        <span class="inline-flex items-center gap-2 bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300 px-4 py-2 rounded-xl font-semibold text-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Actif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 bg-gradient-to-r from-red-900/50 to-red-800/50 border border-red-500/30 text-red-300 px-4 py-2 rounded-xl font-semibold text-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Expiré
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4 pt-6 border-t border-neutral-700">
            <a href="{{ route('employee_insurances.edit', $insurance->id) }}" 
               class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifier
            </a>
            <form action="{{ route('employee_insurances.destroy', $insurance->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette assurance?')">
                @csrf @method('DELETE')
                <button type="submit" 
                        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection