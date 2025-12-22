@extends('layouts.app')

@section('title', 'Détails du projet')

@section('content')
<div class="bg-hh-card rounded-lg shadow p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">ðŸ“‹ {{ $project->name }}</h2>

    <div class="space-y-3">
        <div><strong>Responsable :</strong> {{ $project->responsible->name ?? '—' }}</div>
        <div><strong>Statut :</strong> {{ $project->status }}</div>
        <div><strong>Date de début :</strong> {{ $project->start_date?->format('d/m/Y') ?? '—' }}</div>
        <div><strong>Date de fin prévue :</strong> {{ $project->end_date?->format('d/m/Y') ?? '—' }}</div>
        <div><strong>Date d’échéance :</strong> {{ $project->due_date?->format('d/m/Y') ?? '—' }}</div>
        <div><strong>Description :</strong></div>
        <div class="border p-3 rounded bg-hh-gray-light">{{ $project->description ?? '—' }}</div>
        <div><strong>Détails :</strong></div>
        <div class="border p-3 rounded bg-hh-gray-light">{{ $project->details ?? '—' }}</div>
    </div>

    <div class="mt-4 flex justify-end space-x-2">
        <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-yellow-500 text-black rounded hover:bg-yellow-600">Modifier</a>
        <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Supprimer ce projet ?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Supprimer</button>
        </form>
        <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Retour</a>
    </div>
</div>
@endsection







