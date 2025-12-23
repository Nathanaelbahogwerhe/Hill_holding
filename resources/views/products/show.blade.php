@extends('layouts.app')

@section('title', 'Détails Produit')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-blue-400">
            📦 Détails Produit
        </h1>
        <div class="space-x-2">
            <a href="{{ route('products.edit', $product->id) }}" class="px-4 py-2 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold text-white rounded-xl font-bold">
                 Éditer
            </a>
            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-xl">
                 Retour
            </a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="bg-slate-900 rounded-xl shadow-xl p-8 border border-slate-700 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-blue-400 text-sm uppercase font-semibold mb-1">ID</p>
                <p class="text-lg text-white">{{ $product->id }}</p>
            </div>
            
            <div>
                <p class="text-blue-400 text-sm uppercase font-semibold mb-1">Nom</p>
                <p class="text-lg text-white">{{ $product->name ?? $product->first_name ?? 'N/A' }}</p>
            </div>
            
            <div>
                <p class="text-blue-400 text-sm uppercase font-semibold mb-1">Créé le</p>
                <p class="text-lg text-white">{{ $product->created_at?->format('d/m/Y H:i') ?? 'N/A' }}</p>
            </div>
            
            <div>
                <p class="text-blue-400 text-sm uppercase font-semibold mb-1">Mis à jour le</p>
                <p class="text-lg text-white">{{ $product->updated_at?->format('d/m/Y H:i') ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Delete Button -->
    <div class="bg-slate-900 rounded-xl shadow-xl p-6 border border-slate-700">
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression définitive?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold transition">
                 Supprimer
            </button>
        </form>
    </div>
</div>
@endsection