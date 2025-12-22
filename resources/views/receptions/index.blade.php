@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Réceptions</h1>
        <a href="{{ route('receptions.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouvelle Réception
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">En Attente</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['en_attente'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Conformes</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['conforme'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Avec Réserves</p>
            <p class="text-2xl font-bold text-orange-600">{{ $stats['avec_reserves'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bon Commande</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fournisseur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date Réception</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Conformité</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($receptions as $reception)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('receptions.show', $reception) }}" class="text-blue-600 hover:underline">{{ $reception->numero }}</a>
                    </td>
                    <td class="px-6 py-4">{{ $reception->purchaseOrder->numero }}</td>
                    <td class="px-6 py-4">{{ $reception->purchaseOrder->supplier->nom }}</td>
                    <td class="px-6 py-4">{{ $reception->date_reception->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($reception->conformite === 'en_attente') bg-blue-100 text-blue-800
                            @elseif($reception->conformite === 'conforme') bg-green-100 text-green-800
                            @elseif($reception->conformite === 'avec_reserves') bg-orange-100 text-orange-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ str_replace('_', ' ', ucfirst($reception->conformite)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('receptions.show', $reception) }}" class="text-blue-600 hover:underline">Voir</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Aucune réception trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $receptions->links() }}
    </div>
</div>
@endsection
