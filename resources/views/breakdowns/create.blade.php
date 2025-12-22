@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Signaler une Panne</h1>
        <p class="text-gray-600">Enregistrer une nouvelle panne d'équipement</p>
    </div>

    <form action="{{ route('breakdowns.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Équipement <span class="text-red-500">*</span></label>
                <select name="equipment_id" class="form-select w-full @error('equipment_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($equipment as $item)
                    <option value="{{ $item->id }}" {{ old('equipment_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->code }} - {{ $item->nom }} ({{ $item->marque }} {{ $item->modele }})
                    </option>
                    @endforeach
                </select>
                @error('equipment_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date & Heure de la Panne <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="date_panne" value="{{ old('date_panne', date('Y-m-d\TH:i')) }}" class="form-input w-full @error('date_panne') border-red-500 @enderror" required>
                @error('date_panne')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Signalée Par <span class="text-red-500">*</span></label>
                <select name="signale_par_id" class="form-select w-full @error('signale_par_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('signale_par_id', auth()->id()) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('signale_par_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description de la Panne <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="form-input w-full @error('description') border-red-500 @enderror" required placeholder="Décrivez la panne en détail...">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sévérité <span class="text-red-500">*</span></label>
                <select name="severite" class="form-select w-full @error('severite') border-red-500 @enderror" required>
                    <option value="mineure" {{ old('severite') == 'mineure' ? 'selected' : '' }}>Mineure</option>
                    <option value="moyenne" {{ old('severite', 'moyenne') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                    <option value="majeure" {{ old('severite') == 'majeure' ? 'selected' : '' }}>Majeure</option>
                    <option value="critique" {{ old('severite') == 'critique' ? 'selected' : '' }}>Critique</option>
                </select>
                @error('severite')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Impact sur Production</label>
                <select name="impact_production" class="form-select w-full @error('impact_production') border-red-500 @enderror">
                    <option value="0" {{ old('impact_production', '0') == '0' ? 'selected' : '' }}>Non</option>
                    <option value="1" {{ old('impact_production') == '1' ? 'selected' : '' }}>Oui</option>
                </select>
                @error('impact_production')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cause Probable</label>
                <textarea name="cause_probable" rows="2" class="form-input w-full @error('cause_probable') border-red-500 @enderror">{{ old('cause_probable') }}</textarea>
                @error('cause_probable')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarques</label>
                <textarea name="remarques" rows="2" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('breakdowns.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Signaler</button>
        </div>
    </form>
</div>
@endsection
