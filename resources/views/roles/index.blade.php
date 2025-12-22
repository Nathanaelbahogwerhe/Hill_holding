@extends('layouts.app')
@section('title', 'Gestion des Rôles')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-hh-light">Gestion des Rôles</h1>
            <p class="text-sm text-hh-muted mt-1">Créer et gérer les rôles et permissions</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="px-6 py-2 bg-hh-gold text-hh-dark rounded-lg hover:bg-hh-gold/90 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nouveau Rôle
        </a>
    </div>

    {{-- Roles Table --}}
    <div class="bg-hh-card rounded-lg border border-hh-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-hh-dark/50 border-b border-hh-border">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Rôle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Permissions</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Utilisateurs</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-hh-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-hh-border">
                    @forelse($roles as $role)
                    <tr class="hover:bg-hh-dark/30 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-hh-light">{{ $role->name }}</div>
                            <div class="text-xs text-hh-muted">ID: {{ $role->id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @forelse($role->permissions->take(3) as $permission)
                                <span class="px-2 py-1 text-xs font-medium rounded bg-blue-500/20 text-blue-500">
                                    {{ $permission->name }}
                                </span>
                                @empty
                                <span class="text-xs text-hh-muted">Aucune permission</span>
                                @endforelse
                                @if($role->permissions->count() > 3)
                                <span class="px-2 py-1 text-xs font-medium rounded bg-hh-dark/50 text-hh-muted">
                                    +{{ $role->permissions->count() - 3 }}
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-hh-muted">
                            {{ $role->users->count() }} utilisateur(s)
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-blue-500 hover:text-blue-400">
                                Modifier
                            </a>
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce rôle?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-hh-muted">
                            Aucun rôle trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
