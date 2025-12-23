@extends('layouts.app')

@section('title', 'Planification des Activités')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-neutral-50 to-neutral-100 py-8 animate-fadeIn">
    <div class="max-w-[98%] mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header avec Gradient Animé -->
        <div class="bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-[length:200%_100%] animate-gradient rounded-2xl shadow-2xl p-8 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-5xl font-black text-white mb-2 drop-shadow-lg">
                        📅 Planification des Activités
                    </h1>
                    <p class="text-yellow-50 text-lg">Vue d'ensemble des activités par département et période</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('activities.planning.create') }}" class="bg-green-600 hover:bg-green-700 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Nouvelle Activité
                    </a>
                    <a href="{{ route('activities.index') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <form method="GET" action="{{ route('activities.planning') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Type de vue</label>
                    <select name="filter" class="w-full border-neutral-300 rounded-xl shadow-sm focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37] focus:ring-opacity-50 transition-all">
                        <option value="journalier" {{ $filter == 'journalier' ? 'selected' : '' }}>Journalier</option>
                        <option value="mensuel" {{ $filter == 'mensuel' ? 'selected' : '' }}>Mensuel</option>
                        <option value="semestriel" {{ $filter == 'semestriel' ? 'selected' : '' }}>Semestriel</option>
                        <option value="annuel" {{ $filter == 'annuel' ? 'selected' : '' }}>Annuel</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Année</label>
                    <select name="year" class="w-full border-neutral-300 rounded-xl shadow-sm focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37] focus:ring-opacity-50 transition-all">
                        @for($y = now()->year - 2; $y <= now()->year + 2; $y++)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                @if($filter == 'mensuel')
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Mois</label>
                    <select name="month" class="w-full border-neutral-300 rounded-xl shadow-sm focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37] focus:ring-opacity-50 transition-all">
                        @foreach(['Janvier' => 1, 'Février' => 2, 'Mars' => 3, 'Avril' => 4, 'Mai' => 5, 'Juin' => 6, 'Juillet' => 7, 'Août' => 8, 'Septembre' => 9, 'Octobre' => 10, 'Novembre' => 11, 'Décembre' => 12] as $name => $num)
                            <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if($filter == 'semestriel')
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Semestre</label>
                    <select name="semester" class="w-full border-neutral-300 rounded-xl shadow-sm focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37] focus:ring-opacity-50 transition-all">
                        <option value="1" {{ $semester == 1 ? 'selected' : '' }}>1er Semestre (Jan-Juin)</option>
                        <option value="2" {{ $semester == 2 ? 'selected' : '' }}>2ème Semestre (Juil-Déc)</option>
                    </select>
                </div>
                @endif

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gradient-to-r from-[#D4AF37] to-yellow-600 hover:from-yellow-600 hover:to-[#D4AF37] text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filtrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistiques Globales -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-1">Total</p>
                        <p class="text-4xl font-black">{{ $performance['total_activities'] }}</p>
                    </div>
                    <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium mb-1">Terminées</p>
                        <p class="text-4xl font-black">{{ $performance['completed'] }}</p>
                    </div>
                    <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium mb-1">En cours</p>
                        <p class="text-4xl font-black">{{ $performance['in_progress'] }}</p>
                    </div>
                    <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium mb-1">Planifiées</p>
                        <p class="text-4xl font-black">{{ $performance['planned'] }}</p>
                    </div>
                    <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#D4AF37] to-yellow-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium mb-1">Taux de réalisation</p>
                        <p class="text-4xl font-black">{{ $performance['completion_rate'] }}%</p>
                    </div>
                    <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau de Planification -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-gradient-to-r from-neutral-800 to-neutral-700">
                        <tr>
                            <th scope="col" class="sticky left-0 z-10 bg-gradient-to-r from-neutral-800 to-neutral-700 px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider border-r border-neutral-600">
                                Mois / Période
                            </th>
                            @forelse($departments as $department)
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-white uppercase tracking-wider border-r border-neutral-600 min-w-[200px]">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="flex-shrink-0 h-10 w-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $department->nom }}</div>
                                        @if($department->filiale)
                                        <div class="text-xs text-white/70">{{ $department->filiale->nom }}</div>
                                        @endif
                                    </div>
                                </div>
                            </th>
                            @empty
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-white uppercase tracking-wider">
                                Aucun département
                            </th>
                            @endforelse
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-white uppercase tracking-wider border-l-4 border-[#D4AF37] bg-gradient-to-r from-[#D4AF37] to-yellow-600 min-w-[150px]">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    Performance
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @forelse($periods as $period)
                        <tr class="hover:bg-neutral-50 transition-colors duration-150">
                            <td class="sticky left-0 z-10 bg-white hover:bg-neutral-50 px-6 py-4 whitespace-nowrap border-r border-neutral-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-neutral-900">{{ $period }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            @foreach($departments as $department)
                            <td class="px-4 py-3 border-r border-neutral-200 align-top">
                                @php
                                    $activities = isset($planning[$department->id]['periods'][$period]) 
                                        ? $planning[$department->id]['periods'][$period] 
                                        : collect([]);
                                @endphp
                                
                                @if($activities->count() > 0)
                                    <!-- Compteur d'activités -->
                                    <div class="mb-2 flex items-center justify-between bg-neutral-100 rounded-xl px-3 py-1.5">
                                        <span class="text-xs font-bold text-neutral-700">
                                            {{ $activities->count() }} activité{{ $activities->count() > 1 ? 's' : '' }}
                                        </span>
                                        <div class="flex gap-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-700" title="Terminées">
                                                {{ $activities->where('statut', 'terminée')->count() }}
                                            </span>
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-amber-100 text-amber-700" title="En cours">
                                                {{ $activities->where('statut', 'en_cours')->count() }}
                                            </span>
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-purple-100 text-purple-700" title="Planifiées">
                                                {{ $activities->where('statut', 'planifiée')->count() }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Liste des activités avec scroll -->
                                    <div class="space-y-2 max-h-96 overflow-y-auto pr-1 custom-scrollbar">
                                        @foreach($activities as $activity)
                                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-l-4 border-blue-500 rounded-xl p-3 hover:shadow-md transition-all duration-200">
                                            <div class="flex items-start justify-between gap-2">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-bold text-neutral-900 truncate" title="{{ $activity->titre }}">
                                                        {{ $activity->titre }}
                                                    </p>
                                                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                                            @if($activity->statut == 'terminée') bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300
                                                            @elseif($activity->statut == 'en_cours') bg-amber-100 text-amber-800
                                                            @elseif($activity->statut == 'planifiée') bg-purple-100 text-purple-800
                                                            @else bg-red-100 text-red-800
                                                            @endif">
                                                            @if($activity->statut == 'terminée')
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @elseif($activity->statut == 'en_cours')
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @elseif($activity->statut == 'planifiée')
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @else
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @endif
                                                            {{ ucfirst($activity->statut) }}
                                                        </span>
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-neutral-100 text-neutral-700">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                            </svg>
                                                            {{ \Carbon\Carbon::parse($activity->date_prevue)->format('d/m/Y') }}
                                                        </span>
                                                        @if($activity->heure_debut)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            {{ substr($activity->heure_debut, 0, 5) }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                    @if($activity->type)
                                                    <p class="text-xs text-neutral-600 mt-1 flex items-center gap-1">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-700">
                                                            {{ ucfirst($activity->type) }}
                                                        </span>
                                                    </p>
                                                    @endif
                                                    @if($activity->project)
                                                    <p class="text-xs text-neutral-600 mt-1 truncate" title="{{ $activity->project->nom }}">
                                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                                        </svg>
                                                        {{ $activity->project->nom }}
                                                    </p>
                                                    @endif
                                                    @if($activity->lieu)
                                                    <p class="text-xs text-neutral-600 mt-1 truncate" title="{{ $activity->lieu }}">
                                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        </svg>
                                                        {{ $activity->lieu }}
                                                    </p>
                                                    @endif
                                                </div>
                                                <a href="{{ route('activities.show', $activity) }}" class="flex-shrink-0 text-white hover:text-blue-800 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                            
                                            <!-- Section RH : Responsable -->
                                            @if($activity->responsible)
                                            <div class="mt-3 pt-3 border-t border-blue-300">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-[#D4AF37] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-xs font-bold text-[#D4AF37]">RESPONSABLE</p>
                                                        <p class="text-xs font-semibold text-neutral-900 truncate">{{ $activity->responsible->name ?? 'N/A' }}</p>
                                                        @if($activity->responsible->employee)
                                                        <p class="text-xs text-neutral-600 truncate">{{ $activity->responsible->employee->poste ?? '' }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Section RH : Participants -->
                                            @if($activity->participants && $activity->participants->isNotEmpty())
                                            <div class="mt-2 pt-2 border-t border-blue-300">
                                                <div class="flex items-start gap-2">
                                                    <svg class="w-4 h-4 text-white flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                                    </svg>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-xs font-bold text-white mb-1">PARTICIPANTS ({{ $activity->participants->count() }})</p>
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach($activity->participants->take(3) as $participant)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300">
                                                                {{ $participant->name ?? 'N/A' }}
                                                            </span>
                                                            @endforeach
                                                            @if($activity->participants->count() > 3)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-green-200 text-green-900">
                                                                +{{ $activity->participants->count() - 3 }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4 text-neutral-400">
                                        <svg class="w-8 h-8 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="text-xs">Aucune activité</p>
                                    </div>
                                @endif
                            </td>
                            @endforeach
                            
                            <!-- Colonne Performance pour cette période -->
                            <td class="px-4 py-4 border-l-4 border-[#D4AF37] bg-gradient-to-r from-[#D4AF37]/5 to-yellow-500/5">
                                @php
                                    $periodTotal = 0;
                                    $periodCompleted = 0;
                                    foreach($planning as $deptId => $data) {
                                        $activities = isset($data['periods'][$period]) ? $data['periods'][$period] : collect([]);
                                        $periodTotal += $activities->count();
                                        $periodCompleted += $activities->where('statut', 'terminée')->count();
                                    }
                                    $periodRate = $periodTotal > 0 ? round(($periodCompleted / $periodTotal) * 100, 1) : 0;
                                @endphp
                                
                                <div class="text-center">
                                    <div class="inline-flex flex-col items-center bg-white rounded-xl p-4 shadow-md">
                                        <div class="text-3xl font-black 
                                            @if($periodRate >= 75) text-white
                                            @elseif($periodRate >= 50) text-amber-600
                                            @else text-red-600
                                            @endif">
                                            {{ $periodRate }}%
                                        </div>
                                        <div class="text-xs text-neutral-500 mt-1">
                                            {{ $periodCompleted }}/{{ $periodTotal }}
                                        </div>
                                        <div class="w-full bg-neutral-200 rounded-full h-2 mt-2">
                                            <div class="h-2 rounded-full transition-all duration-500
                                                @if($periodRate >= 75) bg-gradient-to-r from-green-500 to-green-600
                                                @elseif($periodRate >= 50) bg-gradient-to-r from-amber-500 to-amber-600
                                                @else bg-gradient-to-r from-red-500 to-red-600
                                                @endif" 
                                                style="width: {{ $periodRate }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($departments) + 2 }}" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-neutral-500 text-lg font-medium">Aucune période disponible</p>
                            </td>
                        </tr>
                        @endforelse
                        
                        <!-- Ligne Totale Performance par Département -->
                        <tr class="bg-gradient-to-r from-[#D4AF37]/10 to-yellow-500/10 border-t-4 border-[#D4AF37]">
                            <td class="sticky left-0 z-10 bg-gradient-to-r from-[#D4AF37]/20 to-yellow-500/20 px-6 py-4 border-r border-[#D4AF37]">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-[#D4AF37] to-yellow-600 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-black text-[#D4AF37] uppercase">Performance</div>
                                        <div class="text-xs text-neutral-600">Par département</div>
                                    </div>
                                </div>
                            </td>
                            @foreach($departments as $department)
                            <td class="px-4 py-4 border-r border-[#D4AF37]/30">
                                @php
                                    $deptPerf = isset($departmentPerformance[$department->id]) 
                                        ? $departmentPerformance[$department->id] 
                                        : ['total' => 0, 'completed' => 0, 'rate' => 0];
                                @endphp
                                
                                <div class="text-center">
                                    <div class="inline-flex flex-col items-center bg-white rounded-xl p-4 shadow-md">
                                        <div class="text-3xl font-black 
                                            @if($deptPerf['rate'] >= 75) text-white
                                            @elseif($deptPerf['rate'] >= 50) text-amber-600
                                            @else text-red-600
                                            @endif">
                                            {{ $deptPerf['rate'] }}%
                                        </div>
                                        <div class="text-xs text-neutral-500 mt-1">
                                            {{ $deptPerf['completed'] }}/{{ $deptPerf['total'] }}
                                        </div>
                                        <div class="w-full bg-neutral-200 rounded-full h-2 mt-2">
                                            <div class="h-2 rounded-full transition-all duration-500
                                                @if($deptPerf['rate'] >= 75) bg-gradient-to-r from-green-500 to-green-600
                                                @elseif($deptPerf['rate'] >= 50) bg-gradient-to-r from-amber-500 to-amber-600
                                                @else bg-gradient-to-r from-red-500 to-red-600
                                                @endif" 
                                                style="width: {{ $deptPerf['rate'] }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @endforeach
                            <td class="px-4 py-4 border-l-4 border-[#D4AF37] bg-gradient-to-r from-[#D4AF37]/20 to-yellow-500/20">
                                <div class="text-center">
                                    <div class="inline-flex flex-col items-center bg-white rounded-xl p-4 shadow-md">
                                        <div class="text-3xl font-black text-[#D4AF37]">
                                            {{ $performance['completion_rate'] }}%
                                        </div>
                                        <div class="text-xs text-neutral-600 mt-1 font-semibold">
                                            Global
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Légende -->
        <div class="mt-8 bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-neutral-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Légende des statuts
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Terminée
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-amber-100 text-amber-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        En cours
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        Planifiée
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        Annulée
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-gradient {
    animation: gradient 3s ease infinite;
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}

/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #D4AF37;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #B8941F;
}

/* Firefox */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #D4AF37 #f1f1f1;
}
</style>
@endsection
