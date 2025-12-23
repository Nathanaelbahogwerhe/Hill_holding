@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="max-w-5xl mx-auto">
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">{{ $stock->articles }}</h1>
                    <p class="text-neutral-400">Mouvement du {{ \Carbon\Carbon::parse($stock->date)->format('d/m/Y') }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('stocks.edit', $stock) }}" 
                       class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50">
                        Modifier
                    </a>
                    <form action="{{ route('stocks.destroy', $stock) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce mouvement ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>

            <!-- Type de mouvement -->
            <div class="mb-6">
                @if($stock->entree > 0)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Entrée
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Sortie
                    </span>
                @endif
            </div>

            <!-- Informations principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Date</p>
                    <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($stock->date)->format('d/m/Y') }}</p>
                </div>

                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Article</p>
                    <p class="text-lg font-semibold">{{ $stock->articles }}</p>
                </div>

                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Quantité</p>
                    <p class="text-lg font-semibold">{{ number_format($stock->quantite, 2) }}</p>
                </div>

                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Prix Unitaire</p>
                    <p class="text-lg font-semibold">{{ number_format($stock->prix_unitaire, 2) }} FC</p>
                </div>

                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Prix Total</p>
                    <p class="text-lg font-semibold text-white">{{ number_format($stock->prix_total, 2) }} FC</p>
                </div>

                @if($stock->entree > 0)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Entrée</p>
                    <p class="text-lg font-semibold text-white">{{ number_format($stock->entree, 2) }}</p>
                </div>
                @endif

                @if($stock->sortie > 0)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Sortie</p>
                    <p class="text-lg font-semibold text-red-600">{{ number_format($stock->sortie, 2) }}</p>
                </div>
                @endif

                @if($stock->destination)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Destination</p>
                    <p class="text-lg font-semibold">{{ $stock->destination }}</p>
                </div>
                @endif

                @if($stock->fournisseur)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Fournisseur</p>
                    <p class="text-lg font-semibold">{{ $stock->fournisseur }}</p>
                </div>
                @endif

                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Solde</p>
                    <p class="text-lg font-semibold {{ $stock->solde > 0 ? 'text-white' : 'text-red-600' }}">
                        {{ number_format($stock->solde, 2) }}
                    </p>
                </div>

                @if($stock->filiale)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Filiale</p>
                    <p class="text-lg font-semibold">{{ $stock->filiale->name }}</p>
                </div>
                @endif

                @if($stock->agence)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Agence</p>
                    <p class="text-lg font-semibold">{{ $stock->agence->name }}</p>
                </div>
                @endif
            </div>

            <!-- Métadonnées -->
            <div class="mt-6 pt-6 border-t">
                <div class="text-sm text-neutral-400">
                    <p>Créé le {{ $stock->created_at->format('d/m/Y à H:i') }}</p>
                    @if($stock->updated_at != $stock->created_at)
                        <p>Modifié le {{ $stock->updated_at->format('d/m/Y à H:i') }}</p>
                    @endif
                </div>
            </div>

            <!-- Bouton retour -->
            <div class="mt-6">
                <a href="{{ route('stocks.index') }}" 
                   class="inline-flex items-center text-white hover:text-blue-800">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
