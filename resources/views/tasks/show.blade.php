@extends('layouts.app')

@section('title', 'DÃ©tails de la TÃ¢che')

@section('content')
<div class="bg-hh-card rounded-lg shadow p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">ðŸ“ DÃ©tails de la tÃ¢che</h2>
        <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-hh-primary text-white rounded hover:bg-hh-primary-dark">
            â† Retour Ã  la liste
        </a>
    </div>

    <div class="space-y-4">
        <div>
            <label class="block font-medium mb-1">Titre</label>
            <p class="text-gray-700 dark:text-gray-200">{{ $task->title }}</p>
        </div>

        <div>
            <label class="block font-medium mb-1">Projet</label>
            <p class="text-gray-700 dark:text-gray-200">{{ $task->project->name ?? 'â€”' }}</p>
        </div>

        <div>
            <label class="block font-medium mb-1">Responsable / AssignÃ© Ã </label>
            <p class="text-gray-700 dark:text-gray-200">{{ $task->assignedTo->name ?? 'Non assignÃ©' }}</p>
        </div>

        <div>
            <label class="block font-medium mb-1">Description</label>
            <p class="text-gray-700 dark:text-gray-200 whitespace-pre-line">{{ $task->description ?? 'â€”' }}</p>
        </div>

        <div>
            <label class="block font-medium mb-1">Statut</label>
            <span class="px-2 py-1 rounded font-medium 
                {{ $task->status === 'En cours' ? 'bg-yellow-100 text-yellow-700' :
                   ($task->status === 'TerminÃ©' ? 'bg-green-100 text-green-700' : 
                   'bg-gray-100 text-gray-700') }}">
                {{ $task->status }}
            </span>
        </div>

        <div>
            <label class="block font-medium mb-1">Ã‰chÃ©ance</label>
            <p class="text-gray-700 dark:text-gray-200">{{ $task->due_date?->format('d/m/Y') ?? 'â€”' }}</p>
        </div>
    </div>

    <div class="mt-6 flex gap-2">
        <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 bg-hh-secondary text-white rounded hover:bg-hh-secondary-dark">
            Modifier
        </a>
        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Supprimer cette tÃ¢che ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                Supprimer
            </button>
        </form>
    </div>
</div>
@endsection







