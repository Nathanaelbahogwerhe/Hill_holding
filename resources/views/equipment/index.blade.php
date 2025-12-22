@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Équipements</h1>
        <a href="{{ route('equipment.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouvel Équipement
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Total</p>
            <p class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">En Service</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['en_service'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">En Maintenance</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['en_maintenance'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Hors Service</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['hors_service'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Maint. à Planifier</p>
            <p class="text-2xl font-bold text-orange-600">{{ $stats['maintenance_due'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <form method="GET" action="{{ route('equipment.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                <select name="categorie" class="form-select w-full">
                    <option value="">Toutes</option>
                    <option value="informatique" {{ request('categorie') == 'informatique' ? 'selected' : '' }}>Informatique</option>
                    <option value="production" {{ request('categorie') == 'production' ? 'selected' : '' }}>Production</option>
                    <option value="bureau" {{ request('categorie') == 'bureau' ? 'selected' : '' }}>Bureau</option>
                    <option value="vehicule" {{ request('categorie') == 'vehicule' ? 'selected' : '' }}>Véhicule</option>
                    <option value="autre" {{ request('categorie') == 'autre' ? 'selected' : '' }}>Autre</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="statut" class="form-select w-full">
                    <option value="">Tous</option>
                    <option value="en_service" {{ request('statut') == 'en_service' ? 'selected' : '' }}>En Service</option>
                    <option value="en_maintenance" {{ request('statut') == 'en_maintenance' ? 'selected' : '' }}>En Maintenance</option>
                    <option value="hors_service" {{ request('statut') == 'hors_service' ? 'selected' : '' }}>Hors Service</option>
                    <option value="reforme" {{ request('statut') == 'reforme' ? 'selected' : '' }}>Réformé</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-input w-full" placeholder="Code, nom, marque...">
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary mr-2">Filtrer</button>
                <a href="{{ route('equipment.index') }}" class="btn-secondary">Réinitialiser</a>
            </div>
        </form>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Filiale</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Affecté à</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prochaine Maint.</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($equipment as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('equipment.show', $item) }}" class="text-blue-600 hover:underline font-mono">{{ $item->code }}</a>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-medium">{{ $item->nom }}</p>
                            <p class="text-sm text-gray-500">{{ $item->marque }} {{ $item->modele }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($item->categorie) }}</td>
                    <td class="px-6 py-4">{{ $item->filiale->nom }}</td>
                    <td class="px-6 py-4">
                        @if($item->affectation)
                            <span class="text-sm">{{ $item->affectation->name }}</span>
                        @else
                            <span class="text-gray-400 text-sm">Non affecté</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($item->statut === 'en_service') bg-green-100 text-green-800
                            @elseif($item->statut === 'en_maintenance') bg-yellow-100 text-yellow-800
                            @elseif($item->statut === 'hors_service') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ str_replace('_', ' ', ucfirst($item->statut)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($item->date_prochaine_maintenance)
                            <span class="{{ $item->maintenance_due ? 'text-red-600 font-bold' : '' }}">
                                {{ $item->date_prochaine_maintenance->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('equipment.show', $item) }}" class="text-blue-600 hover:underline mr-3">Voir</a>
                        <form action="{{ route('equipment.destroy', $item) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">Aucun équipement trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $equipment->links() }}
    </div>
</div>
@endsection
