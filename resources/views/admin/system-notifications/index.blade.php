@extends('layouts.app')
@section('title', 'Notifications Système')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-hh-light">Notifications Système</h1>
            <p class="text-sm text-hh-muted mt-1">Gérer les notifications diffusées aux utilisateurs</p>
        </div>
        <a href="{{ route('admin.system-notifications.create') }}" class="px-6 py-2 bg-hh-gold text-hh-dark rounded-xl hover:bg-hh-gold/90 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nouvelle Notification
        </a>
    </div>

    {{-- Notifications Table --}}
    <div class="bg-hh-card rounded-xl border border-hh-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-hh-dark/50 border-b border-hh-border">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Cible</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Actif</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Expire le</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Créé par</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-hh-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-hh-border">
                    @forelse($notifications as $notification)
                    <tr class="hover:bg-hh-dark/30 transition">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-hh-light">{{ $notification->title }}</div>
                            <div class="text-xs text-hh-muted mt-1">{{ Str::limit($notification->message, 60) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $notification->type_color }}">
                                {{ ucfirst($notification->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-hh-light">{{ ucfirst($notification->target) }}</div>
                            @if($notification->role_name)
                            <div class="text-xs text-hh-muted">{{ $notification->role_name }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.system-notifications.toggle', $notification) }}" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1 text-xs font-medium rounded-full {{ $notification->is_active ? 'bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/300/20 text-green-500' : 'bg-red-500/20 text-red-500' }} hover:opacity-80 transition">
                                    {{ $notification->is_active ? 'Actif' : 'Inactif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-hh-muted">
                            @if($notification->expires_at)
                            {{ $notification->expires_at->format('d/m/Y') }}
                            @if($notification->is_expired)
                            <span class="text-red-500">(Expiré)</span>
                            @endif
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-hh-muted">
                            {{ $notification->creator->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                            <a href="{{ route('admin.system-notifications.edit', $notification) }}" class="text-blue-500 hover:text-blue-400">
                                Modifier
                            </a>
                            <form method="POST" action="{{ route('admin.system-notifications.destroy', $notification) }}" class="inline" onsubmit="return confirm('Supprimer cette notification?')">
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
                        <td colspan="7" class="px-6 py-12 text-center text-hh-muted">
                            Aucune notification trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($notifications->hasPages())
        <div class="px-6 py-4 border-t border-hh-border">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
