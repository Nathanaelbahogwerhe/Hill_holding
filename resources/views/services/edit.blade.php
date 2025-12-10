@extends('layouts.app')

@section('title', 'Modifier Service')

@section('content')
<div class="bg-white dark:bg-hh-gray-dark shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-semibold mb-4">Modifier le service</h1>

    <form action="{{ route('services.update', $service) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block font-medium">Nom</label>
            <input type="text" name="name" value="{{ $service->name }}" class="w-full border rounded p-2 dark:bg-hh-gray-darker" required>
        </div>

        <div>
            <label class="block font-medium">Description</label>
            <textarea name="description" rows="3" class="w-full border rounded p-2 dark:bg-hh-gray-darker">{{ $service->description }}</textarea>
        </div>

        <div>
            <label class="block font-medium">Prix</label>
            <input type="number" step="0.01" name="price" value="{{ $service->price }}" class="w-full border rounded p-2 dark:bg-hh-gray-darker" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-hh-green hover:bg-hh-green-dark text-white px-4 py-2 rounded">
                Mettre Ã  jour
            </button>
        </div>
    </form>
</div>
@endsection







