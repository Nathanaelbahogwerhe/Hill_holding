@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Opérations Journalières</h1>
            <a href="{{ route('daily_operations.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Nouveau Rapport Journalier
            </a>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Total</p>
                <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-green-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Aujourd'hui</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['aujourd_hui'] }}</p>
            </div>
            <div class="bg-yellow-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Cette Semaine</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['cette_semaine'] }}</p>
            </div>
            <div class="bg-purple-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Ce Mois</p>
                <p class="text-2xl font-bold text-purple-600">{{ $stats['ce_mois'] }}</p>
            </div>
        </div>

        <!-- Filtres -->
        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Projet</label>
                <select name="project_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tous</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Département</label>
                <select name="department_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tous</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                <input type="date" name="date_debut" value="{{ request('date_debut') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Filtrer
                </button>
            </div>
        </form>

        <!-- Liste -->
        <div class="space-y-4">
            @forelse($operations as $operation)
            <div class="border rounded-lg p-4 hover:shadow-md transition">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-lg font-semibold">
                            Rapport du {{ \Carbon\Carbon::parse($operation->date)->format('d/m/Y') }}
                        </h3>
                        <div class="flex items-center space-x-3 mt-1 text-sm text-gray-600">
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
                           class="px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded">
                            Voir
                        </a>
                        <a href="{{ route('daily_operations.edit', $operation) }}" 
                           class="px-3 py-1 text-sm text-green-600 hover:bg-green-50 rounded">
                            Modifier
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600 font-medium mb-1">Activités Réalisées:</p>
                        <p class="text-gray-700">{{ Str::limit($operation->activites_realisees, 100) }}</p>
                    </div>
                    @if($operation->problemes_rencontres)
                    <div>
                        <p class="text-gray-600 font-medium mb-1">Problèmes:</p>
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
