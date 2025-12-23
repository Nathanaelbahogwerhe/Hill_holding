@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Mission {{ $mission->numero }}</h1>
            <p class="text-neutral-400">{{ $mission->destination }}</p>
        </div>
        <div class="flex gap-2">
            @if($mission->statut === 'terminee')
                <a href="{{ route('fuel_records.create', ['mission_id' => $mission->id]) }}" class="btn-primary">
                    <i class="fas fa-gas-pump mr-2"></i>Ajouter Carburant
                </a>
            @endif
            <a href="{{ route('missions.index') }}" class="btn-secondary">Retour</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Colonne principale --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Informations mission --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Informations de la Mission</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-neutral-400">Véhicule</p>
                        <p class="font-mono font-medium">{{ $mission->vehicle->immatriculation }}</p>
                        <p class="text-sm text-gray-500">{{ $mission->vehicle->marque }} {{ $mission->vehicle->modele }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-400">Conducteur</p>
                        <p class="font-medium">{{ $mission->conducteur->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-400">Demandeur</p>
                        <p class="font-medium">{{ $mission->demandeur->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-400">Filiale</p>
                        <p class="font-medium">{{ $mission->filiale->nom }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-400">Date Début</p>
                        <p class="font-medium">{{ $mission->date_debut->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($mission->date_fin_prevue)
                    <div>
                        <p class="text-sm text-neutral-400">Date Fin Prévue</p>
                        <p class="font-medium">{{ $mission->date_fin_prevue->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                    @if($mission->date_fin_reelle)
                    <div>
                        <p class="text-sm text-neutral-400">Date Fin Réelle</p>
                        <p class="font-medium">{{ $mission->date_fin_reelle->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Détails --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Détails</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-neutral-400 font-medium">Destination</p>
                        <p class="mt-1">{{ $mission->destination }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-400 font-medium">Motif</p>
                        <p class="mt-1">{{ $mission->motif }}</p>
                    </div>
                    @if($mission->passagers && count($mission->passagers) > 0)
                    <div>
                        <p class="text-sm text-neutral-400 font-medium">Passagers</p>
                        <ul class="mt-1 space-y-1">
                            @foreach($mission->passagers as $passager)
                            <li class="text-sm">
                                • {{ $passager['nom'] ?? '' }}
                                @if(isset($passager['fonction']))
                                    <span class="text-gray-500">({{ $passager['fonction'] }})</span>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if($mission->remarques)
                    <div>
                        <p class="text-sm text-neutral-400 font-medium">Remarques</p>
                        <p class="mt-1">{{ $mission->remarques }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Kilométrage --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Kilométrage</h2>
                <div class="grid grid-cols-3 gap-4">
                    @if($mission->kilometrage_depart)
                    <div>
                        <p class="text-sm text-neutral-400">Départ</p>
                        <p class="font-medium">{{ number_format($mission->kilometrage_depart, 0, ',', ' ') }} km</p>
                    </div>
                    @endif
                    @if($mission->kilometrage_arrivee)
                    <div>
                        <p class="text-sm text-neutral-400">Arrivée</p>
                        <p class="font-medium">{{ number_format($mission->kilometrage_arrivee, 0, ',', ' ') }} km</p>
                    </div>
                    @endif
                    @if($mission->distance_km)
                    <div>
                        <p class="text-sm text-neutral-400">Distance</p>
                        <p class="font-bold text-lg">{{ $mission->distance_km }} km</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Coûts --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Coûts</h2>
                <div class="space-y-3">
                    @if($mission->montant_carburant)
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-400">Carburant</span>
                        <span class="font-medium">{{ number_format($mission->montant_carburant, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endif
                    @if($mission->autres_frais)
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-400">Autres Frais</span>
                        <span class="font-medium">{{ number_format($mission->autres_frais, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endif
                    @if($mission->montant_carburant || $mission->autres_frais)
                    <div class="flex justify-between pt-3 border-t">
                        <span class="font-semibold">Total</span>
                        <span class="font-bold text-lg">{{ number_format(($mission->montant_carburant ?? 0) + ($mission->autres_frais ?? 0), 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Colonne latérale --}}
        <div class="space-y-6">
            {{-- Statut --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Statut</h2>
                <div class="text-center">
                    <span class="inline-block px-4 py-2 text-sm font-semibold rounded 
                        @if($mission->statut === 'planifiee') bg-gradient-to-r from-blue-900/50 to-blue-800/50 border border-blue-500/30 text-blue-300
                        @elseif($mission->statut === 'en_cours') bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300
                        @elseif($mission->statut === 'terminee') bg-gray-100 text-gray-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ strtoupper($mission->statut) }}
                    </span>
                </div>
            </div>

            {{-- Actions --}}
            @if($mission->statut !== 'terminee' && $mission->statut !== 'annulee')
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Actions</h2>
                <div class="space-y-2">
                    @if($mission->statut === 'planifiee')
                    <form action="{{ route('missions.update', $mission) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="statut" value="en_cours">
                        <button type="submit" class="btn-primary w-full">Démarrer Mission</button>
                    </form>
                    @endif
                    @if($mission->statut === 'en_cours')
                    <form action="{{ route('missions.update', $mission) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="statut" value="terminee">
                        <button type="submit" class="btn-primary w-full bg-green-600 hover:bg-green-700">Terminer Mission</button>
                    </form>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
