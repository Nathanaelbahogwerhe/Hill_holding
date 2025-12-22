@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-2xl font-bold">{{ $report->titre }}</h1>
                    <p class="text-gray-600">{{ $report->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="flex space-x-2">
                    @if($report->statut == 'brouillon')
                        <a href="{{ route('reports.edit', $report) }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Modifier
                        </a>
                    @endif
                    
                    @if($report->statut == 'soumis' && (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('Admin Finance') || auth()->user()->hasRole('RH Manager')))
                        <form action="{{ route('reports.validate', $report) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="action" value="valider">
                            <button type="submit" 
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Valider
                            </button>
                        </form>
                        <form action="{{ route('reports.validate', $report) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="action" value="rejeter">
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                                    onclick="return confirm('Êtes-vous sûr de vouloir rejeter ce rapport ?')">
                                Rejeter
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Statut & Type -->
            <div class="mb-6 flex space-x-3">
                {!! $report->status_badge !!}
                {!! $report->type_badge !!}
            </div>

            <!-- Informations principales -->
            <div class="space-y-6">
                @if($report->date_debut || $report->date_fin)
                <div class="border-b pb-4">
                    <p class="text-sm text-gray-600 mb-2">Période couverte</p>
                    <p class="font-medium">
                        @if($report->date_debut)
                            Du {{ \Carbon\Carbon::parse($report->date_debut)->format('d/m/Y') }}
                        @endif
                        @if($report->date_fin)
                            au {{ \Carbon\Carbon::parse($report->date_fin)->format('d/m/Y') }}
                        @endif
                    </p>
                </div>
                @endif

                <!-- Contenu -->
                <div class="border-b pb-4">
                    <p class="text-sm text-gray-600 mb-2">Contenu</p>
                    <div class="prose max-w-none">
                        {!! nl2br(e($report->contenu)) !!}
                    </div>
                </div>

                <!-- Associations -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($report->project)
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-600 mb-2">Projet</p>
                        <p class="font-medium">{{ $report->project->name }}</p>
                    </div>
                    @endif

                    @if($report->department)
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-600 mb-2">Département</p>
                        <p class="font-medium">{{ $report->department->name }}</p>
                    </div>
                    @endif

                    @if($report->filiale)
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-600 mb-2">Filiale</p>
                        <p class="font-medium">{{ $report->filiale->name }}</p>
                    </div>
                    @endif

                    @if($report->agence)
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-600 mb-2">Agence</p>
                        <p class="font-medium">{{ $report->agence->name }}</p>
                    </div>
                    @endif
                </div>

                <!-- Soumetteur -->
                <div class="border-b pb-4">
                    <p class="text-sm text-gray-600 mb-2">Soumis par</p>
                    <p class="font-medium">{{ $report->soumetteur->name ?? 'N/A' }}</p>
                    @if($report->date_soumission)
                        <p class="text-sm text-gray-500">Le {{ \Carbon\Carbon::parse($report->date_soumission)->format('d/m/Y à H:i') }}</p>
                    @endif
                </div>

                <!-- Validation -->
                @if($report->validateur)
                <div class="border-b pb-4">
                    <p class="text-sm text-gray-600 mb-2">
                        {{ $report->statut == 'validé' ? 'Validé' : 'Rejeté' }} par
                    </p>
                    <p class="font-medium">{{ $report->validateur->name }}</p>
                    @if($report->date_validation)
                        <p class="text-sm text-gray-500">Le {{ \Carbon\Carbon::parse($report->date_validation)->format('d/m/Y à H:i') }}</p>
                    @endif
                    @if($report->commentaires)
                        <p class="mt-2 text-sm text-gray-700 italic">"{{ $report->commentaires }}"</p>
                    @endif
                </div>
                @endif

                <!-- Pièces jointes -->
                @if($report->attachments)
                <div class="border-b pb-4">
                    <p class="text-sm text-gray-600 mb-2">Pièces jointes</p>
                    <div class="space-y-2">
                        @foreach(json_decode($report->attachments, true) as $attachment)
                            <a href="{{ Storage::url($attachment) }}" target="_blank"
                               class="flex items-center text-blue-600 hover:text-blue-800">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                {{ basename($attachment) }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Bouton retour -->
            <div class="mt-6">
                <a href="{{ route('reports.index') }}" 
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
