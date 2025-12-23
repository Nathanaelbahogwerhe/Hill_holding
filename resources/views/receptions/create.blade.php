@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Nouvelle Réception</h1>
        <p class="text-neutral-400">Enregistrer la réception de marchandises</p>
    </div>

    <form action="{{ route('receptions.store') }}" method="POST" class="bg-white rounded-xl shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Bon de Commande <span class="text-red-500">*</span></label>
                <select name="purchase_order_id" class="form-select w-full @error('purchase_order_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($purchaseOrders as $order)
                    <option value="{{ $order->id }}" {{ old('purchase_order_id') == $order->id ? 'selected' : '' }}>
                        {{ $order->numero }} - {{ $order->supplier->nom }} ({{ number_format($order->montant_ttc, 0, ',', ' ') }} FCFA)
                    </option>
                    @endforeach
                </select>
                @error('purchase_order_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Date Réception <span class="text-red-500">*</span></label>
                <input type="date" name="date_reception" value="{{ old('date_reception', date('Y-m-d')) }}" class="form-input w-full @error('date_reception') border-red-500 @enderror" required>
                @error('date_reception')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Réceptionné Par <span class="text-red-500">*</span></label>
                <select name="receptionnaire_id" class="form-select w-full @error('receptionnaire_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('receptionnaire_id', auth()->id()) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('receptionnaire_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Conformité <span class="text-red-500">*</span></label>
                <select name="conformite" class="form-select w-full @error('conformite') border-red-500 @enderror" required>
                    <option value="en_attente" {{ old('conformite', 'en_attente') == 'en_attente' ? 'selected' : '' }}>En Attente</option>
                    <option value="conforme" {{ old('conformite') == 'conforme' ? 'selected' : '' }}>Conforme</option>
                    <option value="avec_reserves" {{ old('conformite') == 'avec_reserves' ? 'selected' : '' }}>Avec Réserves</option>
                    <option value="non_conforme" {{ old('conformite') == 'non_conforme' ? 'selected' : '' }}>Non Conforme</option>
                </select>
                @error('conformite')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Quantité Commandée</label>
                <input type="number" name="quantite_commandee" value="{{ old('quantite_commandee') }}" class="form-input w-full @error('quantite_commandee') border-red-500 @enderror" min="0">
                @error('quantite_commandee')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Quantité Reçue</label>
                <input type="number" name="quantite_recue" value="{{ old('quantite_recue') }}" class="form-input w-full @error('quantite_recue') border-red-500 @enderror" min="0">
                @error('quantite_recue')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Remarques</label>
                <textarea name="remarques" rows="3" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Réserves (si applicable)</label>
                <textarea name="reserves" rows="3" class="form-input w-full @error('reserves') border-red-500 @enderror">{{ old('reserves') }}</textarea>
                @error('reserves')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('receptions.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
