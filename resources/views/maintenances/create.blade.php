@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Nouvelle Maintenance</h1>
        <p class="text-gray-600">Planifier une maintenance préventive ou corrective</p>
    </div>

    <form action="{{ route('maintenances.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Équipement <span class="text-red-500">*</span></label>
                <select name="equipment_id" class="form-select w-full @error('equipment_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($equipment as $item)
                    <option value="{{ $item->id }}" {{ old('equipment_id', request('equipment_id')) == $item->id ? 'selected' : '' }}>
                        {{ $item->code }} - {{ $item->nom }} ({{ $item->marque }} {{ $item->modele }})
                    </option>
                    @endforeach
                </select>
                @error('equipment_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                <select name="type" class="form-select w-full @error('type') border-red-500 @enderror" required>
                    <option value="preventive" {{ old('type', 'preventive') == 'preventive' ? 'selected' : '' }}>Préventive</option>
                    <option value="corrective" {{ old('type') == 'corrective' ? 'selected' : '' }}>Corrective</option>
                </select>
                @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Maintenance <span class="text-red-500">*</span></label>
                <input type="date" name="date_maintenance" value="{{ old('date_maintenance', date('Y-m-d')) }}" class="form-input w-full @error('date_maintenance') border-red-500 @enderror" required>
                @error('date_maintenance')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="form-input w-full @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Technicien</label>
                <select name="technicien_id" class="form-select w-full @error('technicien_id') border-red-500 @enderror">
                    <option value="">Non assigné</option>
                    @foreach($techniciens as $tech)
                    <option value="{{ $tech->id }}" {{ old('technicien_id') == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                    @endforeach
                </select>
                @error('technicien_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Coût Estimé (FCFA)</label>
                <input type="number" name="cout" value="{{ old('cout') }}" class="form-input w-full @error('cout') border-red-500 @enderror" step="0.01" min="0">
                @error('cout')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Durée Estimée (heures)</label>
                <input type="number" name="duree_estimee" value="{{ old('duree_estimee') }}" class="form-input w-full @error('duree_estimee') border-red-500 @enderror" step="0.5" min="0">
                @error('duree_estimee')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Durée Réelle (heures)</label>
                <input type="number" name="duree_reelle" value="{{ old('duree_reelle') }}" class="form-input w-full @error('duree_reelle') border-red-500 @enderror" step="0.5" min="0">
                @error('duree_reelle')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pièces Remplacées</label>
                <textarea name="pieces_remplacees" rows="2" class="form-input w-full @error('pieces_remplacees') border-red-500 @enderror" placeholder="Liste des pièces...">{{ old('pieces_remplacees') }}</textarea>
                @error('pieces_remplacees')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarques</label>
                <textarea name="remarques" rows="2" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('maintenances.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
