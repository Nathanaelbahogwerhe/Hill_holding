@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Nouveau Véhicule</h1>
        <p class="text-gray-600">Enregistrer un nouveau véhicule dans la flotte</p>
    </div>

    <form action="{{ route('vehicles.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Filiale --}}
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

            {{-- Service --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                <select name="service_id" class="form-select w-full @error('service_id') border-red-500 @enderror">
                    <option value="">Sélectionner</option>
                    @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->nom }}</option>
                    @endforeach
                </select>
                @error('service_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Immatriculation --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Immatriculation <span class="text-red-500">*</span></label>
                <input type="text" name="immatriculation" value="{{ old('immatriculation') }}" class="form-input w-full @error('immatriculation') border-red-500 @enderror" required placeholder="Ex: AA-123-BB">
                @error('immatriculation')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Type --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                <select name="type" class="form-select w-full @error('type') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    <option value="voiture" {{ old('type') == 'voiture' ? 'selected' : '' }}>Voiture</option>
                    <option value="camion" {{ old('type') == 'camion' ? 'selected' : '' }}>Camion</option>
                    <option value="moto" {{ old('type') == 'moto' ? 'selected' : '' }}>Moto</option>
                    <option value="utilitaire" {{ old('type') == 'utilitaire' ? 'selected' : '' }}>Utilitaire</option>
                </select>
                @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Marque --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Marque <span class="text-red-500">*</span></label>
                <input type="text" name="marque" value="{{ old('marque') }}" class="form-input w-full @error('marque') border-red-500 @enderror" required>
                @error('marque')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Modèle --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Modèle <span class="text-red-500">*</span></label>
                <input type="text" name="modele" value="{{ old('modele') }}" class="form-input w-full @error('modele') border-red-500 @enderror" required>
                @error('modele')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Année --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                <input type="number" name="annee" value="{{ old('annee', date('Y')) }}" class="form-input w-full @error('annee') border-red-500 @enderror" min="1900" max="{{ date('Y') + 1 }}">
                @error('annee')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Couleur --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Couleur</label>
                <input type="text" name="couleur" value="{{ old('couleur') }}" class="form-input w-full @error('couleur') border-red-500 @enderror">
                @error('couleur')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Numéro de Châssis --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de Châssis</label>
                <input type="text" name="numero_chassis" value="{{ old('numero_chassis') }}" class="form-input w-full @error('numero_chassis') border-red-500 @enderror">
                @error('numero_chassis')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Kilométrage Initial --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kilométrage Initial</label>
                <input type="number" name="kilometrage_initial" value="{{ old('kilometrage_initial', 0) }}" class="form-input w-full @error('kilometrage_initial') border-red-500 @enderror" min="0">
                @error('kilometrage_initial')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Capacité Carburant --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Capacité Réservoir (L)</label>
                <input type="number" name="capacite_reservoir" value="{{ old('capacite_reservoir') }}" class="form-input w-full @error('capacite_reservoir') border-red-500 @enderror" step="0.01" min="0">
                @error('capacite_reservoir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Consommation Moyenne --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Consommation Moyenne (L/100km)</label>
                <input type="number" name="consommation_moyenne" value="{{ old('consommation_moyenne') }}" class="form-input w-full @error('consommation_moyenne') border-red-500 @enderror" step="0.1" min="0">
                @error('consommation_moyenne')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Chauffeur --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Chauffeur Attitré</label>
                <select name="chauffeur_id" class="form-select w-full @error('chauffeur_id') border-red-500 @enderror">
                    <option value="">Non assigné</option>
                    @foreach($chauffeurs as $chauffeur)
                    <option value="{{ $chauffeur->id }}" {{ old('chauffeur_id') == $chauffeur->id ? 'selected' : '' }}>{{ $chauffeur->name }}</option>
                    @endforeach
                </select>
                @error('chauffeur_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Statut --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut <span class="text-red-500">*</span></label>
                <select name="statut" class="form-select w-full @error('statut') border-red-500 @enderror" required>
                    <option value="disponible" {{ old('statut', 'disponible') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="en_mission" {{ old('statut') == 'en_mission' ? 'selected' : '' }}>En Mission</option>
                    <option value="en_maintenance" {{ old('statut') == 'en_maintenance' ? 'selected' : '' }}>En Maintenance</option>
                    <option value="hors_service" {{ old('statut') == 'hors_service' ? 'selected' : '' }}>Hors Service</option>
                </select>
                @error('statut')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Date Début Assurance --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Début Assurance</label>
                <input type="date" name="date_debut_assurance" value="{{ old('date_debut_assurance') }}" class="form-input w-full @error('date_debut_assurance') border-red-500 @enderror">
                @error('date_debut_assurance')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Date Fin Assurance --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Fin Assurance</label>
                <input type="date" name="date_fin_assurance" value="{{ old('date_fin_assurance') }}" class="form-input w-full @error('date_fin_assurance') border-red-500 @enderror">
                @error('date_fin_assurance')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Compagnie Assurance --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Compagnie d'Assurance</label>
                <input type="text" name="compagnie_assurance" value="{{ old('compagnie_assurance') }}" class="form-input w-full @error('compagnie_assurance') border-red-500 @enderror">
                @error('compagnie_assurance')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Date Visite Technique --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Visite Technique</label>
                <input type="date" name="date_visite_technique" value="{{ old('date_visite_technique') }}" class="form-input w-full @error('date_visite_technique') border-red-500 @enderror">
                @error('date_visite_technique')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Remarques --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarques</label>
                <textarea name="remarques" rows="3" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('vehicles.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
