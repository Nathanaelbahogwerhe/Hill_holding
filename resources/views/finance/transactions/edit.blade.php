@extends('layouts.app')

@section('title', 'ðŸ’³ Modifier Transaction')

@section('content')
<div class="bg-hh-card dark:bg-hh-gray-dark rounded-lg shadow p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">ðŸ’³ Modifier Transaction</h2>

    <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block font-medium mb-1" for="reference">RÃ©fÃ©rence</label>
            <input type="text" name="reference" id="reference" value="{{ old('reference', $transaction->reference) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
            @error('reference') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1" for="type">Type</label>
            <select name="type" id="type" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
                <option value="expense" {{ old('type', $transaction->type) === 'expense' ? 'selected' : '' }}>DÃ©pense</option>
                <option value="revenue" {{ old('type', $transaction->type) === 'revenue' ? 'selected' : '' }}>Revenu</option>
            </select>
            @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1" for="amount">Montant</label>
            <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $transaction->amount) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
            @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1" for="transaction_date">Date</label>
            <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
            @error('transaction_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1" for="category">CatÃ©gorie</label>
            <input type="text" name="category" id="category" value="{{ old('category', $transaction->category) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
            @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1" for="description">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">{{ old('description', $transaction->description) }}</textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1" for="user_id">Utilisateur</label>
            <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
                <option value="">â€” SÃ©lectionner â€”</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $transaction->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Annuler</a>
            <button type="submit" class="px-4 py-2 bg-hh-primary text-white rounded hover:bg-hh-primary-dark">Mettre Ã  jour</button>
        </div>
    </form>
</div>
@endsection







