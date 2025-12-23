@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Nouvelle Licence Logiciel</h1>
        <p class="text-neutral-400">Enregistrer une nouvelle licence</p>
    </div>

    <form action="{{ route('software_licenses.store') }}" method="POST" class="bg-white rounded-xl shadow p-6">
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
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Nom Logiciel <span class="text-red-500">*</span></label>
                <input type="text" name="nom_logiciel" value="{{ old('nom_logiciel') }}" class="form-input w-full @error('nom_logiciel') border-red-500 @enderror" required placeholder="Microsoft Office, Adobe...">
                @error('nom_logiciel')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Éditeur</label>
                <input type="text" name="editeur" value="{{ old('editeur') }}" class="form-input w-full @error('editeur') border-red-500 @enderror" placeholder="Microsoft, Adobe, Oracle...">
                @error('editeur')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Version</label>
                <input type="text" name="version" value="{{ old('version') }}" class="form-input w-full @error('version') border-red-500 @enderror" placeholder="2024, 12.5...">
                @error('version')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Type <span class="text-red-500">*</span></label>
                <select name="type" class="form-select w-full @error('type') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    <option value="os" {{ old('type') == 'os' ? 'selected' : '' }}>OS</option>
                    <option value="bureautique" {{ old('type') == 'bureautique' ? 'selected' : '' }}>Bureautique</option>
                    <option value="antivirus" {{ old('type') == 'antivirus' ? 'selected' : '' }}>Antivirus</option>
                    <option value="developpement" {{ old('type') == 'developpement' ? 'selected' : '' }}>Développement</option>
                    <option value="comptabilite" {{ old('type') == 'comptabilite' ? 'selected' : '' }}>Comptabilité</option>
                    <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Type Licence <span class="text-red-500">*</span></label>
                <select name="type_licence" class="form-select w-full @error('type_licence') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    <option value="perpetuelle" {{ old('type_licence') == 'perpetuelle' ? 'selected' : '' }}>Perpétuelle</option>
                    <option value="abonnement" {{ old('type_licence', 'abonnement') == 'abonnement' ? 'selected' : '' }}>Abonnement</option>
                    <option value="volume" {{ old('type_licence') == 'volume' ? 'selected' : '' }}>Volume</option>
                    <option value="oem" {{ old('type_licence') == 'oem' ? 'selected' : '' }}>OEM</option>
                </select>
                @error('type_licence')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Numéro Licence</label>
                <input type="text" name="numero_licence" value="{{ old('numero_licence') }}" class="form-input w-full @error('numero_licence') border-red-500 @enderror">
                @error('numero_licence')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Clé Activation</label>
                <input type="text" name="cle_activation" value="{{ old('cle_activation') }}" class="form-input w-full @error('cle_activation') border-red-500 @enderror">
                @error('cle_activation')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Nombre Postes <span class="text-red-500">*</span></label>
                <input type="number" name="nombre_postes" value="{{ old('nombre_postes', 1) }}" class="form-input w-full @error('nombre_postes') border-red-500 @enderror" required min="1">
                @error('nombre_postes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Postes Utilisés</label>
                <input type="number" name="postes_utilises" value="{{ old('postes_utilises', 0) }}" class="form-input w-full @error('postes_utilises') border-red-500 @enderror" min="0">
                @error('postes_utilises')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Date Achat</label>
                <input type="date" name="date_achat" value="{{ old('date_achat') }}" class="form-input w-full @error('date_achat') border-red-500 @enderror">
                @error('date_achat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Date Expiration</label>
                <input type="date" name="date_expiration" value="{{ old('date_expiration') }}" class="form-input w-full @error('date_expiration') border-red-500 @enderror">
                @error('date_expiration')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Coût (FCFA)</label>
                <input type="number" name="cout" value="{{ old('cout') }}" class="form-input w-full @error('cout') border-red-500 @enderror" step="0.01" min="0">
                @error('cout')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Période Facturation</label>
                <select name="periode_facturation" class="form-select w-full @error('periode_facturation') border-red-500 @enderror">
                    <option value="">Sélectionner</option>
                    <option value="mensuel" {{ old('periode_facturation') == 'mensuel' ? 'selected' : '' }}>Mensuel</option>
                    <option value="annuel" {{ old('periode_facturation') == 'annuel' ? 'selected' : '' }}>Annuel</option>
                    <option value="unique" {{ old('periode_facturation') == 'unique' ? 'selected' : '' }}>Paiement Unique</option>
                </select>
                @error('periode_facturation')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Statut <span class="text-red-500">*</span></label>
                <select name="statut" class="form-select w-full @error('statut') border-red-500 @enderror" required>
                    <option value="active" {{ old('statut', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expiree" {{ old('statut') == 'expiree' ? 'selected' : '' }}>Expirée</option>
                    <option value="resiliee" {{ old('statut') == 'resiliee' ? 'selected' : '' }}>Résiliée</option>
                </select>
                @error('statut')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

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

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Remarques</label>
                <textarea name="remarques" rows="3" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('software_licenses.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
