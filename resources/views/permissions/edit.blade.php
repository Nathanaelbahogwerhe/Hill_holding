@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Modifier l\'autorisation</h1>

    <form action="{{ route('permissions.update', $permission) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block font-medium">Nom de l'autorisation</label>
            <input type="text" name="name" value="{{ old('name', $permission->name) }}" class="w-full border rounded p-2" required>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Mettre à jour</button>
            <a href="{{ route('permissions.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Annuler</a>
        </div>
    </form>
</div>
@endsection
