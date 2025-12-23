@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">✏️ Modifier le Mouvement</h1>
                    <p class="text-neutral-400 mt-2">Modification du mouvement de stock</p>
                </div>
                <a href="{{ route('stocks.index') }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-semibold transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour
                </a>
            </div>
        </div>

        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8">
            <form action="{{ route('stocks.update', $stock) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date -->
                    <div>
                        <label class="block text-sm font-semibold text-[#D4AF37] mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Date *
                        </label>
                        <input type="date" name="date" value="{{ old('date', $stock->date) }}" 
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all" required>
                        @error('date')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Article -->
                    <div>
                        <label class="block text-sm font-semibold text-[#D4AF37] mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Article *
                        </label>
                        <input type="text" name="articles" value="{{ old('articles', $stock->articles) }}" 
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all" required>
                        @error('articles')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantité -->
                    <div>
                        <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Quantité *</label>
                        <input type="number" name="quantite" value="{{ old('quantite', $stock->quantite) }}" step="0.01" min="0"
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all" required>
                        @error('quantite')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prix Unitaire -->
                    <div>
                        <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Prix Unitaire *</label>
                        <input type="number" name="prix_unitaire" value="{{ old('prix_unitaire', $stock->prix_unitaire) }}" step="0.01" min="0"
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all" required>
                        @error('prix_unitaire')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Entrée -->
                    <div>
                        <label class="block text-sm font-semibold text-green-400 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                            </svg>
                            Entrée (Réception)
                        </label>
                        <input type="number" name="entree" value="{{ old('entree', $stock->entree) }}" step="0.01" min="0"
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                        <p class="text-xs text-neutral-500 mt-1">Quantité reçue en stock</p>
                        @error('entree')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sortie -->
                    <div>
                        <label class="block text-sm font-semibold text-red-400 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                            </svg>
                            Sortie (Utilisation)
                        </label>
                        <input type="number" name="sortie" value="{{ old('sortie', $stock->sortie) }}" step="0.01" min="0"
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all">
                        <p class="text-xs text-neutral-500 mt-1">Quantité sortie du stock</p>
                        @error('sortie')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Destination -->
                    <div>
                        <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Destination</label>
                        <input type="text" name="destination" value="{{ old('destination', $stock->destination) }}"
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all">
                        <p class="text-xs text-neutral-500 mt-1">Pour les sorties seulement</p>
                        @error('destination')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fournisseur -->
                    <div>
                        <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Fournisseur</label>
                        <input type="text" name="fournisseur" value="{{ old('fournisseur', $stock->fournisseur) }}"
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all">
                        @error('fournisseur')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Filiale -->
                    <div>
                        <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Filiale</label>
                        <select name="filiale_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all">
                            <option value="">Maison Mère</option>
                            @foreach($filiales as $filiale)
                                <option value="{{ $filiale->id }}" {{ old('filiale_id', $stock->filiale_id) == $filiale->id ? 'selected' : '' }}>
                                    {{ $filiale->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('filiale_id')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Agence -->
                    <div>
                        <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Agence</label>
                        <select name="agence_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all">
                            <option value="">Aucune</option>
                            @foreach($agences as $agence)
                                <option value="{{ $agence->id }}" {{ old('agence_id', $stock->agence_id) == $agence->id ? 'selected' : '' }}>
                                    {{ $agence->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('agence_id')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end gap-4 mt-8">
                    <a href="{{ route('stocks.index') }}" 
                       class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-semibold transition-all">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
