@extends('layouts.app')

@section('title', 'Créer un projet')

@section('content')
<div class="bg-hh-card rounded-xl shadow p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">âž• Créer un projet</h2>

    <form action="{{ route('projects.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-medium mb-1">Nom du projet</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="responsible_id" class="block font-medium mb-1">Responsable</label>
            <select name="responsible_id" id="responsible_id"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
                <option value="">— Sélectionner —</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('responsible_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('responsible_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="status" class="block font-medium mb-1">Statut</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
                @foreach(['En cours','Terminé','En attente'] as $status)
                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="start_date" class="block font-medium mb-1">Date de début</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
        </div>

        <div>
            <label for="end_date" class="block font-medium mb-1">Date de fin prévue</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
        </div>

        <div>
            <label for="due_date" class="block font-medium mb-1">Date d’échéance</label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">
        </div>

        <div>
            <label for="description" class="block font-medium mb-1">Description</label>
            <textarea name="description" id="description" rows="4" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">{{ old('description') }}</textarea>
        </div>

        <div>
            <label for="details" class="block font-medium mb-1">Détails</label>
            <textarea name="details" id="details" rows="4" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hh-primary">{{ old('details') }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-hh-primary text-white rounded hover:bg-hh-primary-dark">Créer</button>
        </div>
    </form>
</div>
@endsection







