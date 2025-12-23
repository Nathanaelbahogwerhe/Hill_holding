@extends('layouts.app')

@section('title', 'Détails Achat')

@section('content')
<div class="bg-white dark:bg-hh-gray-dark shadow-md rounded-xl p-6">
    <h1 class="text-2xl font-semibold mb-4">Détails de l’achat</h1>

    <div class="space-y-2">
        <p><strong>Fournisseur :</strong> {{ $purchase->supplier->name ?? '-' }}</p>
        <p><strong>Produit :</strong> {{ $purchase->product->name ?? '-' }}</p>
        <p><strong>Quantité :</strong> {{ $purchase->quantity }}</p>
        <p><strong>Prix unitaire :</strong> {{ number_format($purchase->unit_price, 2) }}</p>
        <p><strong>Total :</strong> {{ number_format($purchase->total_amount, 2) }} {{ config('app.currency', 'USD') }}</p>
        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($purchase->date)->format('d/m/Y') }}</p>
    </div>

    <div class="flex justify-end mt-4 space-x-2">
        <a href="{{ route('purchases.edit', $purchase) }}" class="bg-hh-green hover:bg-hh-green-dark text-white px-4 py-2 rounded">Modifier</a>
        <a href="{{ route('purchases.index') }}" class="bg-hh-gray hover:bg-hh-gray-dark text-white px-4 py-2 rounded">Retour</a>
    </div>
</div>
@endsection




