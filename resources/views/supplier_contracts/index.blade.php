@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Contrats Fournisseurs</h1>
        <a href="{{ route('supplier_contracts.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouveau Contrat
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Actifs</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['actif'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Expirés</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['expire'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Résiliés</p>
            <p class="text-2xl font-bold text-gray-600">{{ $stats['resilie'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Expire Bientôt</p>
            <p class="text-2xl font-bold text-orange-600">{{ $stats['expire_soon'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Référence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fournisseur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Objet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date Fin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($supplierContracts as $contract)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('supplier_contracts.show', $contract) }}" class="text-blue-600 hover:underline">{{ $contract->reference }}</a>
                    </td>
                    <td class="px-6 py-4">{{ $contract->supplier->nom }}</td>
                    <td class="px-6 py-4">{{ Str::limit($contract->objet, 40) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($contract->montant)
                            {{ number_format($contract->montant, 0, ',', ' ') }} FCFA
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $contract->date_fin->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($contract->statut === 'actif') bg-green-100 text-green-800
                            @elseif($contract->statut === 'expire') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($contract->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('supplier_contracts.show', $contract) }}" class="text-blue-600 hover:underline">Voir</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Aucun contrat trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $supplierContracts->links() }}
    </div>
</div>
@endsection
