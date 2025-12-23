@extends('layouts.app')

@section('title', 'Détails Utilisateur')

@section('content')
<div class="px-6 py-6">
    <!-- Header avec gradient -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-5xl font-bold mb-2 bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">
                    👨‍💼 Détails Utilisateur
                </h2>
                <p class="text-neutral-400">Informations complètes de l'utilisateur</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('users.edit', $user->id) }}" 
                   class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Éditer
                </a>
                <a href="{{ route('users.index') }}" 
                   class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-semibold transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </div>

    <!-- Details Card -->
    <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-neutral-800/50 rounded-xl p-6 border border-neutral-700">
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                    </svg>
                    ID
                </p>
                <p class="text-2xl font-bold text-white">{{ $user->id }}</p>
            </div>
            
            <div class="bg-neutral-800/50 rounded-xl p-6 border border-neutral-700">
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Nom
                </p>
                <p class="text-2xl font-bold text-white">{{ $user->name ?? $user->first_name ?? 'N/A' }}</p>
            </div>
            
            <div class="bg-neutral-800/50 rounded-xl p-6 border border-neutral-700">
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Créé le
                </p>
                <p class="text-lg text-white">{{ $user->created_at?->format('d/m/Y H:i') ?? 'N/A' }}</p>
                <p class="text-xs text-neutral-500 mt-1">{{ $user->created_at?->diffForHumans() }}</p>
            </div>
            
            <div class="bg-neutral-800/50 rounded-xl p-6 border border-neutral-700">
                <p class="text-neutral-400 text-sm uppercase font-semibold mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Mis à jour le
                </p>
                <p class="text-lg text-white">{{ $user->updated_at?->format('d/m/Y H:i') ?? 'N/A' }}</p>
                <p class="text-xs text-neutral-500 mt-1">{{ $user->updated_at?->diffForHumans() }}</p>
            </div>
        </div>
    </div>

    <!-- Delete Section -->
    <div class="bg-gradient-to-br from-red-900/20 to-red-800/20 border border-red-500/30 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-red-400 mb-1">Zone de Danger</h3>
                <p class="text-neutral-400 text-sm">La suppression est irréversible</p>
            </div>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression définitive?')">
                @csrf
                @method('DELETE')
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