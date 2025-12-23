@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="mb-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">🎯 Activités & Planification</h1>
                <p class="text-neutral-400 mt-2">Gérez vos activités et planifications</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('activities.planning') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white rounded-xl font-bold transition-all duration-300 shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Vue Planification
                </a>
                <a href="{{ route('activities.create') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouvelle Activité
                </a>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/30 rounded-2xl p-6 shadow-xl hover:scale-105 transition-transform duration-300">
                <p class="text-sm text-blue-300 uppercase font-semibold">Total</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/30 rounded-2xl p-6 shadow-xl hover:scale-105 transition-transform duration-300">
                <p class="text-sm text-green-300 uppercase font-semibold">Aujourd'hui</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $stats['aujourd_hui'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/30 rounded-2xl p-6 shadow-xl hover:scale-105 transition-transform duration-300">
                <p class="text-sm text-yellow-300 uppercase font-semibold">À venir (7j)</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $stats['a_venir'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-900/50 to-purple-800/50 border border-purple-500/30 rounded-2xl p-6 shadow-xl hover:scale-105 transition-transform duration-300">
                <p class="text-sm text-purple-300 uppercase font-semibold">Terminées</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $stats['terminees'] }}</p>
            </div>
        </div>

        <!-- Filtres -->
        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6">
            <div>
                <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Type</label>
                <select name="type" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-3 py-2 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                    <option value="">Tous</option>
                    <option value="réunion" {{ request('type') == 'réunion' ? 'selected' : '' }}>Réunion</option>
                    <option value="formation" {{ request('type') == 'formation' ? 'selected' : '' }}>Formation</option>
                    <option value="mission" {{ request('type') == 'mission' ? 'selected' : '' }}>Mission</option>
                    <option value="événement" {{ request('type') == 'événement' ? 'selected' : '' }}>Événement</option>
                    <option value="autre" {{ request('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Statut</label>
                <select name="statut" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-3 py-2 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                    <option value="">Tous</option>
                    <option value="planifiée" {{ request('statut') == 'planifiée' ? 'selected' : '' }}>Planifiée</option>
                    <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="terminée" {{ request('statut') == 'terminée' ? 'selected' : '' }}>Terminée</option>
                    <option value="annulée" {{ request('statut') == 'annulée' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Date Début</label>
                <input type="date" name="date_debut" value="{{ request('date_debut') }}" 
                       class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-3 py-2 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg">
                    🔍 Filtrer
                </button>
            </div>
        </form>

        <!-- Liste des activités -->
        <div class="space-y-4">
            @forelse($activities as $activity)
            <div class="border rounded-xl p-4 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h3 class="text-lg font-semibold">{{ $activity->titre }}</h3>
                            
                            @if($activity->type == 'réunion')
                                <span class="px-2 py-1 text-xs rounded-full bg-gradient-to-r from-blue-900/50 to-blue-800/50 border border-blue-500/30 text-blue-300">Réunion</span>
                            @elseif($activity->type == 'formation')
                                <span class="px-2 py-1 text-xs rounded-full bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300">Formation</span>
                            @elseif($activity->type == 'mission')
                                <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">Mission</span>
                            @elseif($activity->type == 'événement')
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Événement</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Autre</span>
                            @endif

                            @if($activity->statut == 'planifiée')
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Planifiée</span>
                            @elseif($activity->statut == 'en_cours')
                                <span class="px-2 py-1 text-xs rounded-full bg-gradient-to-r from-blue-900/50 to-blue-800/50 border border-blue-500/30 text-blue-300">En cours</span>
                            @elseif($activity->statut == 'terminée')
                                <span class="px-2 py-1 text-xs rounded-full bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300">Terminée</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Annulée</span>
                            @endif
                        </div>

                        <p class="text-neutral-400 text-sm mb-3">{{ Str::limit($activity->description, 150) }}</p>

                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($activity->date_prevue)->format('d/m/Y') }}
                            </div>

                            @if($activity->heure_debut)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $activity->heure_debut }} @if($activity->heure_fin) - {{ $activity->heure_fin }} @endif
                            </div>
                            @endif

                            @if($activity->lieu)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $activity->lieu }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex space-x-2 ml-4">
                        <a href="{{ route('activities.show', $activity) }}" 
                           class="px-3 py-1 text-sm text-white hover:bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/30 rounded">
                            Voir
                        </a>
                        <a href="{{ route('activities.edit', $activity) }}" 
                           class="px-3 py-1 text-sm text-white hover:bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/30 rounded">
                            Modifier
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                Aucune activité trouvée
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
