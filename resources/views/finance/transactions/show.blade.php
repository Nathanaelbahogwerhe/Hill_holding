@extends('layouts.app')

@section('title', 'ðŸ’³ DÃ©tails Transaction')

@section('content')
<div class="bg-hh-card dark:bg-hh-gray-dark rounded-lg shadow p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">ðŸ’³ DÃ©tails Transaction</h2>

    <div class="space-y-3">
        <div><strong>RÃ©fÃ©rence :</strong> {{ $transaction->reference }}</div>
        <div><strong>Type :</strong> {{ ucfirst($transaction->type) }}</div>
        <div><strong>Montant :</strong> {{ number_format($transaction->amount, 2, ',', ' ') }}</div>
        <div><strong>Date :</strong> {{ $transaction->transaction_date->format('d/m/Y') }}</div>
        <div><strong>CatÃ©gorie :</strong> {{ $transaction->category ?? 'â€”' }}</div>
        <div><strong>Description :</strong> {{ $transaction->description ?? 'â€”' }}</div>
        <div><strong>Utilisateur :</strong> {{ $transaction->user->name ?? 'â€”' }}</div>
    </div>

    <div class="mt-4 flex justify-end space-x-2">
        <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Retour</a>
        <a href="{{ route('transactions.edit', $transaction) }}" class="px-4 py-2 bg-hh-primary text-white rounded hover:bg-hh-primary-dark">Modifier</a>
    </div>
</div>
@endsection







