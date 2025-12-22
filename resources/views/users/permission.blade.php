@extends('layouts.app')
@section('title', 'Permissions de ' . $user->name)
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-hh-card rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-hh-gold">Permissions de {{ $user->name }}</h1>

        @if(session('success'))
        <div class="mb-4 p-4 bg-green-900 text-green-200 rounded-lg border border-green-700">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('users.permissions.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <p class="text-sm text-gray-400 mb-4">Sélectionnez les permissions à attribuer à cet utilisateur :</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($permissions as $permission)
                    <label class="flex items-center space-x-3 p-3 rounded-lg hover:bg-hh-bg cursor-pointer transition">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}
                            class="w-4 h-4 rounded">
                        <span class="text-sm">{{ $permission->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-3 pt-6">
                <button type="submit" class="px-6 py-2 bg-hh-gold text-black font-semibold rounded-lg hover:bg-yellow-500 transition">
                    Enregistrer les permissions ✅
                </button>
                <a href="{{ route('users.index') }}" class="px-6 py-2 bg-hh-border text-white rounded-lg hover:bg-gray-600 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection