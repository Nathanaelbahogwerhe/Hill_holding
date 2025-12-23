@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="mb-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">⭐ Évaluations</h1>
                <p class="text-neutral-400 mt-2">Gérez les évaluations de performances</p>
            </div>
            <a href="{{ route('evaluations.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvelle Évaluation
            </a>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/30 rounded-2xl p-6 shadow-xl hover:scale-105 transition-transform duration-300">
                <p class="text-sm text-blue-300 uppercase font-semibold">Total</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/30 rounded-2xl p-6 shadow-xl hover:scale-105 transition-transform duration-300">
                <p class="text-sm text-green-300 uppercase font-semibold">Ce Mois</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $stats['ce_mois'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-900/50 to-purple-800/50 border border-purple-500/30 rounded-2xl p-6 shadow-xl hover:scale-105 transition-transform duration-300">
                <p class="text-sm text-purple-300 uppercase font-semibold">Projets</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $stats['projets'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/30 rounded-2xl p-6 shadow-xl hover:scale-105 transition-transform duration-300">
                <p class="text-sm text-yellow-300 uppercase font-semibold">Tâches</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $stats['taches'] }}</p>
            </div>
        </div>

        <!-- Filtres -->
        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6">
            <div>
                <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Type</label>
                <select name="type" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-3 py-2 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                    <option value="">Tous</option>
                    <option value="projet" {{ request('type') == 'projet' ? 'selected' : '' }}>Projet</option>
                    <option value="tâche" {{ request('type') == 'tâche' ? 'selected' : '' }}>Tâche</option>
                    <option value="employé" {{ request('type') == 'employé' ? 'selected' : '' }}>Employé</option>
                    <option value="mission" {{ request('type') == 'mission' ? 'selected' : '' }}>Mission</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Évaluateur</label>
                <select name="evaluateur_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-3 py-2 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                    <option value="">Tous</option>
                    @foreach($evaluateurs as $evaluateur)
                        <option value="{{ $evaluateur->id }}" {{ request('evaluateur_id') == $evaluateur->id ? 'selected' : '' }}>
                            {{ $evaluateur->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg">
                    🔍 Filtrer
                </button>
            </div>
        </form>

        <!-- Liste -->
        <div class="space-y-4">
            @forelse($evaluations as $evaluation)
            <div class="border rounded-xl p-4 hover:shadow-md transition">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h3 class="text-lg font-semibold">
                                @if($evaluation->evaluable)
                                    {{ $evaluation->evaluable->name ?? $evaluation->evaluable->titre ?? 'N/A' }}
                                @else
                                    Évaluation
                                @endif
                            </h3>
                            
                            @if($evaluation->type == 'projet')
                                <span class="px-2 py-1 text-xs rounded-full bg-gradient-to-r from-blue-900/50 to-blue-800/50 border border-blue-500/30 text-blue-300">Projet</span>
                            @elseif($evaluation->type == 'tâche')
                                <span class="px-2 py-1 text-xs rounded-full bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300">Tâche</span>
                            @elseif($evaluation->type == 'employé')
                                <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">Employé</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Mission</span>
                            @endif

                            {!! $evaluation->note_badge !!}
                        </div>

                        @if($evaluation->commentaires)
                            <p class="text-neutral-400 text-sm mb-2">{{ Str::limit($evaluation->commentaires, 150) }}</p>
                        @endif

                        <div class="text-xs text-gray-500">
                            Évalué par {{ $evaluation->evaluateur->name ?? 'N/A' }} 
                            le {{ $evaluation->created_at->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="flex space-x-2 ml-4">
                        <a href="{{ route('evaluations.show', $evaluation) }}" 
                           class="px-3 py-1 text-sm text-white hover:bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/30 rounded">
                            Voir
                        </a>
                        @if($evaluation->evaluateur_id == auth()->id() || auth()->user()->hasRole('superadmin'))
                            <a href="{{ route('evaluations.edit', $evaluation) }}" 
                               class="px-3 py-1 text-sm text-white hover:bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/30 rounded">
                                Modifier
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Aperçu des points -->
                @if($evaluation->points_forts || $evaluation->points_amelioration)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3 text-sm">
                    @if($evaluation->points_forts)
                    <div>
                        <p class="text-white font-medium mb-1">✓ Points Forts:</p>
                        <p class="text-[#D4AF37]">{{ Str::limit($evaluation->points_forts, 80) }}</p>
                    </div>
                    @endif
                    @if($evaluation->points_amelioration)
                    <div>
                        <p class="text-orange-600 font-medium mb-1">⚠ À Améliorer:</p>
                        <p class="text-[#D4AF37]">{{ Str::limit($evaluation->points_amelioration, 80) }}</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                Aucune évaluation trouvée
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $evaluations->links() }}
        </div>
    </div>
</div>
@endsection
