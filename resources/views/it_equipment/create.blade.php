@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Nouvel Équipement IT</h1>
        <p class="text-gray-600">Enregistrer un nouvel équipement informatique</p>
    </div>

    <form action="{{ route('it_equipment.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filiale <span class="text-red-500">*</span></label>
                <select name="filiale_id" class="form-select w-full @error('filiale_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($filiales as $filiale)
                    <option value="{{ $filiale->id }}" {{ old('filiale_id') == $filiale->id ? 'selected' : '' }}>{{ $filiale->nom }}</option>
                    @endforeach
                </select>
                @error('filiale_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Agence</label>
                <select name="agence_id" class="form-select w-full @error('agence_id') border-red-500 @enderror">
                    <option value="">Sélectionner</option>
                    @foreach($agences as $agence)
                    <option value="{{ $agence->id }}" {{ old('agence_id') == $agence->id ? 'selected' : '' }}>{{ $agence->nom }}</option>
                    @endforeach
                </select>
                @error('agence_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                <select name="type" class="form-select w-full @error('type') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    <option value="ordinateur" {{ old('type') == 'ordinateur' ? 'selected' : '' }}>Ordinateur</option>
                    <option value="portable" {{ old('type') == 'portable' ? 'selected' : '' }}>Portable</option>
                    <option value="serveur" {{ old('type') == 'serveur' ? 'selected' : '' }}>Serveur</option>
                    <option value="imprimante" {{ old('type') == 'imprimante' ? 'selected' : '' }}>Imprimante</option>
                    <option value="scanner" {{ old('type') == 'scanner' ? 'selected' : '' }}>Scanner</option>
                    <option value="switch" {{ old('type') == 'switch' ? 'selected' : '' }}>Switch</option>
                    <option value="routeur" {{ old('type') == 'routeur' ? 'selected' : '' }}>Routeur</option>
                    <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut <span class="text-red-500">*</span></label>
                <select name="statut" class="form-select w-full @error('statut') border-red-500 @enderror" required>
                    <option value="disponible" {{ old('statut', 'disponible') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="en_service" {{ old('statut') == 'en_service' ? 'selected' : '' }}>En Service</option>
                    <option value="en_reparation" {{ old('statut') == 'en_reparation' ? 'selected' : '' }}>En Réparation</option>
                    <option value="hors_service" {{ old('statut') == 'hors_service' ? 'selected' : '' }}>Hors Service</option>
                    <option value="reforme" {{ old('statut') == 'reforme' ? 'selected' : '' }}>Réformé</option>
                </select>
                @error('statut')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                <input type="text" name="marque" value="{{ old('marque') }}" class="form-input w-full @error('marque') border-red-500 @enderror" placeholder="HP, Dell, Lenovo...">
                @error('marque')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Modèle</label>
                <input type="text" name="modele" value="{{ old('modele') }}" class="form-input w-full @error('modele') border-red-500 @enderror">
                @error('modele')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de Série</label>
                <input type="text" name="numero_serie" value="{{ old('numero_serie') }}" class="form-input w-full @error('numero_serie') border-red-500 @enderror">
                @error('numero_serie')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Processeur</label>
                <input type="text" name="processeur" value="{{ old('processeur') }}" class="form-input w-full @error('processeur') border-red-500 @enderror" placeholder="Intel Core i5, AMD Ryzen...">
                @error('processeur')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">RAM</label>
                <input type="text" name="ram" value="{{ old('ram') }}" class="form-input w-full @error('ram') border-red-500 @enderror" placeholder="8GB, 16GB...">
                @error('ram')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Disque Dur</label>
                <input type="text" name="disque_dur" value="{{ old('disque_dur') }}" class="form-input w-full @error('disque_dur') border-red-500 @enderror" placeholder="256GB SSD, 1TB HDD...">
                @error('disque_dur')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Système d'Exploitation</label>
                <input type="text" name="systeme_exploitation" value="{{ old('systeme_exploitation') }}" class="form-input w-full @error('systeme_exploitation') border-red-500 @enderror" placeholder="Windows 11, macOS...">
                @error('systeme_exploitation')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Utilisateur</label>
                <select name="utilisateur_id" class="form-select w-full @error('utilisateur_id') border-red-500 @enderror">
                    <option value="">Non attribué</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('utilisateur_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('utilisateur_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Attribution</label>
                <input type="date" name="date_attribution" value="{{ old('date_attribution') }}" class="form-input w-full @error('date_attribution') border-red-500 @enderror">
                @error('date_attribution')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Localisation</label>
                <input type="text" name="localisation" value="{{ old('localisation') }}" class="form-input w-full @error('localisation') border-red-500 @enderror" placeholder="Bureau, Salle serveur...">
                @error('localisation')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Acquisition</label>
                <input type="date" name="date_acquisition" value="{{ old('date_acquisition') }}" class="form-input w-full @error('date_acquisition') border-red-500 @enderror">
                @error('date_acquisition')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prix Acquisition (FCFA)</label>
                <input type="number" name="prix_acquisition" value="{{ old('prix_acquisition') }}" class="form-input w-full @error('prix_acquisition') border-red-500 @enderror" step="0.01" min="0">
                @error('prix_acquisition')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
                <select name="supplier_id" class="form-select w-full @error('supplier_id') border-red-500 @enderror">
                    <option value="">Sélectionner</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->nom }}</option>
                    @endforeach
                </select>
                @error('supplier_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Fin Garantie</label>
                <input type="date" name="date_fin_garantie" value="{{ old('date_fin_garantie') }}" class="form-input w-full @error('date_fin_garantie') border-red-500 @enderror">
                @error('date_fin_garantie')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">État</label>
                <select name="etat" class="form-select w-full @error('etat') border-red-500 @enderror">
                    <option value="excellent" {{ old('etat') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                    <option value="bon" {{ old('etat', 'bon') == 'bon' ? 'selected' : '' }}>Bon</option>
                    <option value="moyen" {{ old('etat') == 'moyen' ? 'selected' : '' }}>Moyen</option>
                    <option value="mauvais" {{ old('etat') == 'mauvais' ? 'selected' : '' }}>Mauvais</option>
                </select>
                @error('etat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Configuration Détaillée</label>
                <textarea name="configuration_details" rows="3" class="form-input w-full @error('configuration_details') border-red-500 @enderror">{{ old('configuration_details') }}</textarea>
                @error('configuration_details')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarques</label>
                <textarea name="remarques" rows="2" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('it_equipment.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
