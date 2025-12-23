@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Nouveau Contrat Fournisseur</h1>
        <p class="text-neutral-400">Enregistrer un contrat avec un fournisseur</p>
    </div>

    <form action="{{ route('supplier_contracts.store') }}" method="POST" class="bg-white rounded-xl shadow p-6">
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
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Fournisseur <span class="text-red-500">*</span></label>
                <select name="supplier_id" class="form-select w-full @error('supplier_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->nom }}</option>
                    @endforeach
                </select>
                @error('supplier_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Objet <span class="text-red-500">*</span></label>
                <input type="text" name="objet" value="{{ old('objet') }}" class="form-input w-full @error('objet') border-red-500 @enderror" required>
                @error('objet')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Description</label>
                <textarea name="description" rows="4" class="form-input w-full @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Date Début <span class="text-red-500">*</span></label>
                <input type="date" name="date_debut" value="{{ old('date_debut', date('Y-m-d')) }}" class="form-input w-full @error('date_debut') border-red-500 @enderror" required>
                @error('date_debut')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Date Fin <span class="text-red-500">*</span></label>
                <input type="date" name="date_fin" value="{{ old('date_fin') }}" class="form-input w-full @error('date_fin') border-red-500 @enderror" required>
                @error('date_fin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Montant (FCFA)</label>
                <input type="number" name="montant" value="{{ old('montant') }}" class="form-input w-full @error('montant') border-red-500 @enderror" step="0.01" min="0">
                @error('montant')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Fréquence Paiement</label>
                <select name="frequence_paiement" class="form-select w-full @error('frequence_paiement') border-red-500 @enderror">
                    <option value="">Sélectionner</option>
                    <option value="mensuel" {{ old('frequence_paiement') == 'mensuel' ? 'selected' : '' }}>Mensuel</option>
                    <option value="trimestriel" {{ old('frequence_paiement') == 'trimestriel' ? 'selected' : '' }}>Trimestriel</option>
                    <option value="semestriel" {{ old('frequence_paiement') == 'semestriel' ? 'selected' : '' }}>Semestriel</option>
                    <option value="annuel" {{ old('frequence_paiement') == 'annuel' ? 'selected' : '' }}>Annuel</option>
                    <option value="ponctuel" {{ old('frequence_paiement') == 'ponctuel' ? 'selected' : '' }}>Ponctuel</option>
                </select>
                @error('frequence_paiement')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Renouvellement Automatique</label>
                <select name="renouvellement_automatique" class="form-select w-full @error('renouvellement_automatique') border-red-500 @enderror">
                    <option value="0" {{ old('renouvellement_automatique') == '0' ? 'selected' : '' }}>Non</option>
                    <option value="1" {{ old('renouvellement_automatique') == '1' ? 'selected' : '' }}>Oui</option>
                </select>
                @error('renouvellement_automatique')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Préavis Résiliation (jours)</label>
                <input type="number" name="preavis_resiliation_jours" value="{{ old('preavis_resiliation_jours', 30) }}" class="form-input w-full @error('preavis_resiliation_jours') border-red-500 @enderror" min="0">
                @error('preavis_resiliation_jours')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Conditions Particulières</label>
                <textarea name="conditions" rows="3" class="form-input w-full @error('conditions') border-red-500 @enderror">{{ old('conditions') }}</textarea>
                @error('conditions')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Remarques</label>
                <textarea name="remarques" rows="2" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('supplier_contracts.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
