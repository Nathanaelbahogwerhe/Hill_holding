@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="max-w-5xl mx-auto">
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Rapport du {{ \Carbon\Carbon::parse($dailyOperation->date)->format('d/m/Y') }}</h1>
                    @if($dailyOperation->project)
                        <p class="text-neutral-400">Projet: {{ $dailyOperation->project->name }}</p>
                    @endif
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('daily_operations.edit', $dailyOperation) }}" 
                       class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50">
                        Modifier
                    </a>
                    <form action="{{ route('daily_operations.destroy', $dailyOperation) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rapport ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>

            <!-- Informations principales -->
            <div class="space-y-6">
                <!-- Activités Réalisées -->
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-2">Activités Réalisées</p>
                    <div class="prose max-w-none">
                        {!! nl2br(e($dailyOperation->activites_realisees)) !!}
                    </div>
                </div>

                <!-- Problèmes -->
                @if($dailyOperation->problemes_rencontres)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-2">Problèmes Rencontrés</p>
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <p class="text-red-700">{!! nl2br(e($dailyOperation->problemes_rencontres)) !!}</p>
                    </div>
                </div>
                @endif

                <!-- Solutions -->
                @if($dailyOperation->solutions_apportees)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-2">Solutions Apportées</p>
                    <div class="bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/30 border-l-4 border-green-400 p-4">
                        <p class="text-green-700">{!! nl2br(e($dailyOperation->solutions_apportees)) !!}</p>
                    </div>
                </div>
                @endif

                <!-- Prévisions -->
                @if($dailyOperation->previsions_lendemain)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-2">Prévisions du Lendemain</p>
                    <div class="bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/30 border-l-4 border-blue-400 p-4">
                        <p class="text-blue-700">{!! nl2br(e($dailyOperation->previsions_lendemain)) !!}</p>
                    </div>
                </div>
                @endif

                <!-- Observations -->
                @if($dailyOperation->observations)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-2">Observations</p>
                    <p class="text-[#D4AF37]">{!! nl2br(e($dailyOperation->observations)) !!}</p>
                </div>
                @endif

                <!-- Informations complémentaires -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($dailyOperation->nombre_personnel)
                    <div class="border-b pb-4">
                        <p class="text-sm text-neutral-400 mb-1">Nombre de Personnel</p>
                        <p class="text-lg font-semibold">{{ $dailyOperation->nombre_personnel }}</p>
                    </div>
                    @endif

                    <div class="border-b pb-4">
                        <p class="text-sm text-neutral-400 mb-1">Date</p>
                        <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($dailyOperation->date)->format('d/m/Y') }}</p>
                    </div>

                    @if($dailyOperation->project)
                    <div class="border-b pb-4">
                        <p class="text-sm text-neutral-400 mb-1">Projet</p>
                        <p class="font-medium">{{ $dailyOperation->project->name }}</p>
                    </div>
                    @endif

                    @if($dailyOperation->department)
                    <div class="border-b pb-4">
                        <p class="text-sm text-neutral-400 mb-1">Département</p>
                        <p class="font-medium">{{ $dailyOperation->department->name }}</p>
                    </div>
                    @endif

                    @if($dailyOperation->filiale)
                    <div class="border-b pb-4">
                        <p class="text-sm text-neutral-400 mb-1">Filiale</p>
                        <p class="font-medium">{{ $dailyOperation->filiale->name }}</p>
                    </div>
                    @endif

                    @if($dailyOperation->agence)
                    <div class="border-b pb-4">
                        <p class="text-sm text-neutral-400 mb-1">Agence</p>
                        <p class="font-medium">{{ $dailyOperation->agence->name }}</p>
                    </div>
                    @endif
                </div>

                <!-- Pièces jointes -->
                @if($dailyOperation->attachments)
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-2">Pièces Jointes</p>
                    <div class="space-y-2">
                        @foreach(json_decode($dailyOperation->attachments, true) as $attachment)
                            <a href="{{ Storage::url($attachment) }}" target="_blank"
                               class="flex items-center text-white hover:text-blue-800">
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

                <!-- Soumetteur -->
                <div class="border-b pb-4">
                    <p class="text-sm text-neutral-400 mb-1">Soumis par</p>
                    <p class="font-medium">{{ $dailyOperation->soumetteur->name ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-500">Le {{ $dailyOperation->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>

            <!-- Bouton retour -->
            <div class="mt-6">
                <a href="{{ route('daily_operations.index') }}" 
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
