@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="mb-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">📋 Opérations Journalières</h1>
                <p class="text-neutral-400 mt-2">Suivez vos opérations quotidiennes</p>
            </div>
            <a href="{{ route('daily_operations.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau Rapport
            </a>
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
                <p class="text-sm text-yellow-300 uppercase font-semibold">Cette Semaine</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $stats['cette_semaine'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-900/50 to-purple-800/50 border border-purple-500/30 rounded-2xl p-6 shadow-xl hover:scale-105 transition-transform duration-300">
                <p class="text-sm text-purple-300 uppercase font-semibold">Ce Mois</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $stats['ce_mois'] }}</p>
            </div>
        </div>

        <!-- Filtres -->
        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6">
            <div>
                <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Projet</label>
                <select name="project_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-3 py-2 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                    <option value="">Tous</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Département</label>
                <select name="department_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-3 py-2 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                    <option value="">Tous</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#D4AF37] mb-2">Date</label>
                <input type="date" name="date_debut" value="{{ request('date_debut') }}" 
                       class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-3 py-2 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg">
                    🔍 Filtrer
                </button>
            </div>
        </form>

        <!-- Liste -->
        <div class="space-y-4">
            @forelse($operations as $operation)
            <div class="border rounded-xl p-4 hover:shadow-md transition">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-lg font-semibold">
                            Rapport du {{ \Carbon\Carbon::parse($operation->date)->format('d/m/Y') }}
                        </h3>
                        <div class="flex items-center space-x-3 mt-1 text-sm text-neutral-400">
                            @if($operation->project)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $operation->project->name }}
                                </span>
                            @endif
                            @if($operation->department)
                                <span>{{ $operation->department->name }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('daily_operations.show', $operation) }}" 
                           class="px-3 py-1 text-sm text-white hover:bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/30 rounded">
                            Voir
                        </a>
                        <a href="{{ route('daily_operations.edit', $operation) }}" 
                           class="px-3 py-1 text-sm text-white hover:bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/30 rounded">
                            Modifier
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-neutral-400 font-medium mb-1">Activités Réalisées:</p>
                        <p class="text-[#D4AF37]">{{ Str::limit($operation->activites_realisees, 100) }}</p>
                    </div>
                    @if($operation->problemes_rencontres)
                    <div>
                        <p class="text-neutral-400 font-medium mb-1">Problèmes:</p>
                        <p class="text-red-600">{{ Str::limit($operation->problemes_rencontres, 100) }}</p>
                    </div>
                    @endif
                </div>

                <div class="mt-3 text-xs text-gray-500">
                    Soumis par {{ $operation->soumetteur->name ?? 'N/A' }}
                    @if($operation->nombre_personnel)
                        • {{ $operation->nombre_personnel }} personnel(s)
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                Aucun rapport journalier trouvé
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $operations->links() }}
        </div>
    </div>
</div>
@endsection
