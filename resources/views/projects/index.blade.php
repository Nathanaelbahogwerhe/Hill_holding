@extends('layouts.app')

@section('title', 'Projets')

@section('content')
<div class="bg-hh-card rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">ðŸ­ Liste des projets</h2>
        <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-hh-primary text-white rounded hover:bg-hh-primary-dark">
            + Nouveau projet
        </a>
    </div>

    <table class="min-w-full text-sm text-left">
        <thead class="bg-hh-gray-light uppercase text-gray-700">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Responsable</th>
                <th class="px-4 py-2">Statut</th>
                <th class="px-4 py-2">Début</th>
                <th class="px-4 py-2">Fin prévue</th>
                <th class="px-4 py-2">Échéance</th>
                <th class="px-4 py-2 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 font-medium">{{ $project->name }}</td>
                    <td class="px-4 py-2">{{ $project->responsible->name ?? '—' }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs rounded font-medium
                            {{ $project->status === 'En cours' ? 'bg-yellow-100 text-yellow-700' :
                               ($project->status === 'Terminé' ? 'bg-green-100 text-green-700' : 
                               'bg-gray-100 text-gray-700') }}">
                            {{ $project->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ $project->start_date?->format('d/m/Y') ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $project->due_date?->format('d/m/Y') ?? '—' }}</td>
                    <td class="px-4 py-2 text-right space-x-2">
                        <a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:text-blue-700">Voir</a>
                        <a href="{{ route('projects.edit', $project) }}" class="text-yellow-500 hover:text-yellow-700">Modifier</a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer ce projet ?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">Aucun projet enregistré.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection







