@extends('layouts.app')
@section('title', 'Modifier le Rôle')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center gap-2 text-hh-gold hover:text-hh-gold/80 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Retour aux rôles
        </a>
    </div>

    {{-- Form --}}
    <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
        <h2 class="text-xl font-semibold mb-6">Modifier le rôle: {{ $role->name }}</h2>

        <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Role Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-hh-muted mb-2">
                    Nom du rôle <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-xl text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('name') border-red-500 @enderror">
                @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Permissions --}}
            <div>
                <label class="block text-sm font-medium text-hh-muted mb-3">
                    Permissions <span class="text-xs text-hh-muted">(Sélectionnez une ou plusieurs)</span>
                </label>
                <div class="bg-hh-dark/50 rounded-xl p-4 border border-hh-border max-h-96 overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @forelse($permissions as $permission)
                        <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-hh-dark/50 cursor-pointer transition">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }} class="w-4 h-4 rounded border-hh-border bg-hh-dark text-hh-gold focus:ring-2 focus:ring-hh-gold">
                            <span class="text-sm text-hh-light">{{ $permission->name }}</span>
                        </label>
                        @empty
                        <p class="text-sm text-hh-muted col-span-2">Aucune permission disponible</p>
                        @endforelse
                    </div>
                </div>
                @error('permissions')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-4 pt-6">
                <a href="{{ route('admin.roles.index') }}" class="px-6 py-2 bg-hh-dark border border-hh-border rounded-xl hover:bg-hh-dark/50 transition">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-hh-gold text-hh-dark rounded-xl hover:bg-hh-gold/90 transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
