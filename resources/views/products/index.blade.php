@extends('layouts.app')

@section('title', 'Produit - Liste')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">
                📦 Produit
            </h1>
            <p class="text-neutral-400 mt-2">Gérez vos produits</p>
        </div>
        <a href="{{ route('products.create') }}" class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter
        </a>
    </div>

    <!-- Messages -->
    @if (session('success'))
        <div class="bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-100 p-4 rounded-xl mb-6">
             {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-gradient-to-br from-neutral-900 to-black rounded-2xl shadow-2xl overflow-hidden border border-neutral-800">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-[#D4AF37] to-yellow-500">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-bold text-white">ID</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-white">Nom</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-white">SKU</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-white">Quantité</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-white">Stock</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-white">Statut</th>
                    <th class="px-6 py-4 text-right text-sm font-bold text-white">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-700">
                @forelse($products as $product)
                    <tr class="hover:bg-neutral-800/50 transition">
                        <td class="px-6 py-4 text-sm text-neutral-300">#{{ $product->id }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-white">
                            {{ $product->name ?? $product->first_name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="bg-gradient-to-r from-green-900/50 to-green-800/50 text-green-300 px-3 py-1 rounded-full text-xs font-semibold border border-green-500/30">
                                Actif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            <a href="{{ route('products.show', $product->id) }}" class="text-[#D4AF37] hover:text-yellow-500 font-bold"></a>
                            <a href="{{ route('products.edit', $product->id) }}" class="text-[#D4AF37] hover:text-yellow-500 font-bold"></a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 font-bold"></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            Aucun Produit trouvé
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination (si paginé) -->
    @if(method_exists($products, 'hasPages') && $products->hasPages())
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection