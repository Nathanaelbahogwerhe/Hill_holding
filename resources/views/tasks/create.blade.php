@extends('layouts.app')

@section('title', 'Nouvelle Tâche')

@section('content')
<div class="bg-hh-card rounded-lg shadow p-6 max-w-4xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">ðŸ“ Créer une nouvelle tâche</h2>

    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="title" class="block font-medium mb-1">Titre</label>
            <input type="text" name="title" id="title"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary"
                value="{{ old('title') }}">
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="project_id" class="block font-medium mb-1">Projet</label>
            <select name="project_id" id="project_id"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
                <option value="">— Sélectionner —</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
            @error('project_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="assigned_to" class="block font-medium mb-1">Assigné à </label>
            <select name="assigned_to" id="assigned_to"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
                <option value="">— Sélectionner —</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ old('assigned_to') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                @endforeach
            </select>
            @error('assigned_to') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="status" class="block font-medium mb-1">Statut</label>
            <select name="status" id="status"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
                <option value="todo" {{ old('status') == 'todo' ? 'selected' : '' }}>à€ faire</option>
                <option value="doing" {{ old('status') == 'doing' ? 'selected' : '' }}>En cours</option>
                <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Terminé</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="due_date" class="block font-medium mb-1">Échéance</label>
            <input type="date" name="due_date" id="due_date"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary"
                value="{{ old('due_date') }}">
            @error('due_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="description" class="block font-medium mb-1">Description</label>
            <textarea name="description" id="description" rows="4"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-hh-primary text-white rounded hover:bg-hh-primary-dark">
            Créer la tâche
        </button>
    </form>
</div>
@endsection







