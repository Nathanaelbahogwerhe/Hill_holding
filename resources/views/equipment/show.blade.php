@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">{{ $equipment->nom }} <span class="text-gray-500 font-mono">{{ $equipment->code }}</span></h1>
            <p class="text-neutral-400">{{ $equipment->marque }} {{ $equipment->modele }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('maintenances.create', ['equipment_id' => $equipment->id]) }}" class="btn-primary">
                <i class="fas fa-wrench mr-2"></i>Planifier Maintenance
            </a>
            <a href="{{ route('equipment.index') }}" class="btn-secondary">Retour</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Colonne principale --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Informations générales --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Informations Générales</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-neutral-400">Code</p>
                        <p class="font-mono font-medium">{{ $equipment->code }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-400">Catégorie</p>
                        <p class="font-medium">{{ ucfirst($equipment->categorie) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-400">Filiale</p>
                        <p class="font-medium">{{ $equipment->filiale->nom }}</p>
                    </div>
                    @if($equipment->service)
                    <div>
                        <p class="text-sm text-neutral-400">Service</p>
                        <p class="font-medium">{{ $equipment->service->nom }}</p>
                    </div>
                    @endif
                    @if($equipment->numero_serie)
                    <div>
                        <p class="text-sm text-neutral-400">N° Série</p>
                        <p class="font-mono">{{ $equipment->numero_serie }}</p>
                    </div>
                    @endif
                    @if($equipment->supplier)
                    <div>
                        <p class="text-sm text-neutral-400">Fournisseur</p>
                        <p class="font-medium">{{ $equipment->supplier->nom }}</p>
                    </div>
                    @endif
                    @if($equipment->affectation)
                    <div>
                        <p class="text-sm text-neutral-400">Affecté à</p>
                        <p class="font-medium">{{ $equipment->affectation->name }}</p>
                    </div>
                    @endif
                    @if($equipment->localisation)
                    <div>
                        <p class="text-sm text-neutral-400">Localisation</p>
                        <p class="font-medium">{{ $equipment->localisation }}</p>
                    </div>
                    @endif
                </div>
                @if($equipment->description)
                <div class="mt-4 pt-4 border-t">
                    <p class="text-sm text-neutral-400 font-medium">Description</p>
                    <p class="mt-1">{{ $equipment->description }}</p>
                </div>
                @endif
            </div>

            {{-- Informations financières --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Informations Financières</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-neutral-400">Date d'Acquisition</p>
                        <p class="font-medium">{{ $equipment->date_acquisition->format('d/m/Y') }}</p>
                    </div>
                    @if($equipment->prix_acquisition)
                    <div>
                        <p class="text-sm text-neutral-400">Prix d'Acquisition</p>
                        <p class="font-bold text-lg">{{ number_format($equipment->prix_acquisition, 0, ',', ' ') }} FCFA</p>
                    </div>
                    @endif
                    @if($equipment->date_fin_garantie)
                    <div>
                        <p class="text-sm text-neutral-400">Fin Garantie</p>
                        <p class="font-medium {{ $equipment->is_garantie_active ? 'text-white' : 'text-red-600' }}">
                            {{ $equipment->date_fin_garantie->format('d/m/Y') }}
                            @if($equipment->is_garantie_active)
                                <span class="text-xs">(Active)</span>
                            @else
                                <span class="text-xs">(Expirée)</span>
                            @endif
                        </p>
                    </div>
                    @endif
                    @if($equipment->duree_vie_estimee_annees)
                    <div>
                        <p class="text-sm text-neutral-400">Durée de Vie Estimée</p>
                        <p class="font-medium">{{ $equipment->duree_vie_estimee_annees }} années</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Historique des maintenances --}}
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Historique des Maintenances</h2>
                    <span class="text-sm text-neutral-400">{{ $equipment->maintenances->count() }} maintenances</span>
                </div>
                @if($equipment->maintenances->count() > 0)
                <div class="space-y-3">
                    @foreach($equipment->maintenances->take(5) as $maintenance)
                    <div class="border-l-4 {{ $maintenance->type === 'preventive' ? 'border-blue-500' : 'border-orange-500' }} pl-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium">{{ $maintenance->numero }}</p>
                                <p class="text-sm text-neutral-400">{{ $maintenance->description }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $maintenance->date_maintenance->format('d/m/Y') }} • 
                                    {{ ucfirst($maintenance->type) }} • 
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
                @else
                <p class="text-gray-500 text-center py-4">Aucune maintenance enregistrée</p>
                @endif
            </div>

            {{-- Pannes --}}
            @if($equipment->breakdowns->count() > 0)
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Pannes Récentes</h2>
                    <span class="text-sm text-neutral-400">{{ $equipment->breakdowns->count() }} pannes</span>
                </div>
                <div class="space-y-3">
                    @foreach($equipment->breakdowns->take(3) as $breakdown)
                    <div class="border-l-4 border-red-500 pl-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium">{{ $breakdown->numero }}</p>
                                <p class="text-sm text-neutral-400">{{ $breakdown->description }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $breakdown->date_panne->format('d/m/Y') }} • 
                                    Sévérité: {{ ucfirst($breakdown->severite) }} • 
                                    {{ ucfirst($breakdown->statut) }}
                                </p>
                            </div>
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
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Statut</h2>
                <div class="text-center">
                    <span class="inline-block px-4 py-2 text-sm font-semibold rounded 
                        @if($equipment->statut === 'en_service') bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300
                        @elseif($equipment->statut === 'en_maintenance') bg-yellow-100 text-yellow-800
                        @elseif($equipment->statut === 'hors_service') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ strtoupper(str_replace('_', ' ', $equipment->statut)) }}
                    </span>
                </div>
            </div>

            {{-- Alertes Maintenance --}}
            @if($equipment->date_prochaine_maintenance)
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Prochaine Maintenance</h2>
                <div class="text-center">
                    <p class="text-2xl font-bold {{ $equipment->maintenance_due ? 'text-red-600' : 'text-white' }}">
                        {{ $equipment->date_prochaine_maintenance->format('d/m/Y') }}
                    </p>
                    @if($equipment->maintenance_due)
                    <p class="text-sm text-red-600 mt-2">⚠️ Maintenance en retard</p>
                    @else
                    <p class="text-sm text-neutral-400 mt-2">Dans {{ now()->diffInDays($equipment->date_prochaine_maintenance) }} jours</p>
                    @endif
                </div>
            </div>
            @endif

            {{-- Statistiques --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Statistiques</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-400">Maintenances</span>
                        <span class="font-medium">{{ $equipment->maintenances->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-400">Pannes</span>
                        <span class="font-medium">{{ $equipment->breakdowns->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-400">Interventions</span>
                        <span class="font-medium">{{ $equipment->interventions->count() }}</span>
                    </div>
                    @if($equipment->prix_acquisition)
                    <div class="flex justify-between pt-3 border-t">
                        <span class="text-sm text-neutral-400">Coût Total Maint.</span>
                        <span class="font-bold">{{ number_format($equipment->maintenances->sum('cout'), 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
