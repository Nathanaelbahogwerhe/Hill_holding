@extends('layouts.app')
@section('title', 'Logs d\'Activité')

@section('content')
<div class="space-y-6">
    {{-- Header with Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-hh-card rounded-lg p-4 border border-hh-border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-hh-muted">Total Logs</p>
                    <p class="text-2xl font-bold text-hh-light mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-hh-card rounded-lg p-4 border border-hh-border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-hh-muted">Aujourd'hui</p>
                    <p class="text-2xl font-bold text-hh-light mt-1">{{ $stats['today'] }}</p>
                </div>
                <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-hh-card rounded-lg p-4 border border-hh-border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-hh-muted">Cette Semaine</p>
                    <p class="text-2xl font-bold text-hh-light mt-1">{{ $stats['week'] }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-hh-card rounded-lg p-6 border border-hh-border">
        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm text-hh-muted mb-2">Utilisateur</label>
                <select name="user_id" class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-lg text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold">
                    <option value="">Tous</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-hh-muted mb-2">Action</label>
                <select name="action" class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-lg text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold">
                    <option value="">Toutes</option>
                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Création</option>
                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Modification</option>
                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Suppression</option>
                    <option value="logged_in" {{ request('action') == 'logged_in' ? 'selected' : '' }}>Connexion</option>
                    <option value="logged_out" {{ request('action') == 'logged_out' ? 'selected' : '' }}>Déconnexion</option>
                </select>
            </div>

            <div>
                <label class="block text-sm text-hh-muted mb-2">Date Début</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-lg text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold">
            </div>

            <div>
                <label class="block text-sm text-hh-muted mb-2">Date Fin</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-lg text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold">
            </div>

            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="px-6 py-2 bg-hh-gold text-hh-dark rounded-lg hover:bg-hh-gold/90 transition">
                    Filtrer
                </button>
                <a href="{{ route('admin.activity-logs.index') }}" class="px-6 py-2 bg-hh-dark border border-hh-border rounded-lg hover:bg-hh-dark/50 transition">
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    {{-- Clear Old Logs Actions --}}
    <div class="bg-hh-card rounded-lg p-4 border border-hh-border flex items-center justify-between">
        <div>
            <h3 class="font-semibold">Nettoyer les anciens logs</h3>
            <p class="text-sm text-hh-muted">Supprimer les logs antérieurs à une période donnée</p>
        </div>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('admin.activity-logs.clear', ['days' => 30]) }}" class="inline">
                @csrf
                <button type="submit" onclick="return confirm('Supprimer les logs de plus de 30 jours?')" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-sm transition">
                    &gt; 30 jours
                </button>
            </form>
            <form method="POST" action="{{ route('admin.activity-logs.clear', ['days' => 60]) }}" class="inline">
                @csrf
                <button type="submit" onclick="return confirm('Supprimer les logs de plus de 60 jours?')" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-sm transition">
                    &gt; 60 jours
                </button>
            </form>
            <form method="POST" action="{{ route('admin.activity-logs.clear', ['days' => 90]) }}" class="inline">
                @csrf
                <button type="submit" onclick="return confirm('Supprimer les logs de plus de 90 jours?')" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-sm transition">
                    &gt; 90 jours
                </button>
            </form>
        </div>
    </div>

    {{-- Logs Table --}}
    <div class="bg-hh-card rounded-lg border border-hh-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-hh-dark/50 border-b border-hh-border">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Utilisateur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Modèle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">IP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-hh-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-hh-border">
                    @forelse($logs as $log)
                    <tr class="hover:bg-hh-dark/30 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-hh-light">{{ $log->user->name ?? 'Système' }}</div>
                            <div class="text-xs text-hh-muted">{{ $log->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $log->action_color }}">
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-hh-muted">
                            {{ $log->model_type ? class_basename($log->model_type) : '-' }}
                            @if($log->model_id)
                            <span class="text-xs">#{{ $log->model_id }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-hh-light max-w-xs truncate">
                            {{ $log->description }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-hh-muted">
                            {{ $log->ip_address ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-hh-muted">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                            <a href="{{ route('admin.activity-logs.show', $log) }}" class="text-blue-500 hover:text-blue-400">
                                Détails
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-hh-muted">
                            Aucun log trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-hh-border">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
