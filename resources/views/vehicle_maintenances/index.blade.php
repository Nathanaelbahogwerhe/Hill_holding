@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Maintenances Véhicules</h1>
        <a href="{{ route('vehicle_maintenances.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouvelle Maintenance
        </a>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Véhicule</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coût</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($vehicleMaintenances as $maintenance)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('vehicle_maintenances.show', $maintenance) }}" class="text-white hover:underline">{{ $maintenance->numero }}</a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-mono">{{ $maintenance->vehicle->immatriculation }}</span>
                    </td>
                    <td class="px-6 py-4">{{ ucfirst($maintenance->type_maintenance) }}</td>
                    <td class="px-6 py-4">{{ Str::limit($maintenance->description, 40) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($maintenance->date_maintenance)
                            {{ $maintenance->date_maintenance->format('d/m/Y') }}
                        @else
                            <span class="text-gray-400">Non effectuée</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($maintenance->cout)
                            {{ number_format($maintenance->cout, 0, ',', ' ') }} FCFA
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($maintenance->statut === 'planifiee') bg-gradient-to-r from-blue-900/50 to-blue-800/50 border border-blue-500/30 text-blue-300
                            @elseif($maintenance->statut === 'en_cours') bg-yellow-100 text-yellow-800
                            @elseif($maintenance->statut === 'terminee') bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($maintenance->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('vehicle_maintenances.show', $maintenance) }}" class="text-white hover:underline">Voir</a>
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
        {{ $vehicleMaintenances->links() }}
    </div>
</div>
@endsection
