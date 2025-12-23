@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Nouvelle Demande Support IT</h1>
        <p class="text-neutral-400">Créer une demande d'intervention technique</p>
    </div>

    <form action="{{ route('it_interventions.store') }}" method="POST" class="bg-white rounded-xl shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Agence</label>
                <select name="agence_id" class="form-select w-full @error('agence_id') border-red-500 @enderror">
                    <option value="">Sélectionner</option>
                    @foreach($agences as $agence)
                    <option value="{{ $agence->id }}" {{ old('agence_id') == $agence->id ? 'selected' : '' }}>{{ $agence->nom }}</option>
                    @endforeach
                </select>
                @error('agence_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Type <span class="text-red-500">*</span></label>
                <select name="type" class="form-select w-full @error('type') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    <option value="installation" {{ old('type') == 'installation' ? 'selected' : '' }}>Installation</option>
                    <option value="configuration" {{ old('type') == 'configuration' ? 'selected' : '' }}>Configuration</option>
                    <option value="depannage" {{ old('type', 'depannage') == 'depannage' ? 'selected' : '' }}>Dépannage</option>
                    <option value="maintenance" {{ old('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="formation" {{ old('type') == 'formation' ? 'selected' : '' }}>Formation</option>
                    <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Priorité <span class="text-red-500">*</span></label>
                <select name="priorite" class="form-select w-full @error('priorite') border-red-500 @enderror" required>
                    <option value="basse" {{ old('priorite') == 'basse' ? 'selected' : '' }}>Basse</option>
                    <option value="normale" {{ old('priorite', 'normale') == 'normale' ? 'selected' : '' }}>Normale</option>
                    <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                    <option value="urgente" {{ old('priorite') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                </select>
                @error('priorite')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Équipement Concerné</label>
                <select name="it_equipment_id" class="form-select w-full @error('it_equipment_id') border-red-500 @enderror">
                    <option value="">Non applicable</option>
                    @foreach($itEquipment as $equipment)
                    <option value="{{ $equipment->id }}" {{ old('it_equipment_id') == $equipment->id ? 'selected' : '' }}>
                        {{ $equipment->numero }} - {{ $equipment->marque }} {{ $equipment->modele }}
                    </option>
                    @endforeach
                </select>
                @error('it_equipment_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Objet <span class="text-red-500">*</span></label>
                <input type="text" name="objet" value="{{ old('objet') }}" class="form-input w-full @error('objet') border-red-500 @enderror" required placeholder="Résumé du problème">
                @error('objet')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" class="form-input w-full @error('description') border-red-500 @enderror" required placeholder="Décrivez le problème en détail...">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Département</label>
                <select name="department_id" class="form-select w-full @error('department_id') border-red-500 @enderror">
                    <option value="">Sélectionner</option>
                    @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->nom }}</option>
                    @endforeach
                </select>
                @error('department_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Assigner à</label>
                <select name="technicien_id" class="form-select w-full @error('technicien_id') border-red-500 @enderror">
                    <option value="">Non assigné</option>
                    @foreach($techniciens as $tech)
                    <option value="{{ $tech->id }}" {{ old('technicien_id') == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                    @endforeach
                </select>
                @error('technicien_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Remarques</label>
                <textarea name="remarques" rows="2" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('it_interventions.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Créer la Demande</button>
        </div>
    </form>
</div>
@endsection
