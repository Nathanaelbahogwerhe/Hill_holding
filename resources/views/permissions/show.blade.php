@extends('layouts.app')
@section('title', 'Détails de la Permission')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center gap-2 text-hh-gold hover:text-hh-gold/80 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Retour aux permissions
        </a>
    </div>

    {{-- Permission Details --}}
    <div class="bg-hh-card rounded-lg p-6 border border-hh-border">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold">Détails de la Permission</h2>
            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="px-4 py-2 bg-hh-gold text-hh-dark rounded-lg hover:bg-hh-gold/90 transition">
                Modifier
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm text-hh-muted mb-1">ID</label>
                <div class="text-hh-light font-medium">{{ $permission->id }}</div>
            </div>
            
            <div>
                <label class="block text-sm text-hh-muted mb-1">Nom</label>
                <div class="text-hh-light font-medium">{{ $permission->name }}</div>
            </div>
            
            <div>
                <label class="block text-sm text-hh-muted mb-1">Guard</label>
                <div class="text-hh-light">{{ $permission->guard_name }}</div>
            </div>
            
            <div>
                <label class="block text-sm text-hh-muted mb-1">Créé le</label>
                <div class="text-hh-light">{{ $permission->created_at?->format('d/m/Y à H:i') ?? 'N/A' }}</div>
            </div>
            
            <div>
                <label class="block text-sm text-hh-muted mb-1">Mis à jour le</label>
                <div class="text-hh-light">{{ $permission->updated_at?->format('d/m/Y à H:i') ?? 'N/A' }}</div>
            </div>
        </div>

        {{-- Roles --}}
        <div class="mt-6 pt-6 border-t border-hh-border">
            <h3 class="text-lg font-semibold mb-4">Rôles avec cette permission ({{ $permission->roles->count() }})</h3>
            @if($permission->roles->count() > 0)
            <div class="flex flex-wrap gap-2">
                @foreach($permission->roles as $role)
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-purple-500/20 text-purple-500">
                    {{ $role->name }}
                </span>
                @endforeach
            </div>
            @else
            <p class="text-sm text-hh-muted">Aucun rôle n'utilise cette permission</p>
            @endif
        </div>
    </div>

    {{-- Delete Action --}}
    <div class="bg-hh-card rounded-lg p-6 border border-red-500/20">
        <h3 class="text-lg font-semibold text-red-500 mb-2">Zone de danger</h3>
        <p class="text-sm text-hh-muted mb-4">La suppression de cette permission est irréversible. Elle sera retirée de tous les rôles.</p>
        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression définitive?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                Supprimer cette permission
            </button>
        </form>
    </div>
</div>
@endsection