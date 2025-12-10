@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Modifier le rôle : {{ $role->name }}</h1>

    <form action="{{ route('roles.update', $role) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium">Nom du rôle</label>
            <input type="text" name="name" id="name" class="mt-1 w-full border rounded p-2"
                   value="{{ old('name', $role->name) }}" required>
        </div>

        <div>
            <h2 class="text-md font-semibold mb-2">Autorisations</h2>
            <div class="grid grid-cols-2 gap-2">
                @foreach($permissions as $permission)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                               {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                        <span>{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Mettre à jour</button>
            <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Annuler</a>
        </div>
    </form>
</div>
@endsection
