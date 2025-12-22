@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Véhicules</h1>
        <a href="{{ route('vehicles.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouveau Véhicule
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Total</p>
            <p class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Disponibles</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['disponible'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">En Mission</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['en_mission'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">En Maintenance</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['en_maintenance'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Assurance Expirée</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['assurance_expiree'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Alertes --}}
    @if(isset($alertes) && count($alertes) > 0)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Alertes</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($alertes as $alerte)
                        <li>{{ $alerte }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Filtres --}}
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <form method="GET" action="{{ route('vehicles.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="form-select w-full">
                    <option value="">Tous</option>
                    <option value="voiture" {{ request('type') == 'voiture' ? 'selected' : '' }}>Voiture</option>
                    <option value="camion" {{ request('type') == 'camion' ? 'selected' : '' }}>Camion</option>
                    <option value="moto" {{ request('type') == 'moto' ? 'selected' : '' }}>Moto</option>
                    <option value="utilitaire" {{ request('type') == 'utilitaire' ? 'selected' : '' }}>Utilitaire</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="statut" class="form-select w-full">
                    <option value="">Tous</option>
                    <option value="disponible" {{ request('statut') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="en_mission" {{ request('statut') == 'en_mission' ? 'selected' : '' }}>En Mission</option>
                    <option value="en_maintenance" {{ request('statut') == 'en_maintenance' ? 'selected' : '' }}>En Maintenance</option>
                    <option value="hors_service" {{ request('statut') == 'hors_service' ? 'selected' : '' }}>Hors Service</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-input w-full" placeholder="Immatriculation, marque...">
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary mr-2">Filtrer</button>
                <a href="{{ route('vehicles.index') }}" class="btn-secondary">Réinitialiser</a>
            </div>
        </form>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Immatriculation</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Véhicule</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Filiale</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Chauffeur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assurance</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visite Technique</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($vehicles as $vehicle)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('vehicles.show', $vehicle) }}" class="text-blue-600 hover:underline font-mono font-bold">
                            {{ $vehicle->immatriculation }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-medium">{{ $vehicle->marque }} {{ $vehicle->modele }}</p>
                            <p class="text-sm text-gray-500">{{ $vehicle->annee }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($vehicle->type) }}</td>
                    <td class="px-6 py-4">{{ $vehicle->filiale->nom }}</td>
                    <td class="px-6 py-4">
                        @if($vehicle->chauffeur)
                            {{ $vehicle->chauffeur->name }}
                        @else
                            <span class="text-gray-400">Non assigné</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($vehicle->statut === 'disponible') bg-green-100 text-green-800
                            @elseif($vehicle->statut === 'en_mission') bg-blue-100 text-blue-800
                            @elseif($vehicle->statut === 'en_maintenance') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ str_replace('_', ' ', ucfirst($vehicle->statut)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($vehicle->date_fin_assurance)
                            <span class="{{ !$vehicle->is_assurance_active ? 'text-red-600 font-bold' : '' }}">
                                {{ $vehicle->date_fin_assurance->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($vehicle->date_visite_technique)
                            {{ $vehicle->date_visite_technique->format('d/m/Y') }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('vehicles.show', $vehicle) }}" class="text-blue-600 hover:underline mr-3">Voir</a>
                        <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">Aucun véhicule trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $vehicles->links() }}
    </div>
</div>
@endsection
