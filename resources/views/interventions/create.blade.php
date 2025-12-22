@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Nouvelle Intervention</h1>
        <p class="text-gray-600">Enregistrer une intervention technique</p>
    </div>

    <form action="{{ route('interventions.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Équipement <span class="text-red-500">*</span></label>
                <select name="equipment_id" class="form-select w-full @error('equipment_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($equipment as $item)
                    <option value="{{ $item->id }}" {{ old('equipment_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->code }} - {{ $item->nom }}
                    </option>
                    @endforeach
                </select>
                @error('equipment_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            @if(isset($breakdowns) && count($breakdowns) > 0)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Liée à une Panne</label>
                <select name="breakdown_id" class="form-select w-full @error('breakdown_id') border-red-500 @enderror">
                    <option value="">Non liée</option>
                    @foreach($breakdowns as $breakdown)
                    <option value="{{ $breakdown->id }}" {{ old('breakdown_id') == $breakdown->id ? 'selected' : '' }}>
                        {{ $breakdown->numero }} - {{ $breakdown->description }}
                    </option>
                    @endforeach
                </select>
                @error('breakdown_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Technicien <span class="text-red-500">*</span></label>
                <select name="technicien_id" class="form-select w-full @error('technicien_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($techniciens as $tech)
                    <option value="{{ $tech->id }}" {{ old('technicien_id') == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                    @endforeach
                </select>
                @error('technicien_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Intervention <span class="text-red-500">*</span></label>
                <input type="date" name="date_intervention" value="{{ old('date_intervention', date('Y-m-d')) }}" class="form-input w-full @error('date_intervention') border-red-500 @enderror" required>
                @error('date_intervention')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="form-input w-full @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Durée (heures)</label>
                <input type="number" name="duree_heures" value="{{ old('duree_heures') }}" class="form-input w-full @error('duree_heures') border-red-500 @enderror" step="0.5" min="0">
                @error('duree_heures')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Coût (FCFA)</label>
                <input type="number" name="cout" value="{{ old('cout') }}" class="form-input w-full @error('cout') border-red-500 @enderror" step="0.01" min="0">
                @error('cout')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Actions Réalisées</label>
                <textarea name="actions_realisees" rows="3" class="form-input w-full @error('actions_realisees') border-red-500 @enderror">{{ old('actions_realisees') }}</textarea>
                @error('actions_realisees')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pièces Utilisées</label>
                <textarea name="pieces_utilisees" rows="2" class="form-input w-full @error('pieces_utilisees') border-red-500 @enderror">{{ old('pieces_utilisees') }}</textarea>
                @error('pieces_utilisees')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarques</label>
                <textarea name="remarques" rows="2" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('interventions.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
