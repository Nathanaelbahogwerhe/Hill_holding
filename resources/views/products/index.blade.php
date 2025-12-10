@extends('layouts.app')

@section('title', 'Produits')

@section('content')
<div class="bg-white dark:bg-hh-gray-dark shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Liste des produits</h1>
        <a href="{{ route('products.create') }}" 
           class="bg-hh-blue hover:bg-hh-blue-dark text-white px-4 py-2 rounded">
           + Nouveau produit
        </a>
    </div>

    <table class="min-w-full border border-gray-200 dark:border-hh-gray-darker text-left">
        <thead class="bg-hh-gray-light dark:bg-hh-gray-darker">
            <tr>
                <th class="p-2">#</th>
                <th class="p-2">Nom</th>
                <th class="p-2">CatÃ©gorie</th>
                <th class="p-2">Fournisseur</th>
                <th class="p-2">Prix</th>
                <th class="p-2">Stock</th>
                <th class="p-2 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr class="border-t dark:border-hh-gray-dark hover:bg-hh-gray-light/50 dark:hover:bg-hh-gray-darker/50">
                    <td class="p-2">{{ $loop->iteration }}</td>
                    <td class="p-2">{{ $product->name }}</td>
                    <td class="p-2">{{ $product->category }}</td>
                    <td class="p-2">{{ $product->supplier?->name ?? '-' }}</td>
                    <td class="p-2">{{ number_format($product->price, 2) }} {{ config('app.currency', 'USD') }}</td>
                    <td class="p-2">{{ $product->stock }}</td>
                    <td class="p-2 text-right space-x-2">
                        <a href="{{ route('products.show', $product) }}" class="text-hh-blue">Voir</a>
                        <a href="{{ route('products.edit', $product) }}" class="text-hh-green">Modifier</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500" onclick="return confirm('Supprimer ce produit ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection







