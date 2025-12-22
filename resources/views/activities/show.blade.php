@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-2xl font-bold">{{ $activity->titre }}</h1>
                    <p class="text-gray-600">{{ \Carbon\Carbon::parse($activity->date_prevue)->format('d/m/Y') }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('activities.edit', $activity) }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Modifier
                    </a>
                    <form action="{{ route('activities.destroy', $activity) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette activité ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>

            <!-- Type et Statut -->
            <div class="mb-6 flex space-x-3">
                @if($activity->type == 'réunion')
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">Réunion</span>
                @elseif($activity->type == 'formation')
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Formation</span>
                @elseif($activity->type == 'mission')
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">Mission</span>
                @elseif($activity->type == 'événement')
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Événement</span>
                @else
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">Autre</span>
                @endif

                @if($activity->statut == 'planifiée')
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Planifiée</span>
                @elseif($activity->statut == 'en_cours')
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">En cours</span>
                @elseif($activity->statut == 'terminée')
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Terminée</span>
                @else
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Annulée</span>
                @endif
            </div>

            <!-- Informations principales -->
            <div class="space-y-6">
                @if($activity->description)
                <div class="border-b pb-4">
                    <p class="text-sm text-gray-600 mb-2">Description</p>
                    <div class="prose max-w-none">
                        {{ $activity->description }}
                    </div>
                </div>
                @endif

                <!-- Date et Heures -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-600 mb-1">Date Prévue</p>
                        <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($activity->date_prevue)->format('d/m/Y') }}</p>
                    </div>

                    @if($activity->heure_debut)
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-600 mb-1">Heure Début</p>
                        <p class="text-lg font-semibold">{{ $activity->heure_debut }}</p>
                    </div>
                    @endif

                    @if($activity->heure_fin)
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-600 mb-1">Heure Fin</p>
                        <p class="text-lg font-semibold">{{ $activity->heure_fin }}</p>
                    </div>
                    @endif
                </div>

                @if($activity->lieu)
                <div class="border-b pb-4">
                    <p class="text-sm text-gray-600 mb-1">Lieu</p>
                    <p class="text-lg font-semibold">{{ $activity->lieu }}</p>
                </div>
                @endif

                <!-- Associations -->
                @if($activity->project || $activity->department || $activity->filiale || $activity->agence)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($activity->project)
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-600 mb-1">Projet</p>
                        <p class="font-medium">{{ $activity->project->name }}</p>
                    </div>
                    @endif

                    @if($activity->department)
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-600 mb-1">Département</p>
                        <p class="font-medium">{{ $activity->department->name }}</p>
                    </div>
                    @endif

                    @if($activity->filiale)
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-600 mb-1">Filiale</p>
                        <p class="font-medium">{{ $activity->filiale->name }}</p>
                    </div>
                    @endif

                    @if($activity->agence)
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-600 mb-1">Agence</p>
                        <p class="font-medium">{{ $activity->agence->name }}</p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Participants -->
                @if($activity->participants)
                <div class="border-b pb-4">
                    <p class="text-sm text-gray-600 mb-2">Participants</p>
                    @php
                        $participantIds = json_decode($activity->participants, true) ?? [];
                        $participants = \App\Models\User::whereIn('id', $participantIds)->get();
                    @endphp
                    @if($participants->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($participants as $participant)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                    {{ $participant->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">Aucun participant</p>
                    @endif
                </div>
                @endif

                <!-- Créateur -->
                <div class="border-b pb-4">
                    <p class="text-sm text-gray-600 mb-1">Créé par</p>
                    <p class="font-medium">{{ $activity->creator->name ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-500">Le {{ $activity->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>

            <!-- Bouton retour -->
            <div class="mt-6">
                <a href="{{ route('activities.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
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
