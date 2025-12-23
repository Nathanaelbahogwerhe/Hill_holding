@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="max-w-5xl mx-auto">
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">
                        Évaluation
                        @if($evaluation->evaluable)
                            : {{ $evaluation->evaluable->name ?? $evaluation->evaluable->titre ?? $evaluation->evaluable->title ?? '' }}
                        @endif
                    </h1>
                    <p class="text-neutral-400">{{ $evaluation->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="flex space-x-2">
                    @if($evaluation->evaluateur_id == auth()->id() || auth()->user()->hasRole('superadmin'))
                        <a href="{{ route('evaluations.edit', $evaluation) }}" 
                           class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50">
                            Modifier
                        </a>
                        <form action="{{ route('evaluations.destroy', $evaluation) }}" method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700">
                                Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Type et Note -->
            <div class="mb-6 flex space-x-3">
                @if($evaluation->type == 'projet')
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-blue-900/50 to-blue-800/50 border border-blue-500/30 text-blue-300">Projet</span>
                @elseif($evaluation->type == 'tâche')
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300">Tâche</span>
                @elseif($evaluation->type == 'employé')
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">Employé</span>
                @else
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Mission</span>
                @endif

                {!! $evaluation->note_badge !!}
            </div>

            <!-- Informations principales -->
            <div class="space-y-6">
                <!-- Note -->
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-2">Note</p>
                    <div class="flex items-center space-x-4">
                        <p class="text-4xl font-bold" style="color: {{ $evaluation->note_color }}">
                            {{ $evaluation->note }}/100
                        </p>
                        <div class="flex-1 bg-gray-200 rounded-full h-4">
                            <div class="h-4 rounded-full" 
                                 style="width: {{ $evaluation->note }}%; background-color: {{ $evaluation->note_color }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Commentaires -->
                @if($evaluation->commentaires)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-2">Commentaires</p>
                    <div class="prose max-w-none">
                        {!! nl2br(e($evaluation->commentaires)) !!}
                    </div>
                </div>
                @endif

                <!-- Points Forts -->
                @if($evaluation->points_forts)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-2">Points Forts</p>
                    <div class="bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/30 border-l-4 border-green-400 p-4">
                        <p class="text-green-700">{!! nl2br(e($evaluation->points_forts)) !!}</p>
                    </div>
                </div>
                @endif

                <!-- Points d'Amélioration -->
                @if($evaluation->points_amelioration)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-2">Points d'Amélioration</p>
                    <div class="bg-orange-50 border-l-4 border-orange-400 p-4">
                        <p class="text-orange-700">{!! nl2br(e($evaluation->points_amelioration)) !!}</p>
                    </div>
                </div>
                @endif

                <!-- Recommandations -->
                @if($evaluation->recommandations)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-2">Recommandations</p>
                    <div class="bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/30 border-l-4 border-blue-400 p-4">
                        <p class="text-blue-700">{!! nl2br(e($evaluation->recommandations)) !!}</p>
                    </div>
                </div>
                @endif

                <!-- Entité évaluée -->
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Entité Évaluée</p>
                    @if($evaluation->evaluable)
                        <p class="font-medium">
                            {{ $evaluation->evaluable->name ?? $evaluation->evaluable->titre ?? $evaluation->evaluable->title ?? 'N/A' }}
                        </p>
                        <p class="text-sm text-gray-500">Type: {{ $evaluation->evaluable_type }}</p>
                    @else
                        <p class="text-gray-500 italic">Non disponible</p>
                    @endif
                </div>

                <!-- Employé évalué (si applicable) -->
                @if($evaluation->evaluated_user_id)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Employé Évalué</p>
                    <p class="font-medium">{{ $evaluation->evaluatedUser->name ?? 'N/A' }}</p>
                </div>
                @endif

                <!-- Évaluateur -->
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Évalué par</p>
                    <p class="font-medium">{{ $evaluation->evaluateur->name ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-500">Le {{ $evaluation->created_at->format('d/m/Y à H:i') }}</p>
                    @if($evaluation->updated_at != $evaluation->created_at)
                        <p class="text-sm text-gray-500">Mis à jour le {{ $evaluation->updated_at->format('d/m/Y à H:i') }}</p>
                    @endif
                </div>
            </div>

            <!-- Bouton retour -->
            <div class="mt-6">
                <a href="{{ route('evaluations.index') }}" 
                   class="inline-flex items-center text-white hover:text-blue-800">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
