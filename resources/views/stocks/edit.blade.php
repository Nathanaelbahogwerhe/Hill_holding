@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Modifier le Mouvement de Stock</h1>

            <form action="{{ route('stocks.update', $stock) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                        <input type="date" name="date" value="{{ old('date', $stock->date) }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        @error('date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Article -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Article *</label>
                        <input type="text" name="articles" value="{{ old('articles', $stock->articles) }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        @error('articles')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantité -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantité *</label>
                        <input type="number" name="quantite" value="{{ old('quantite', $stock->quantite) }}" step="0.01" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        @error('quantite')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prix Unitaire -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prix Unitaire *</label>
                        <input type="number" name="prix_unitaire" value="{{ old('prix_unitaire', $stock->prix_unitaire) }}" step="0.01" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        @error('prix_unitaire')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Entrée -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Entrée (Réception)</label>
                        <input type="number" name="entree" value="{{ old('entree', $stock->entree) }}" step="0.01" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                        <p class="text-xs text-gray-500 mt-1">Quantité reçue en stock</p>
                        @error('entree')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sortie -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sortie (Utilisation)</label>
                        <input type="number" name="sortie" value="{{ old('sortie', $stock->sortie) }}" step="0.01" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500">
                        <p class="text-xs text-gray-500 mt-1">Quantité sortie du stock</p>
                        @error('sortie')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Destination -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Destination</label>
                        <input type="text" name="destination" value="{{ old('destination', $stock->destination) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Pour les sorties seulement</p>
                        @error('destination')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fournisseur -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fournisseur</label>
                        <input type="text" name="fournisseur" value="{{ old('fournisseur', $stock->fournisseur) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        @error('fournisseur')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Filiale -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filiale</label>
                        <select name="filiale_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">Maison Mère</option>
                            @foreach($filiales as $filiale)
                                <option value="{{ $filiale->id }}" {{ old('filiale_id', $stock->filiale_id) == $filiale->id ? 'selected' : '' }}>
                                    {{ $filiale->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('filiale_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Agence -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Agence</label>
                        <select name="agence_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">Aucune</option>
                            @foreach($agences as $agence)
                                <option value="{{ $agence->id }}" {{ old('agence_id', $stock->agence_id) == $agence->id ? 'selected' : '' }}>
                                    {{ $agence->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('agence_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('stocks.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
