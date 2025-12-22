@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Bons de Commande</h1>
        <a href="{{ route('purchase_orders.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouveau Bon de Commande
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">En Attente</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['en_attente'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Validés</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['valide'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Livrés</p>
            <p class="text-2xl font-bold text-gray-600">{{ $stats['livre'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Annulés</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['annule'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <form method="GET" action="{{ route('purchase_orders.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filiale</label>
                <select name="filiale_id" class="form-select w-full">
                    <option value="">Toutes</option>
                    @foreach($filiales as $filiale)
                    <option value="{{ $filiale->id }}" {{ request('filiale_id') == $filiale->id ? 'selected' : '' }}>{{ $filiale->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
                <select name="supplier_id" class="form-select w-full">
                    <option value="">Tous</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="statut" class="form-select w-full">
                    <option value="">Tous</option>
                    <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En Attente</option>
                    <option value="valide" {{ request('statut') == 'valide' ? 'selected' : '' }}>Validé</option>
                    <option value="livre" {{ request('statut') == 'livre' ? 'selected' : '' }}>Livré</option>
                    <option value="annule" {{ request('statut') == 'annule' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary mr-2">Filtrer</button>
                <a href="{{ route('purchase_orders.index') }}" class="btn-secondary">Réinitialiser</a>
            </div>
        </form>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fournisseur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Objet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant TTC</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($purchaseOrders as $order)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('purchase_orders.show', $order) }}" class="text-blue-600 hover:underline">{{ $order->numero }}</a>
                    </td>
                    <td class="px-6 py-4">{{ $order->supplier->nom }}</td>
                    <td class="px-6 py-4">{{ Str::limit($order->objet, 40) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-bold">{{ number_format($order->montant_ttc, 0, ',', ' ') }} FCFA</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($order->statut === 'en_attente') bg-blue-100 text-blue-800
                            @elseif($order->statut === 'valide') bg-green-100 text-green-800
                            @elseif($order->statut === 'livre') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ str_replace('_', ' ', ucfirst($order->statut)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->date_commande->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('purchase_orders.show', $order) }}" class="text-blue-600 hover:underline mr-3">Voir</a>
                        @if($order->statut === 'en_attente')
                        <form action="{{ route('purchase_orders.destroy', $order) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Aucun bon de commande trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $purchaseOrders->links() }}
    </div>
</div>
@endsection
