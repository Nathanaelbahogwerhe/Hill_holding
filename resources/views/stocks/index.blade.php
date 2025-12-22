@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 text-white">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-yellow-500">📦 Gestion de Stock</h1>
            <p class="text-gray-400 text-sm">Mouvements d'entrée et de sortie de stock</p>
        </div>

        <a href="{{ route('stocks.create') }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-5 py-2 rounded-lg shadow">
            ➕ Nouveau mouvement
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-green-900 to-green-800 border border-green-600 rounded-xl p-4">
            <div class="text-sm text-green-300">Total Entrées</div>
            <div class="text-2xl font-bold">{{ number_format($stats['total_entrees'], 0, ',', ' ') }}</div>
        </div>
        <div class="bg-gradient-to-br from-red-900 to-red-800 border border-red-600 rounded-xl p-4">
            <div class="text-sm text-red-300">Total Sorties</div>
            <div class="text-2xl font-bold">{{ number_format($stats['total_sorties'], 0, ',', ' ') }}</div>
        </div>
        <div class="bg-gradient-to-br from-blue-900 to-blue-800 border border-blue-600 rounded-xl p-4">
            <div class="text-sm text-blue-300">Valeur Stock</div>
            <div class="text-2xl font-bold">{{ number_format($stats['valeur_stock'], 0, ',', ' ') }} FBu</div>
        </div>
    </div>

    {{-- Filtres --}}
    <form method="GET" class="bg-gray-900 border border-yellow-600 rounded-xl p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="text-sm text-yellow-400">Article</label>
            <input type="text" name="article" value="{{ request('article') }}"
                   class="w-full bg-black border border-gray-700 rounded px-3 py-2"
                   placeholder="Nom de l'article">
        </div>

        <div>
            <label class="text-sm text-yellow-400">Fournisseur</label>
            <input type="text" name="fournisseur" value="{{ request('fournisseur') }}"
                   class="w-full bg-black border border-gray-700 rounded px-3 py-2"
                   placeholder="Nom du fournisseur">
        </div>

        <div>
            <label class="text-sm text-yellow-400">Type</label>
            <select name="type" class="w-full bg-black border border-gray-700 rounded px-3 py-2">
                <option value="">Tous</option>
                <option value="entree" @selected(request('type') === 'entree')>Entrées</option>
                <option value="sortie" @selected(request('type') === 'sortie')>Sorties</option>
            </select>
        </div>

        <div>
            <label class="text-sm text-yellow-400">Date début</label>
            <input type="date" name="date_debut" value="{{ request('date_debut') }}"
                   class="w-full bg-black border border-gray-700 rounded px-3 py-2">
        </div>

        <div>
            <label class="text-sm text-yellow-400">Date fin</label>
            <input type="date" name="date_fin" value="{{ request('date_fin') }}"
                   class="w-full bg-black border border-gray-700 rounded px-3 py-2">
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded">
                🔍 Filtrer
            </button>
            <a href="{{ route('stocks.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded">
                ❌ Réinitialiser
            </a>
        </div>
    </form>

    {{-- Tableau --}}
    <div class="bg-gray-900 border border-yellow-600 rounded-xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-yellow-500 text-black">
                <tr>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Article</th>
                    <th class="px-4 py-3 text-center">Quantité</th>
                    <th class="px-4 py-3 text-right">Prix Unit.</th>
                    <th class="px-4 py-3 text-center">Entrée</th>
                    <th class="px-4 py-3 text-center">Sortie</th>
                    <th class="px-4 py-3 text-center">Solde</th>
                    <th class="px-4 py-3 text-left">Fournisseur</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($stocks as $stock)
                <tr class="hover:bg-gray-800">
                    <td class="px-4 py-3">{{ $stock->date->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 font-semibold">{{ $stock->articles }}</td>
                    <td class="px-4 py-3 text-center">{{ number_format($stock->quantite, 0) }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($stock->prix_unitaire, 0) }} FBu</td>
                    <td class="px-4 py-3 text-center">
                        @if($stock->entree > 0)
                            <span class="bg-green-600 text-white px-2 py-1 rounded text-xs">
                                +{{ number_format($stock->entree, 0) }}
                            </span>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($stock->sortie > 0)
                            <span class="bg-red-600 text-white px-2 py-1 rounded text-xs">
                                -{{ number_format($stock->sortie, 0) }}
                            </span>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="font-bold {{ $stock->solde > 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ number_format($stock->solde, 0) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $stock->fournisseur ?? '-' }}</td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('stocks.show', $stock) }}" class="text-blue-400 hover:underline text-xs">Voir</a>
                        <a href="{{ route('stocks.edit', $stock) }}" class="text-yellow-400 hover:underline text-xs">Modifier</a>
                        <form method="POST" action="{{ route('stocks.destroy', $stock) }}" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Supprimer ce mouvement ?')"
                                    class="text-red-500 hover:underline text-xs">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-6 text-gray-500">Aucun mouvement de stock trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $stocks->links() }}
    </div>

</div>
@endsection
