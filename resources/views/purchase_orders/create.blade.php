@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Nouveau Bon de Commande</h1>
        <p class="text-gray-600">Créer un bon de commande fournisseur</p>
    </div>

    <form action="{{ route('purchase_orders.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fournisseur <span class="text-red-500">*</span></label>
                <select name="supplier_id" class="form-select w-full @error('supplier_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->nom }}</option>
                    @endforeach
                </select>
                @error('supplier_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            @if(isset($purchaseRequest))
            <div class="md:col-span-2 bg-blue-50 p-3 rounded">
                <p class="text-sm text-blue-800">Lié à la demande d'achat: <strong>{{ $purchaseRequest->numero }}</strong></p>
                <input type="hidden" name="purchase_request_id" value="{{ $purchaseRequest->id }}">
            </div>
            @endif

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Objet <span class="text-red-500">*</span></label>
                <input type="text" name="objet" value="{{ old('objet', $purchaseRequest->objet ?? '') }}" class="form-input w-full @error('objet') border-red-500 @enderror" required>
                @error('objet')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="form-input w-full @error('description') border-red-500 @enderror" required>{{ old('description', $purchaseRequest->description ?? '') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Montant HT (FCFA) <span class="text-red-500">*</span></label>
                <input type="number" name="montant_ht" value="{{ old('montant_ht') }}" class="form-input w-full @error('montant_ht') border-red-500 @enderror" required step="0.01" min="0" id="montant_ht" oninput="calculateTTC()">
                @error('montant_ht')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Taux TVA (%)</label>
                <input type="number" name="taux_tva" value="{{ old('taux_tva', 18) }}" class="form-input w-full @error('taux_tva') border-red-500 @enderror" step="0.01" min="0" max="100" id="taux_tva" oninput="calculateTTC()">
                @error('taux_tva')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Montant TTC (FCFA)</label>
                <input type="number" name="montant_ttc" value="{{ old('montant_ttc') }}" class="form-input w-full bg-gray-50 @error('montant_ttc') border-red-500 @enderror" step="0.01" min="0" id="montant_ttc" readonly>
                @error('montant_ttc')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Commande <span class="text-red-500">*</span></label>
                <input type="date" name="date_commande" value="{{ old('date_commande', date('Y-m-d')) }}" class="form-input w-full @error('date_commande') border-red-500 @enderror" required>
                @error('date_commande')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Livraison Prévue</label>
                <input type="date" name="date_livraison_prevue" value="{{ old('date_livraison_prevue') }}" class="form-input w-full @error('date_livraison_prevue') border-red-500 @enderror">
                @error('date_livraison_prevue')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mode de Paiement</label>
                <select name="mode_paiement" class="form-select w-full @error('mode_paiement') border-red-500 @enderror">
                    <option value="">Sélectionner</option>
                    <option value="cheque" {{ old('mode_paiement') == 'cheque' ? 'selected' : '' }}>Chèque</option>
                    <option value="virement" {{ old('mode_paiement') == 'virement' ? 'selected' : '' }}>Virement</option>
                    <option value="especes" {{ old('mode_paiement') == 'especes' ? 'selected' : '' }}>Espèces</option>
                    <option value="carte" {{ old('mode_paiement') == 'carte' ? 'selected' : '' }}>Carte</option>
                </select>
                @error('mode_paiement')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Conditions de Paiement</label>
                <textarea name="conditions_paiement" rows="2" class="form-input w-full @error('conditions_paiement') border-red-500 @enderror">{{ old('conditions_paiement') }}</textarea>
                @error('conditions_paiement')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarques</label>
                <textarea name="remarques" rows="2" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('purchase_orders.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</div>

<script>
function calculateTTC() {
    const ht = parseFloat(document.getElementById('montant_ht').value) || 0;
    const tva = parseFloat(document.getElementById('taux_tva').value) || 0;
    const ttc = ht * (1 + tva / 100);
    document.getElementById('montant_ttc').value = ttc.toFixed(2);
}
</script>
@endsection
