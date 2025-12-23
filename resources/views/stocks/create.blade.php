@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 text-white">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-yellow-500">📦 Nouveau Mouvement de Stock</h1>
        <p class="text-gray-400 text-sm">Enregistrer une entrée ou sortie de stock</p>
    </div>

    <form method="POST" action="{{ route('stocks.store') }}" class="bg-gray-900 border border-yellow-600 rounded-xl p-6 space-y-6">
        @csrf

        {{-- Date --}}
        <div>
            <label class="block text-sm font-medium text-yellow-400 mb-2">Date *</label>
            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                   class="w-full bg-black border border-gray-700 rounded px-4 py-2 focus:border-yellow-500">
            @error('date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Article --}}
        <div>
            <label class="block text-sm font-medium text-yellow-400 mb-2">Article *</label>
            <input type="text" name="articles" value="{{ old('articles') }}" required
                   placeholder="Nom de l'article"
                   class="w-full bg-black border border-gray-700 rounded px-4 py-2 focus:border-yellow-500">
            @error('articles')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Quantité --}}
            <div>
                <label class="block text-sm font-medium text-yellow-400 mb-2">Quantité *</label>
                <input type="number" name="quantite" value="{{ old('quantite') }}" required step="0.01" min="0"
                       placeholder="0.00"
                       class="w-full bg-black border border-gray-700 rounded px-4 py-2 focus:border-yellow-500">
                @error('quantite')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Prix unitaire --}}
            <div>
                <label class="block text-sm font-medium text-yellow-400 mb-2">Prix Unitaire (FBu) *</label>
                <input type="number" name="prix_unitaire" value="{{ old('prix_unitaire') }}" required step="0.01" min="0"
                       placeholder="0.00"
                       class="w-full bg-black border border-gray-700 rounded px-4 py-2 focus:border-yellow-500">
                @error('prix_unitaire')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Type de mouvement --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-800 p-4 rounded">
            <div>
                <label class="block text-sm font-medium text-green-400 mb-2">Entrée (réception)</label>
                <input type="number" name="entree" value="{{ old('entree') }}" step="0.01" min="0"
                       placeholder="Quantité entrée"
                       class="w-full bg-black border border-gray-700 rounded px-4 py-2 focus:border-green-500">
                <p class="text-xs text-gray-400 mt-1">Laissez vide si c'est une sortie</p>
                @error('entree')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-red-400 mb-2">Sortie (utilisation)</label>
                <input type="number" name="sortie" value="{{ old('sortie') }}" step="0.01" min="0"
                       placeholder="Quantité sortie"
                       class="w-full bg-black border border-gray-700 rounded px-4 py-2 focus:border-red-500">
                <p class="text-xs text-gray-400 mt-1">Laissez vide si c'est une entrée</p>
                @error('sortie')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Destination (pour sortie) --}}
        <div>
            <label class="block text-sm font-medium text-yellow-400 mb-2">Destination</label>
            <input type="text" name="destination" value="{{ old('destination') }}"
                   placeholder="Destination (en cas de sortie)"
                   class="w-full bg-black border border-gray-700 rounded px-4 py-2 focus:border-yellow-500">
            <p class="text-xs text-gray-400 mt-1">Indiquer où va le stock (ex: Chantier X, Client Y, etc.)</p>
            @error('destination')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Fournisseur --}}
        <div>
            <label class="block text-sm font-medium text-yellow-400 mb-2">Fournisseur</label>
            <input type="text" name="fournisseur" value="{{ old('fournisseur') }}"
                   placeholder="Nom du fournisseur"
                   class="w-full bg-black border border-gray-700 rounded px-4 py-2 focus:border-yellow-500">
            @error('fournisseur')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Filiale --}}
            <div>
                <label class="block text-sm font-medium text-yellow-400 mb-2">Filiale</label>
                <select name="filiale_id" class="w-full bg-black border border-gray-700 rounded px-4 py-2">
                    <option value="">Sélectionner</option>
                    @foreach($filiales as $filiale)
                        <option value="{{ $filiale->id }}" @selected(old('filiale_id') == $filiale->id)>
                            {{ $filiale->name }}
                        </option>
                    @endforeach
                </select>
                @error('filiale_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Agence --}}
            <div>
                <label class="block text-sm font-medium text-yellow-400 mb-2">Agence</label>
                <select name="agence_id" class="w-full bg-black border border-gray-700 rounded px-4 py-2">
                    <option value="">Sélectionner</option>
                    @foreach($agences as $agence)
                        <option value="{{ $agence->id }}" @selected(old('agence_id') == $agence->id)>
                            {{ $agence->name }}
                        </option>
                    @endforeach
                </select>
                @error('agence_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Boutons --}}
        <div class="flex justify-between items-center pt-4 border-t border-gray-700">
            <a href="{{ route('stocks.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-xl">
                ← Annuler
            </a>
            <button type="submit" class="bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 hover:bg-yellow-600 text-black font-semibold px-6 py-2 rounded-xl">
                ✅ Enregistrer
            </button>
        </div>
    </form>

</div>
@endsection
