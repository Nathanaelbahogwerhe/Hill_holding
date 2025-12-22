@extends('layouts.app')

@section('title', 'Détails de la Tâche')

@section('content')
<div class="bg-hh-card rounded-lg shadow p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">ðŸ“ Détails de la tâche</h2>
        <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-hh-primary text-white rounded hover:bg-hh-primary-dark">
            â† Retour à  la liste
        </a>
    </div>

    <div class="space-y-4">
        <div>
            <label class="block font-medium mb-1">Titre</label>
            <p class="text-gray-700">{{ $task->title }}</p>
        </div>

        <div>
            <label class="block font-medium mb-1">Projet</label>
            <p class="text-gray-700">{{ $task->project->name ?? '—' }}</p>
        </div>

        <div>
            <label class="block font-medium mb-1">Responsable / Assigné à </label>
            <p class="text-gray-700">{{ $task->assignedTo->name ?? 'Non assigné' }}</p>
        </div>

        <div>
            <label class="block font-medium mb-1">Description</label>
            <p class="text-gray-700 whitespace-pre-line">{{ $task->description ?? '—' }}</p>
        </div>

        <div>
            <label class="block font-medium mb-1">Statut</label>
            <span class="px-2 py-1 rounded font-medium 
                {{ $task->status === 'En cours' ? 'bg-yellow-100 text-yellow-700' :
                   ($task->status === 'Terminé' ? 'bg-green-100 text-green-700' : 
                   'bg-gray-100 text-gray-700') }}">
                {{ $task->status }}
            </span>
        </div>

        <div>
            <label class="block font-medium mb-1">Échéance</label>
            <p class="text-gray-700">{{ $task->due_date?->format('d/m/Y') ?? '—' }}</p>
        </div>
    </div>

    <div class="mt-6 flex gap-2">
        <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 bg-hh-secondary text-white rounded hover:bg-hh-secondary-dark">
            Modifier
        </a>
        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Supprimer cette tâche ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                Supprimer
            </button>
        </form>
    </div>
</div>
@endsection







