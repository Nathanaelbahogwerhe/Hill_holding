@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Maintenances</h1>
        <a href="{{ route('maintenances.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouvelle Maintenance
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Planifiées</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['planifiee'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">En Cours</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['en_cours'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Terminées</p>
            <p class="text-2xl font-bold text-gray-600">{{ $stats['terminee'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Annulées</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['annulee'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coût</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($maintenances as $maintenance)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('maintenances.show', $maintenance) }}" class="text-blue-600 hover:underline">{{ $maintenance->numero }}</a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-mono">{{ $maintenance->equipment->code }}</span>
                        <p class="text-sm text-gray-500">{{ $maintenance->equipment->nom }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded {{ $maintenance->type === 'preventive' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                            {{ ucfirst($maintenance->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ Str::limit($maintenance->description, 40) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $maintenance->date_maintenance->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($maintenance->cout)
                            {{ number_format($maintenance->cout, 0, ',', ' ') }} FCFA
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($maintenance->statut === 'planifiee') bg-blue-100 text-blue-800
                            @elseif($maintenance->statut === 'en_cours') bg-green-100 text-green-800
                            @elseif($maintenance->statut === 'terminee') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($maintenance->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('maintenances.show', $maintenance) }}" class="text-blue-600 hover:underline">Voir</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">Aucune maintenance trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $maintenances->links() }}
    </div>
</div>
@endsection
