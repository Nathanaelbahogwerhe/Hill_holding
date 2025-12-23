@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Missions</h1>
        <a href="{{ route('missions.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouvelle Mission
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-neutral-400">Total</p>
            <p class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-neutral-400">Planifiées</p>
            <p class="text-2xl font-bold text-white">{{ $stats['planifiee'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-neutral-400">En Cours</p>
            <p class="text-2xl font-bold text-white">{{ $stats['en_cours'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-neutral-400">Terminées</p>
            <p class="text-2xl font-bold text-neutral-400">{{ $stats['terminee'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-neutral-400">Annulées</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['annulee'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-xl shadow mb-6 p-4">
        <form method="GET" action="{{ route('missions.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Filiale</label>
                <select name="filiale_id" class="form-select w-full">
                    <option value="">Toutes</option>
                    @foreach($filiales as $filiale)
                    <option value="{{ $filiale->id }}" {{ request('filiale_id') == $filiale->id ? 'selected' : '' }}>{{ $filiale->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Véhicule</label>
                <select name="vehicle_id" class="form-select w-full">
                    <option value="">Tous</option>
                    @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}" {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->immatriculation }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Statut</label>
                <select name="statut" class="form-select w-full">
                    <option value="">Tous</option>
                    <option value="planifiee" {{ request('statut') == 'planifiee' ? 'selected' : '' }}>Planifiée</option>
                    <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En Cours</option>
                    <option value="terminee" {{ request('statut') == 'terminee' ? 'selected' : '' }}>Terminée</option>
                    <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Recherche</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-input w-full" placeholder="Numéro, destination...">
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary mr-2">Filtrer</button>
                <a href="{{ route('missions.index') }}" class="btn-secondary">Réinitialiser</a>
            </div>
        </form>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Véhicule</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Conducteur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Destination</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date Début</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Distance</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($missions as $mission)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('missions.show', $mission) }}" class="text-white hover:underline">{{ $mission->numero }}</a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-mono">{{ $mission->vehicle->immatriculation }}</span>
                    </td>
                    <td class="px-6 py-4">{{ $mission->conducteur->name }}</td>
                    <td class="px-6 py-4">{{ Str::limit($mission->destination, 40) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $mission->date_debut->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($mission->distance_km)
                            {{ $mission->distance_km }} km
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($mission->statut === 'planifiee') bg-gradient-to-r from-blue-900/50 to-blue-800/50 border border-blue-500/30 text-blue-300
                            @elseif($mission->statut === 'en_cours') bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300
                            @elseif($mission->statut === 'terminee') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($mission->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('missions.show', $mission) }}" class="text-white hover:underline mr-3">Voir</a>
                        @if($mission->statut === 'planifiee')
                        <form action="{{ route('missions.destroy', $mission) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">Aucune mission trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $missions->links() }}
    </div>
</div>
@endsection
