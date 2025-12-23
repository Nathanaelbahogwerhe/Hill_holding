@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Nouvel Équipement</h1>
        <p class="text-neutral-400">Enregistrer un nouvel équipement dans l'inventaire</p>
    </div>

    <form action="{{ route('equipment.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Filiale --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Filiale <span class="text-red-500">*</span></label>
                <select name="filiale_id" class="form-select w-full @error('filiale_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($filiales as $filiale)
                    <option value="{{ $filiale->id }}" {{ old('filiale_id') == $filiale->id ? 'selected' : '' }}>{{ $filiale->nom }}</option>
                    @endforeach
                </select>
                @error('filiale_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Service --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Service</label>
                <select name="service_id" class="form-select w-full @error('service_id') border-red-500 @enderror">
                    <option value="">Sélectionner</option>
                    @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->nom }}</option>
                    @endforeach
                </select>
                @error('service_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Nom --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Nom <span class="text-red-500">*</span></label>
                <input type="text" name="nom" value="{{ old('nom') }}" class="form-input w-full @error('nom') border-red-500 @enderror" required>
                @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Catégorie --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Catégorie <span class="text-red-500">*</span></label>
                <select name="categorie" class="form-select w-full @error('categorie') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    <option value="informatique" {{ old('categorie') == 'informatique' ? 'selected' : '' }}>Informatique</option>
                    <option value="production" {{ old('categorie') == 'production' ? 'selected' : '' }}>Production</option>
                    <option value="bureau" {{ old('categorie') == 'bureau' ? 'selected' : '' }}>Bureau</option>
                    <option value="vehicule" {{ old('categorie') == 'vehicule' ? 'selected' : '' }}>Véhicule</option>
                    <option value="autre" {{ old('categorie') == 'autre' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('categorie')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Marque --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Marque</label>
                <input type="text" name="marque" value="{{ old('marque') }}" class="form-input w-full @error('marque') border-red-500 @enderror">
                @error('marque')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Modèle --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Modèle</label>
                <input type="text" name="modele" value="{{ old('modele') }}" class="form-input w-full @error('modele') border-red-500 @enderror">
                @error('modele')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Numéro de Série --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Numéro de Série</label>
                <input type="text" name="numero_serie" value="{{ old('numero_serie') }}" class="form-input w-full @error('numero_serie') border-red-500 @enderror">
                @error('numero_serie')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Fournisseur --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Fournisseur</label>
                <select name="supplier_id" class="form-select w-full @error('supplier_id') border-red-500 @enderror">
                    <option value="">Sélectionner</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->nom }}</option>
                    @endforeach
                </select>
                @error('supplier_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Date d'Acquisition --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Date d'Acquisition <span class="text-red-500">*</span></label>
                <input type="date" name="date_acquisition" value="{{ old('date_acquisition') }}" class="form-input w-full @error('date_acquisition') border-red-500 @enderror" required>
                @error('date_acquisition')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Prix d'Acquisition --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Prix d'Acquisition (FCFA)</label>
                <input type="number" name="prix_acquisition" value="{{ old('prix_acquisition') }}" class="form-input w-full @error('prix_acquisition') border-red-500 @enderror" step="0.01" min="0">
                @error('prix_acquisition')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Date Fin Garantie --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Date Fin Garantie</label>
                <input type="date" name="date_fin_garantie" value="{{ old('date_fin_garantie') }}" class="form-input w-full @error('date_fin_garantie') border-red-500 @enderror">
                @error('date_fin_garantie')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Durée Vie Estimée --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Durée de Vie Estimée (années)</label>
                <input type="number" name="duree_vie_estimee_annees" value="{{ old('duree_vie_estimee_annees', 5) }}" class="form-input w-full @error('duree_vie_estimee_annees') border-red-500 @enderror" min="1">
                @error('duree_vie_estimee_annees')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Affectation --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Affecté à</label>
                <select name="affectation_id" class="form-select w-full @error('affectation_id') border-red-500 @enderror">
                    <option value="">Non affecté</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('affectation_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('affectation_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Statut --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Statut <span class="text-red-500">*</span></label>
                <select name="statut" class="form-select w-full @error('statut') border-red-500 @enderror" required>
                    <option value="en_service" {{ old('statut', 'en_service') == 'en_service' ? 'selected' : '' }}>En Service</option>
                    <option value="en_maintenance" {{ old('statut') == 'en_maintenance' ? 'selected' : '' }}>En Maintenance</option>
                    <option value="hors_service" {{ old('statut') == 'hors_service' ? 'selected' : '' }}>Hors Service</option>
                    <option value="reforme" {{ old('statut') == 'reforme' ? 'selected' : '' }}>Réformé</option>
                </select>
                @error('statut')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Localisation --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Localisation</label>
                <input type="text" name="localisation" value="{{ old('localisation') }}" class="form-input w-full @error('localisation') border-red-500 @enderror" placeholder="Bâtiment, bureau, salle...">
                @error('localisation')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Description --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Description</label>
                <textarea name="description" rows="3" class="form-input w-full @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Remarques --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Remarques</label>
                <textarea name="remarques" rows="2" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- File Upload Component --}}
            <div class="md:col-span-2">
                <x-file-upload :model="null" route="equipment" label="Pièces jointes (factures, photos, manuels)" />
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('equipment.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
