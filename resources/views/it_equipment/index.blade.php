@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Parc Informatique</h1>
        <a href="{{ route('it_equipment.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouvel Équipement
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4">
            <div class="text-sm text-gray-500">Total</div>
            <div class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/30 rounded-xl shadow p-4">
            <div class="text-sm text-white">Disponible</div>
            <div class="text-2xl font-bold text-white">{{ $stats['disponible'] }}</div>
        </div>
        <div class="bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/30 rounded-xl shadow p-4">
            <div class="text-sm text-white">En Service</div>
            <div class="text-2xl font-bold text-white">{{ $stats['en_service'] }}</div>
        </div>
        <div class="bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/30 rounded-xl shadow p-4">
            <div class="text-sm text-white">En Réparation</div>
            <div class="text-2xl font-bold text-white">{{ $stats['en_reparation'] }}</div>
        </div>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Localisation</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($itEquipment as $equipment)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('it_equipment.show', $equipment) }}" class="text-white hover:underline font-mono">{{ $equipment->numero }}</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ ucfirst($equipment->type) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ $equipment->marque }} {{ $equipment->modele }}</div>
                        @if($equipment->numero_serie)
                        <div class="text-sm text-gray-500">S/N: {{ $equipment->numero_serie }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($equipment->utilisateur)
                            {{ $equipment->utilisateur->name }}
                        @else
                            <span class="text-gray-400">Non attribué</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $equipment->localisation ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded bg-{{ $equipment->statut_color }}-100 text-{{ $equipment->statut_color }}-800">
                            {{ ucfirst($equipment->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('it_equipment.show', $equipment) }}" class="text-white hover:underline">Voir</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Aucun équipement trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $itEquipment->links() }}
    </div>
</div>
@endsection
