@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">{{ $vehicle->marque }} {{ $vehicle->modele }}</h1>
            <p class="text-gray-600 font-mono text-lg">{{ $vehicle->immatriculation }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('missions.create', ['vehicle_id' => $vehicle->id]) }}" class="btn-primary">
                <i class="fas fa-route mr-2"></i>Nouvelle Mission
            </a>
            <a href="{{ route('fuel_records.create', ['vehicle_id' => $vehicle->id]) }}" class="btn-secondary">
                <i class="fas fa-gas-pump mr-2"></i>Ajouter Carburant
            </a>
            <a href="{{ route('vehicles.index') }}" class="btn-secondary">Retour</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Colonne principale --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Informations véhicule --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Informations du Véhicule</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Type</p>
                        <p class="font-medium">{{ ucfirst($vehicle->type) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Année</p>
                        <p class="font-medium">{{ $vehicle->annee }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Couleur</p>
                        <p class="font-medium">{{ $vehicle->couleur ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Filiale</p>
                        <p class="font-medium">{{ $vehicle->filiale->nom }}</p>
                    </div>
                    @if($vehicle->service)
                    <div>
                        <p class="text-sm text-gray-600">Service</p>
                        <p class="font-medium">{{ $vehicle->service->nom }}</p>
                    </div>
                    @endif
                    @if($vehicle->chauffeur)
                    <div>
                        <p class="text-sm text-gray-600">Chauffeur</p>
                        <p class="font-medium">{{ $vehicle->chauffeur->name }}</p>
                    </div>
                    @endif
                    @if($vehicle->numero_chassis)
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600">N° Châssis</p>
                        <p class="font-mono">{{ $vehicle->numero_chassis }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Kilométrage et carburant --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Kilométrage & Carburant</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Kilométrage Initial</p>
                        <p class="font-medium">{{ number_format($vehicle->kilometrage_initial, 0, ',', ' ') }} km</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Kilométrage Actuel</p>
                        <p class="font-bold text-lg">{{ number_format($vehicle->kilometrage_actuel, 0, ',', ' ') }} km</p>
                    </div>
                    @if($vehicle->capacite_reservoir)
                    <div>
                        <p class="text-sm text-gray-600">Capacité Réservoir</p>
                        <p class="font-medium">{{ $vehicle->capacite_reservoir }} L</p>
                    </div>
                    @endif
                    @if($vehicle->consommation_moyenne)
                    <div>
                        <p class="text-sm text-gray-600">Conso. Moyenne Théorique</p>
                        <p class="font-medium">{{ $vehicle->consommation_moyenne }} L/100km</p>
                    </div>
                    @endif
                    @if($vehicle->consommation_moyenne_reelle)
                    <div>
                        <p class="text-sm text-gray-600">Conso. Moyenne Réelle</p>
                        <p class="font-bold text-lg {{ $vehicle->consommation_moyenne_reelle > ($vehicle->consommation_moyenne ?? 0) ? 'text-red-600' : 'text-green-600' }}">
                            {{ number_format($vehicle->consommation_moyenne_reelle, 2) }} L/100km
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Assurance --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Assurance</h2>
                <div class="grid grid-cols-2 gap-4">
                    @if($vehicle->compagnie_assurance)
                    <div>
                        <p class="text-sm text-gray-600">Compagnie</p>
                        <p class="font-medium">{{ $vehicle->compagnie_assurance }}</p>
                    </div>
                    @endif
                    @if($vehicle->date_debut_assurance)
                    <div>
                        <p class="text-sm text-gray-600">Date Début</p>
                        <p class="font-medium">{{ $vehicle->date_debut_assurance->format('d/m/Y') }}</p>
                    </div>
                    @endif
                    @if($vehicle->date_fin_assurance)
                    <div>
                        <p class="text-sm text-gray-600">Date Fin</p>
                        <p class="font-medium {{ $vehicle->is_assurance_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $vehicle->date_fin_assurance->format('d/m/Y') }}
                            @if(!$vehicle->is_assurance_active)
                                <span class="text-xs">(Expirée)</span>
                            @endif
                        </p>
                    </div>
                    @endif
                    @if($vehicle->date_visite_technique)
                    <div>
                        <p class="text-sm text-gray-600">Visite Technique</p>
                        <p class="font-medium">{{ $vehicle->date_visite_technique->format('d/m/Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Missions récentes --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Missions Récentes</h2>
                    <span class="text-sm text-gray-600">{{ $vehicle->missions->count() }} missions</span>
                </div>
                @if($vehicle->missions->count() > 0)
                <div class="space-y-3">
                    @foreach($vehicle->missions->take(5) as $mission)
                    <div class="border-l-4 border-blue-500 pl-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium">{{ $mission->numero }}</p>
                                <p class="text-sm text-gray-600">{{ $mission->destination }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $mission->date_debut->format('d/m/Y') }} • 
                                    {{ $mission->distance_km ? $mission->distance_km . ' km' : '' }} • 
                                    {{ ucfirst($mission->statut) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-center py-4">Aucune mission enregistrée</p>
                @endif
            </div>

            {{-- Ravitaillements récents --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Ravitaillements Récents</h2>
                    <span class="text-sm text-gray-600">{{ $vehicle->fuelRecords->count() }} ravitaillements</span>
                </div>
                @if($vehicle->fuelRecords->count() > 0)
                <div class="space-y-3">
                    @foreach($vehicle->fuelRecords->take(5) as $fuel)
                    <div class="border-l-4 border-green-500 pl-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium">{{ $fuel->quantite }} L</p>
                                <p class="text-sm text-gray-600">Km: {{ number_format($fuel->kilometrage, 0, ',', ' ') }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $fuel->date_ravitaillement->format('d/m/Y') }}
                                    @if($fuel->consommation)
                                        • Conso: {{ number_format($fuel->consommation, 2) }} L/100km
                                    @endif
                                </p>
                            </div>
                            <p class="text-sm font-medium">{{ number_format($fuel->montant, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-center py-4">Aucun ravitaillement enregistré</p>
                @endif
            </div>

            {{-- Maintenances --}}
            @if($vehicle->maintenances->count() > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Maintenances</h2>
                    <span class="text-sm text-gray-600">{{ $vehicle->maintenances->count() }} maintenances</span>
                </div>
                <div class="space-y-3">
                    @foreach($vehicle->maintenances->take(3) as $maintenance)
                    <div class="border-l-4 border-yellow-500 pl-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium">{{ $maintenance->numero }}</p>
                                <p class="text-sm text-gray-600">{{ $maintenance->description }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $maintenance->type_maintenance }} • 
                                    {{ ucfirst($maintenance->statut) }}
                                </p>
                            </div>
                            @if($maintenance->cout)
                            <p class="text-sm font-medium">{{ number_format($maintenance->cout, 0, ',', ' ') }} FCFA</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Colonne latérale --}}
        <div class="space-y-6">
            {{-- Statut --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Statut</h2>
                <div class="text-center">
                    <span class="inline-block px-4 py-2 text-sm font-semibold rounded 
                        @if($vehicle->statut === 'disponible') bg-green-100 text-green-800
                        @elseif($vehicle->statut === 'en_mission') bg-blue-100 text-blue-800
                        @elseif($vehicle->statut === 'en_maintenance') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ strtoupper(str_replace('_', ' ', $vehicle->statut)) }}
                    </span>
                </div>
            </div>

            {{-- Alertes --}}
            @php
                $alertes = [];
                if(!$vehicle->is_assurance_active) $alertes[] = 'Assurance expirée';
                if($vehicle->date_fin_assurance && $vehicle->date_fin_assurance->diffInDays(now()) < 30 && $vehicle->is_assurance_active) 
                    $alertes[] = 'Assurance expire dans ' . $vehicle->date_fin_assurance->diffInDays(now()) . ' jours';
                if($vehicle->date_visite_technique && $vehicle->date_visite_technique->isPast())
                    $alertes[] = 'Visite technique expirée';
            @endphp
            @if(count($alertes) > 0)
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-red-800 mb-4">⚠️ Alertes</h2>
                <ul class="space-y-2">
                    @foreach($alertes as $alerte)
                    <li class="text-sm text-red-700">• {{ $alerte }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Statistiques --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Statistiques</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Missions</span>
                        <span class="font-medium">{{ $vehicle->missions->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Ravitaillements</span>
                        <span class="font-medium">{{ $vehicle->fuelRecords->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Maintenances</span>
                        <span class="font-medium">{{ $vehicle->maintenances->count() }}</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t">
                        <span class="text-sm text-gray-600">Coût Carburant</span>
                        <span class="font-bold">{{ number_format($vehicle->fuelRecords->sum('montant'), 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Coût Maintenance</span>
                        <span class="font-bold">{{ number_format($vehicle->maintenances->sum('cout'), 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            @if($vehicle->remarques)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Remarques</h2>
                <p class="text-sm text-gray-700">{{ $vehicle->remarques }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
