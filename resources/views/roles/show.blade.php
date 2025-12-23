@extends('layouts.app')
@section('title', 'Détails du Rôle')

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

    {{-- Role Details --}}
    <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold">Détails du Rôle</h2>
            <a href="{{ route('admin.roles.edit', $role->id) }}" class="px-4 py-2 bg-hh-gold text-hh-dark rounded-xl hover:bg-hh-gold/90 transition">
                Modifier
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm text-hh-muted mb-1">ID</label>
                <div class="text-hh-light font-medium">{{ $role->id }}</div>
            </div>
            
            <div>
                <label class="block text-sm text-hh-muted mb-1">Nom</label>
                <div class="text-hh-light font-medium">{{ $role->name }}</div>
            </div>
            
            <div>
                <label class="block text-sm text-hh-muted mb-1">Créé le</label>
                <div class="text-hh-light">{{ $role->created_at?->format('d/m/Y à H:i') ?? 'N/A' }}</div>
            </div>
            
            <div>
                <label class="block text-sm text-hh-muted mb-1">Mis à jour le</label>
                <div class="text-hh-light">{{ $role->updated_at?->format('d/m/Y à H:i') ?? 'N/A' }}</div>
            </div>
        </div>

        {{-- Permissions --}}
        <div class="mt-6 pt-6 border-t border-hh-border">
            <h3 class="text-lg font-semibold mb-4">Permissions associées ({{ $role->permissions->count() }})</h3>
            @if($role->permissions->count() > 0)
            <div class="flex flex-wrap gap-2">
                @foreach($role->permissions as $permission)
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/300/20 text-blue-500">
                    {{ $permission->name }}
                </span>
                @endforeach
            </div>
            @else
            <p class="text-sm text-hh-muted">Aucune permission associée à ce rôle</p>
            @endif
        </div>

        {{-- Users --}}
        <div class="mt-6 pt-6 border-t border-hh-border">
            <h3 class="text-lg font-semibold mb-4">Utilisateurs avec ce rôle ({{ $role->users->count() }})</h3>
            @if($role->users->count() > 0)
            <div class="space-y-2">
                @foreach($role->users as $user)
                <div class="flex items-center gap-3 p-3 bg-hh-dark/30 rounded border border-hh-border/50">
                    <div class="w-8 h-8 bg-hh-gold/10 rounded-full flex items-center justify-center text-hh-gold font-semibold text-sm">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-hh-light">{{ $user->name }}</p>
                        <p class="text-xs text-hh-muted">{{ $user->email }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-hh-muted">Aucun utilisateur n'a ce rôle</p>
            @endif
        </div>
    </div>

    {{-- Delete Action --}}
    <div class="bg-hh-card rounded-xl p-6 border border-red-500/20">
        <h3 class="text-lg font-semibold text-red-500 mb-2">Zone de danger</h3>
        <p class="text-sm text-hh-muted mb-4">La suppression de ce rôle est irréversible. Tous les utilisateurs perdront ce rôle.</p>
        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression définitive?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl transition">
                Supprimer ce rôle
            </button>
        </form>
    </div>
</div>
@endsection