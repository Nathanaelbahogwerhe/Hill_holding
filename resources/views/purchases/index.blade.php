@extends('layouts.app')

@section('title', 'Achats')

@section('content')
<div class="bg-white dark:bg-hh-gray-dark shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Liste des achats</h1>
        <a href="{{ route('purchases.create') }}" 
           class="bg-hh-blue hover:bg-hh-blue-dark text-white px-4 py-2 rounded">
           + Nouvel achat
        </a>
    </div>

    <table class="min-w-full border border-gray-200 dark:border-hh-gray-darker text-left">
        <thead class="bg-hh-gray-light dark:bg-hh-gray-darker">
            <tr>
                <th class="p-2">#</th>
                <th class="p-2">Fournisseur</th>
                <th class="p-2">Produit</th>
                <th class="p-2">Quantité</th>
                <th class="p-2">Montant total</th>
                <th class="p-2">Date</th>
                <th class="p-2 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchases as $purchase)
                <tr class="border-t dark:border-hh-gray-dark hover:bg-hh-gray-light/50 dark:hover:bg-hh-gray-darker/50">
                    <td class="p-2">{{ $loop->iteration }}</td>
                    <td class="p-2">{{ $purchase->supplier->name ?? '-' }}</td>
                    <td class="p-2">{{ $purchase->product->name ?? '-' }}</td>
                    <td class="p-2">{{ $purchase->quantity }}</td>
                    <td class="p-2">{{ number_format($purchase->total_amount, 2) }} {{ config('app.currency', 'USD') }}</td>
                    <td class="p-2">{{ \Carbon\Carbon::parse($purchase->date)->format('d/m/Y') }}</td>
                    <td class="p-2 text-right space-x-2">
                        <a href="{{ route('purchases.show', $purchase) }}" class="text-hh-blue">Voir</a>
                        <a href="{{ route('purchases.edit', $purchase) }}" class="text-hh-green">Modifier</a>
                        <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500" onclick="return confirm('Supprimer cet achat ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection




