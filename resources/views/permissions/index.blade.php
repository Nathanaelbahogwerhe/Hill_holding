@extends('layouts.app')
@section('title', 'Gestion des Permissions')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-hh-light">Gestion des Permissions</h1>
            <p class="text-sm text-hh-muted mt-1">Créer et gérer les permissions du système</p>
        </div>
        <a href="{{ route('admin.permissions.create') }}" class="px-6 py-2 bg-hh-gold text-hh-dark rounded-lg hover:bg-hh-gold/90 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nouvelle Permission
        </a>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
    <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-4">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <p class="text-sm text-green-500">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    {{-- Permissions Table --}}
    <div class="bg-hh-card rounded-lg border border-hh-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-hh-dark/50 border-b border-hh-border">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Guard</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Rôles</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-hh-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-hh-border">
                    @forelse($permissions as $permission)
                    <tr class="hover:bg-hh-dark/30 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-hh-muted">
                            #{{ $permission->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-hh-light">{{ $permission->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded bg-hh-dark/50 text-hh-muted">
                                {{ $permission->guard_name ?? 'web' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-hh-muted">
                                {{ $permission->roles->count() }} rôle(s)
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                            <a href="{{ route('admin.permissions.show', $permission->id) }}" class="text-blue-500 hover:text-blue-400">
                                Détails
                            </a>
                            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="text-blue-500 hover:text-blue-400">
                                Modifier
                            </a>
                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette permission?')">
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
                        <td colspan="5" class="px-6 py-12 text-center text-hh-muted">
                            Aucune permission trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($permissions->hasPages())
        <div class="px-6 py-4 border-t border-hh-border">
            {{ $permissions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination (si paginé) -->
    @if(method_exists($permissions, 'hasPages') && $permissions->hasPages())
        <div class="mt-6">
            {{ $permissions->links() }}
        </div>
    @endif
</div>
@endsection