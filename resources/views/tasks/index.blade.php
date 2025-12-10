@extends('layouts.app')

@section('title', 'TÃ¢ches')

@section('content')
<div class="bg-hh-card dark:bg-hh-gray-dark rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-hh-dark dark:text-white">Liste des tÃ¢ches</h2>
        <a href="{{ route('tasks.create') }}" 
           class="px-4 py-2 bg-hh-primary text-white rounded hover:bg-hh-primary-dark font-semibold">
            + Nouvelle tÃ¢che
        </a>
    </div>

    <table class="min-w-full text-sm text-left">
        <thead class="bg-hh-dark text-white uppercase text-xs font-semibold">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Titre</th>
                <th class="px-4 py-2">Projet</th>
                <th class="px-4 py-2">AssignÃ© Ã </th>
                <th class="px-4 py-2">Statut</th>
                <th class="px-4 py-2">Ã‰chÃ©ance</th>
                <th class="px-4 py-2 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-hh-border text-sm text-hh-dark dark:text-gray-200">
            @forelse($tasks as $task)
                <tr class="hover:bg-hh-gray-light dark:hover:bg-hh-gray-darker">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 font-medium">{{ $task->title }}</td>
                    <td class="px-4 py-2">{{ $task->project->name ?? 'â€”' }}</td>
                    <td class="px-4 py-2">{{ $task->assignedTo->name ?? 'Non assignÃ©' }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs rounded font-medium 
                            {{ $task->status === 'En cours' ? 'bg-yellow-100 text-yellow-700' :
                               ($task->status === 'TerminÃ©' ? 'bg-green-100 text-green-700' : 
                               'bg-gray-100 text-gray-700') }}">
                            {{ $task->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') ?? 'â€”' }}</td>
                    <td class="px-4 py-2 text-right flex justify-end gap-2">
                        <a href="{{ route('tasks.show', $task) }}" 
                           class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs font-semibold">
                            Voir
                        </a>
                        <a href="{{ route('tasks.edit', $task) }}" 
                           class="px-2 py-1 bg-yellow-500 text-black rounded hover:bg-yellow-600 text-xs font-semibold">
                            Modifier
                        </a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" 
                              onsubmit="return confirm('Supprimer cette tÃ¢che ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs font-semibold">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">Aucune tÃ¢che enregistrÃ©e.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection







