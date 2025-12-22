@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Nouvelle Mission</h1>
        <p class="text-gray-600">Planifier une nouvelle mission de déplacement</p>
    </div>

    <form action="{{ route('missions.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
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

            {{-- Véhicule --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Véhicule <span class="text-red-500">*</span></label>
                <select name="vehicle_id" class="form-select w-full @error('vehicle_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id', request('vehicle_id')) == $vehicle->id ? 'selected' : '' }}>
                        {{ $vehicle->immatriculation }} - {{ $vehicle->marque }} {{ $vehicle->modele }}
                    </option>
                    @endforeach
                </select>
                @error('vehicle_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Conducteur --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Conducteur <span class="text-red-500">*</span></label>
                <select name="conducteur_id" class="form-select w-full @error('conducteur_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($conducteurs as $conducteur)
                    <option value="{{ $conducteur->id }}" {{ old('conducteur_id') == $conducteur->id ? 'selected' : '' }}>{{ $conducteur->name }}</option>
                    @endforeach
                </select>
                @error('conducteur_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Demandeur --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Demandeur <span class="text-red-500">*</span></label>
                <select name="demandeur_id" class="form-select w-full @error('demandeur_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('demandeur_id', auth()->id()) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('demandeur_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Destination --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Destination <span class="text-red-500">*</span></label>
                <input type="text" name="destination" value="{{ old('destination') }}" class="form-input w-full @error('destination') border-red-500 @enderror" required>
                @error('destination')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Motif --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Motif <span class="text-red-500">*</span></label>
                <textarea name="motif" rows="3" class="form-input w-full @error('motif') border-red-500 @enderror" required>{{ old('motif') }}</textarea>
                @error('motif')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Date Début --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date & Heure Début <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="date_debut" value="{{ old('date_debut') }}" class="form-input w-full @error('date_debut') border-red-500 @enderror" required>
                @error('date_debut')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Date Fin Prévue --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date & Heure Fin Prévue</label>
                <input type="datetime-local" name="date_fin_prevue" value="{{ old('date_fin_prevue') }}" class="form-input w-full @error('date_fin_prevue') border-red-500 @enderror">
                @error('date_fin_prevue')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Distance Estimée --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Distance Estimée (km)</label>
                <input type="number" name="distance_km" value="{{ old('distance_km') }}" class="form-input w-full @error('distance_km') border-red-500 @enderror" step="0.01" min="0">
                @error('distance_km')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Kilométrage Départ --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kilométrage Départ</label>
                <input type="number" name="kilometrage_depart" value="{{ old('kilometrage_depart') }}" class="form-input w-full @error('kilometrage_depart') border-red-500 @enderror" min="0">
                @error('kilometrage_depart')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Passagers --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Passagers (JSON)</label>
                <textarea name="passagers" rows="3" class="form-input w-full @error('passagers') border-red-500 @enderror" placeholder='[{"nom": "Nom Prénom", "fonction": "Fonction"}]'>{{ old('passagers') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Format JSON: [{"nom": "Jean Dupont", "fonction": "Directeur"}]</p>
                @error('passagers')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Montant Carburant Prévu --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Montant Carburant Prévu (FCFA)</label>
                <input type="number" name="montant_carburant" value="{{ old('montant_carburant') }}" class="form-input w-full @error('montant_carburant') border-red-500 @enderror" step="0.01" min="0">
                @error('montant_carburant')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Autres Frais --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Autres Frais (FCFA)</label>
                <input type="number" name="autres_frais" value="{{ old('autres_frais') }}" class="form-input w-full @error('autres_frais') border-red-500 @enderror" step="0.01" min="0">
                @error('autres_frais')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Remarques --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarques</label>
                <textarea name="remarques" rows="2" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('missions.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
