@extends('layouts.app')

@section('title', 'DÃ©tails Vente')

@section('content')
<div class="bg-white dark:bg-hh-gray-dark shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-semibold mb-4">DÃ©tails de la vente</h1>

    <div class="space-y-2">
        <p><strong>Client :</strong> {{ $sale->client->name ?? '-' }}</p>
        <p><strong>Produit/Service :</strong> {{ $sale->product->name ?? $sale->service->name ?? '-' }}</p>
        <p><strong>QuantitÃ© :</strong> {{ $sale->quantity }}</p>
        <p><strong>Prix unitaire :</strong> {{ number_format($sale->unit_price, 2) }}</p>
        <p><strong>Total :</strong> {{ number_format($sale->total_amount, 2) }} {{ config('app.currency', 'USD') }}</p>
        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}</p>
    </div>

    <div class="flex justify-end mt-4 space-x-2">
        <a href="{{ route('sales.edit', $sale) }}" class="bg-hh-green hover:bg-hh-green-dark text-white px-4 py-2 rounded">Modifier</a>
        <a href="{{ route('sales.index') }}" class="bg-hh-gray hover:bg-hh-gray-dark text-white px-4 py-2 rounded">Retour</a>
    </div>
</div>
@endsection







