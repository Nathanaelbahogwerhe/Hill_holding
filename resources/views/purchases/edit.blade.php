@extends('layouts.app')

@section('title', 'Modifier Achat')

@section('content')
<div class="bg-white dark:bg-hh-gray-dark shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-semibold mb-4">Modifier l’achat</h1>

    <form action="{{ route('purchases.update', $purchase) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block font-medium">Fournisseur</label>
            <select name="supplier_id" class="w-full border rounded p-2 dark:bg-hh-gray-darker">
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" @selected($supplier->id == $purchase->supplier_id)>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Produit</label>
            <select name="product_id" class="w-full border rounded p-2 dark:bg-hh-gray-darker">
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" @selected($product->id == $purchase->product_id)>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Quantité</label>
            <input type="number" name="quantity" value="{{ $purchase->quantity }}" class="w-full border rounded p-2 dark:bg-hh-gray-darker">
        </div>

        <div>
            <label class="block font-medium">Prix unitaire</label>
            <input type="number" step="0.01" name="unit_price" value="{{ $purchase->unit_price }}" class="w-full border rounded p-2 dark:bg-hh-gray-darker">
        </div>

        <div>
            <label class="block font-medium">Date</label>
            <input type="date" name="date" value="{{ $purchase->date }}" class="w-full border rounded p-2 dark:bg-hh-gray-darker">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-hh-green hover:bg-hh-green-dark text-white px-4 py-2 rounded">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection




