@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Nouvelle Maintenance Véhicule</h1>
        <p class="text-neutral-400">Planifier une maintenance de véhicule</p>
    </div>

    <form action="{{ route('vehicle_maintenances.store') }}" method="POST" class="bg-white rounded-xl shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Véhicule <span class="text-red-500">*</span></label>
                <select name="vehicle_id" class="form-select w-full @error('vehicle_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                        {{ $vehicle->immatriculation }} - {{ $vehicle->marque }} {{ $vehicle->modele }}
                    </option>
                    @endforeach
                </select>
                @error('vehicle_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Type Maintenance <span class="text-red-500">*</span></label>
                <select name="type_maintenance" class="form-select w-full @error('type_maintenance') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    <option value="vidange" {{ old('type_maintenance') == 'vidange' ? 'selected' : '' }}>Vidange</option>
                    <option value="revision" {{ old('type_maintenance') == 'revision' ? 'selected' : '' }}>Révision</option>
                    <option value="pneus" {{ old('type_maintenance') == 'pneus' ? 'selected' : '' }}>Pneus</option>
                    <option value="freins" {{ old('type_maintenance') == 'freins' ? 'selected' : '' }}>Freins</option>
                    <option value="batterie" {{ old('type_maintenance') == 'batterie' ? 'selected' : '' }}>Batterie</option>
                    <option value="climatisation" {{ old('type_maintenance') == 'climatisation' ? 'selected' : '' }}>Climatisation</option>
                    <option value="autre" {{ old('type_maintenance') == 'autre' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('type_maintenance')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Date Planifiée</label>
                <input type="date" name="date_planifiee" value="{{ old('date_planifiee') }}" class="form-input w-full @error('date_planifiee') border-red-500 @enderror">
                @error('date_planifiee')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Kilométrage Planifié</label>
                <input type="number" name="kilometrage_planifie" value="{{ old('kilometrage_planifie') }}" class="form-input w-full @error('kilometrage_planifie') border-red-500 @enderror" min="0">
                @error('kilometrage_planifie')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Date Réalisée</label>
                <input type="date" name="date_maintenance" value="{{ old('date_maintenance') }}" class="form-input w-full @error('date_maintenance') border-red-500 @enderror">
                @error('date_maintenance')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="form-input w-full @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Garage/Prestataire</label>
                <input type="text" name="garage" value="{{ old('garage') }}" class="form-input w-full @error('garage') border-red-500 @enderror">
                @error('garage')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Coût (FCFA)</label>
                <input type="number" name="cout" value="{{ old('cout') }}" class="form-input w-full @error('cout') border-red-500 @enderror" step="0.01" min="0">
                @error('cout')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Prochaine Échéance (km)</label>
                <input type="number" name="prochaine_echeance_km" value="{{ old('prochaine_echeance_km') }}" class="form-input w-full @error('prochaine_echeance_km') border-red-500 @enderror" min="0">
                @error('prochaine_echeance_km')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Prochaine Échéance (date)</label>
                <input type="date" name="prochaine_echeance_date" value="{{ old('prochaine_echeance_date') }}" class="form-input w-full @error('prochaine_echeance_date') border-red-500 @enderror">
                @error('prochaine_echeance_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Remarques</label>
                <textarea name="remarques" rows="2" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('vehicle_maintenances.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
