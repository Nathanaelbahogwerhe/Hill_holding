@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-black text-white rounded-2xl shadow-lg border border-yellow-600 p-6 mt-8">

    <h1 class="text-3xl font-bold text-yellow-500 mb-2">💰 Création d’un Budget</h1>
    <p class="text-gray-400 mb-6">
        Définir un budget par projet, filiale et agence
    </p>

    <form method="POST" action="{{ route('budgets.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Titre --}}
        <div>
            <label class="text-yellow-400 font-semibold">Titre du Budget *</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                   class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2"
                   placeholder="Ex: Budget Marketing Q1 2025">
            @error('title')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Catégorie --}}
        <div>
            <label class="text-yellow-400 font-semibold">Catégorie *</label>
            <select name="category" required class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2">
                <option value="">— Sélectionner —</option>
                <option value="Salaires" @selected(old('category')=='Salaires')>💰 Salaires</option>
                <option value="Marketing" @selected(old('category')=='Marketing')>📢 Marketing</option>
                <option value="Infrastructure" @selected(old('category')=='Infrastructure')>🏢 Infrastructure</option>
                <option value="Formation" @selected(old('category')=='Formation')>📚 Formation</option>
                <option value="Equipement" @selected(old('category')=='Equipement')>🖥️ Équipement</option>
                <option value="Déplacements" @selected(old('category')=='Déplacements')>✈️ Déplacements</option>
                <option value="Maintenance" @selected(old('category')=='Maintenance')>🔧 Maintenance</option>
                <option value="Autres" @selected(old('category')=='Autres')>📦 Autres</option>
            </select>
            @error('category')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Filiale --}}
        <div>
            <label class="text-yellow-400 font-semibold">Filiale *</label>
            <select name="filiale_id" class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2">
                @foreach($filiales as $filiale)
                    <option value="{{ $filiale->id }}" @selected(old('filiale_id')==$filiale->id)>
                        {{ $filiale->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Agence --}}
        <div>
            <label class="text-yellow-400 font-semibold">Agence (optionnel)</label>
            <select name="agence_id" class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2">
                <option value="">— Toutes —</option>
                @foreach($agences as $agence)
                    <option value="{{ $agence->id }}" @selected(old('agence_id')==$agence->id)>
                        {{ $agence->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Montant --}}
        <div>
            <label class="text-yellow-400 font-semibold">Montant du Budget (FBu) *</label>
            <input type="number" name="amount" value="{{ old('amount') }}" required min="0" step="0.01"
                   class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2"
                   placeholder="Ex: 5000000">
            @error('amount')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Dates --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-yellow-400 font-semibold">Date de début *</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" required
                       class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2">
                @error('start_date')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-yellow-400 font-semibold">Date de fin *</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" required
                       class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2">
                @error('end_date')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Description --}}
        <div>
            <label class="text-yellow-400 font-semibold">Description</label>
            <textarea name="description" rows="3"
                      class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2"
                      placeholder="Détails sur l'utilisation prévue de ce budget...">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Statut --}}
        <div>
            <label class="text-yellow-400 font-semibold">Statut</label>
            <select name="status" class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2">
                <option value="active" @selected(old('status', 'active')=='active')>✓ Actif</option>
                <option value="inactive" @selected(old('status')=='inactive')>○ Inactif</option>
            </select>
        </div>

        {{-- Pièce jointe --}}
        <div>
            <label class="text-yellow-400 font-semibold">Document joint (optionnel)</label>
            <input type="file" name="attachment" 
                   accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                   class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2 text-gray-300">
            <p class="text-xs text-gray-400 mt-1">Formats: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (max 10MB)</p>
            @error('attachment')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('budgets.index') }}"
               class="bg-gray-700 px-5 py-2 rounded">Annuler</a>
            <button class="bg-yellow-500 text-black font-semibold px-6 py-2 rounded">
                💾 Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
