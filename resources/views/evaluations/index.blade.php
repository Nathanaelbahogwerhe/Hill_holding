@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Évaluations</h1>
            <a href="{{ route('evaluations.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Nouvelle Évaluation
            </a>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Total</p>
                <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-green-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Ce Mois</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['ce_mois'] }}</p>
            </div>
            <div class="bg-purple-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Projets</p>
                <p class="text-2xl font-bold text-purple-600">{{ $stats['projets'] }}</p>
            </div>
            <div class="bg-yellow-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Tâches</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['taches'] }}</p>
            </div>
        </div>

        <!-- Filtres -->
        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tous</option>
                    <option value="projet" {{ request('type') == 'projet' ? 'selected' : '' }}>Projet</option>
                    <option value="tâche" {{ request('type') == 'tâche' ? 'selected' : '' }}>Tâche</option>
                    <option value="employé" {{ request('type') == 'employé' ? 'selected' : '' }}>Employé</option>
                    <option value="mission" {{ request('type') == 'mission' ? 'selected' : '' }}>Mission</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Évaluateur</label>
                <select name="evaluateur_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tous</option>
                    @foreach($evaluateurs as $evaluateur)
                        <option value="{{ $evaluateur->id }}" {{ request('evaluateur_id') == $evaluateur->id ? 'selected' : '' }}>
                            {{ $evaluateur->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Filtrer
                </button>
            </div>
        </form>

        <!-- Liste -->
        <div class="space-y-4">
            @forelse($evaluations as $evaluation)
            <div class="border rounded-lg p-4 hover:shadow-md transition">
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
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Projet</span>
                            @elseif($evaluation->type == 'tâche')
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Tâche</span>
                            @elseif($evaluation->type == 'employé')
                                <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">Employé</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Mission</span>
                            @endif

                            {!! $evaluation->note_badge !!}
                        </div>

                        @if($evaluation->commentaires)
                            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($evaluation->commentaires, 150) }}</p>
                        @endif

                        <div class="text-xs text-gray-500">
                            Évalué par {{ $evaluation->evaluateur->name ?? 'N/A' }} 
                            le {{ $evaluation->created_at->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="flex space-x-2 ml-4">
                        <a href="{{ route('evaluations.show', $evaluation) }}" 
                           class="px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded">
                            Voir
                        </a>
                        @if($evaluation->evaluateur_id == auth()->id() || auth()->user()->hasRole('superadmin'))
                            <a href="{{ route('evaluations.edit', $evaluation) }}" 
                               class="px-3 py-1 text-sm text-green-600 hover:bg-green-50 rounded">
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
                        <p class="text-green-600 font-medium mb-1">✓ Points Forts:</p>
                        <p class="text-gray-700">{{ Str::limit($evaluation->points_forts, 80) }}</p>
                    </div>
                    @endif
                    @if($evaluation->points_amelioration)
                    <div>
                        <p class="text-orange-600 font-medium mb-1">⚠ À Améliorer:</p>
                        <p class="text-gray-700">{{ Str::limit($evaluation->points_amelioration, 80) }}</p>
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
