@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Gestion des autorisations</h1>
        <a href="{{ route('permissions.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">+ Nouvelle autorisation</a>
    </div>

    <ul class="space-y-2">
        @foreach ($permissions as $permission)
            <li class="flex items-center justify-between p-2 bg-hh-card border border-hh-border rounded">
                <div class="font-medium">{{ $permission->name }}</div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('permissions.edit', $permission->id) }}" class="px-2 py-1 bg-yellow-500 text-white rounded">Éditer</a>
                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Supprimer cette autorisation ?');" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded">Supprimer</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@endsection
