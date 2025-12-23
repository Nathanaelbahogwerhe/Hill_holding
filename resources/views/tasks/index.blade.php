@extends('layouts.app')

@section('title', 'Tâches')

@section('content')
<div class="bg-hh-card rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-hh-dark">Liste des tâches</h2>
        <a href="{{ route('tasks.create') }}" 
           class="px-4 py-2 bg-hh-primary text-white rounded hover:bg-hh-primary-dark font-semibold">
            + Nouvelle tâche
        </a>
    </div>

    <table class="min-w-full text-sm text-left">
        <thead class="bg-hh-dark text-white uppercase text-xs font-semibold">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Titre</th>
                <th class="px-4 py-2">Projet</th>
                <th class="px-4 py-2">Assigné à </th>
                <th class="px-4 py-2">Statut</th>
                <th class="px-4 py-2">Échéance</th>
                <th class="px-4 py-2 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-hh-border text-sm text-hh-dark">
            @forelse($tasks as $task)
                <tr class="hover:bg-hh-gray-light">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 font-medium">{{ $task->title }}</td>
                    <td class="px-4 py-2">{{ $task->project->name ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $task->assignedTo->name ?? 'Non assigné' }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs rounded font-medium 
                            {{ $task->status === 'En cours' ? 'bg-yellow-100 text-yellow-700' :
                               ($task->status === 'Terminé' ? 'bg-green-100 text-green-700' : 
                               'bg-gray-100 text-[#D4AF37]') }}">
                            {{ $task->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') ?? '—' }}</td>
                    <td class="px-4 py-2 text-right flex justify-end gap-2">
                        <a href="{{ route('tasks.show', $task) }}" 
                           class="px-2 py-1 bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/300 text-white rounded hover:bg-blue-600 text-xs font-semibold">
                            Voir
                        </a>
                        <a href="{{ route('tasks.edit', $task) }}" 
                           class="px-2 py-1 bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 text-black rounded hover:bg-yellow-600 text-xs font-semibold">
                            Modifier
                        </a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" 
                              onsubmit="return confirm('Supprimer cette tâche ?')">
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
                    <td colspan="7" class="text-center py-4 text-gray-500">Aucune tâche enregistrée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection







