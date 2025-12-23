@extends('layouts.app')
@section('title', 'Dashboard Administration')

@section('content')
<div class="space-y-6">
    {{-- Actions Rapides --}}
    <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-hh-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Actions Rapides
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Clear Cache --}}
            <form method="POST" action="{{ route('admin.cache.clear') }}">
                @csrf
                <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold rounded-xl text-white flex items-center justify-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Vider Cache
                </button>
            </form>
            
            {{-- Optimize System --}}
            <form method="POST" action="{{ route('admin.system.optimize') }}">
                @csrf
                <button type="submit" class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 rounded-xl text-white flex items-center justify-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Optimiser
                </button>
            </form>
            
            {{-- Toggle Maintenance --}}
            <form method="POST" action="{{ route('admin.system-settings.maintenance.toggle') }}">
                @csrf
                <button type="submit" class="w-full px-4 py-3 bg-orange-600 hover:bg-orange-700 rounded-xl text-white flex items-center justify-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Maintenance
                </button>
            </form>
            
            {{-- System Info --}}
            <a href="{{ route('admin.system.info') }}" class="px-4 py-3 bg-purple-600 hover:bg-purple-700 rounded-xl text-white flex items-center justify-center gap-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Infos Système
            </a>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        {{-- Total Users --}}
        <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-hh-muted">Total Utilisateurs</p>
                    <p class="text-3xl font-bold text-hh-light mt-2">{{ $stats['users']['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/300/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-hh-muted mt-2">
                {{ $stats['users']['active'] }} actifs (7 jours)
            </p>
        </div>

        {{-- Total Activity Logs --}}
        <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-hh-muted">Logs Totaux</p>
                    <p class="text-3xl font-bold text-hh-light mt-2">{{ $stats['logs']['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/300/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-hh-muted mt-2">
                {{ $stats['logs']['today'] }} aujourd'hui
            </p>
        </div>

        {{-- Logs This Week --}}
        <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-hh-muted">Logs Cette Semaine</p>
                    <p class="text-3xl font-bold text-hh-light mt-2">{{ $stats['logs']['week'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- System Health --}}
        <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-hh-muted">État Système</p>
                    <p class="text-xl font-bold text-green-500 mt-2">Opérationnel</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/300/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-hh-muted mt-2">
                PHP {{ $systemInfo['php_version'] }}
            </p>
        </div>
    </div>

    {{-- Recent Activities & Users Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Activities --}}
        <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-hh-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Activités Récentes
            </h3>
            
            <div class="space-y-3">
                @forelse($recentActivities as $activity)
                <div class="flex items-start gap-3 p-3 bg-hh-dark/30 rounded border border-hh-border/50">
                    <div class="w-2 h-2 mt-2 rounded-full {{ $activity->action_color }}"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium">{{ $activity->user->name ?? 'Système' }}</p>
                        <p class="text-xs text-hh-muted">{{ $activity->action }} - {{ $activity->description }}</p>
                        <p class="text-xs text-hh-muted/70 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-hh-muted text-center py-4">Aucune activité récente</p>
                @endforelse
            </div>
            
            <div class="mt-4">
                <a href="{{ route('admin.activity-logs.index') }}" class="text-sm text-hh-gold hover:text-hh-gold/80 flex items-center gap-1">
                    Voir tous les logs
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Recent Users --}}
        <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-hh-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Utilisateurs Récents
            </h3>
            
            <div class="space-y-3">
                @forelse($recentUsers as $user)
                <div class="flex items-center gap-3 p-3 bg-hh-dark/30 rounded border border-hh-border/50">
                    <div class="w-10 h-10 bg-hh-gold/10 rounded-full flex items-center justify-center text-hh-gold font-semibold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ $user->name }}</p>
                        <p class="text-xs text-hh-muted truncate">{{ $user->email }}</p>
                    </div>
                    <div class="text-xs text-hh-muted text-right">
                        {{ $user->created_at->format('d/m/Y') }}
                    </div>
                </div>
                @empty
                <p class="text-sm text-hh-muted text-center py-4">Aucun utilisateur récent</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- System Information --}}
    <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-hh-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Informations Système
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-hh-dark/30 rounded border border-hh-border/50">
                <p class="text-xs text-hh-muted">Version PHP</p>
                <p class="text-lg font-semibold mt-1">{{ $systemInfo['php_version'] }}</p>
            </div>
            
            <div class="p-4 bg-hh-dark/30 rounded border border-hh-border/50">
                <p class="text-xs text-hh-muted">Version Laravel</p>
                <p class="text-lg font-semibold mt-1">{{ $systemInfo['laravel_version'] }}</p>
            </div>
            
            <div class="p-4 bg-hh-dark/30 rounded border border-hh-border/50">
                <p class="text-xs text-hh-muted">Environnement</p>
                <p class="text-lg font-semibold mt-1">{{ ucfirst($systemInfo['environment']) }}</p>
            </div>
            
            <div class="p-4 bg-hh-dark/30 rounded border border-hh-border/50">
                <p class="text-xs text-hh-muted">Cache Driver</p>
                <p class="text-lg font-semibold mt-1">{{ $systemInfo['cache_driver'] }}</p>
            </div>
            
            <div class="p-4 bg-hh-dark/30 rounded border border-hh-border/50">
                <p class="text-xs text-hh-muted">Queue Driver</p>
                <p class="text-lg font-semibold mt-1">{{ $systemInfo['queue_driver'] }}</p>
            </div>
            
            <div class="p-4 bg-hh-dark/30 rounded border border-hh-border/50">
                <p class="text-xs text-hh-muted">Session Driver</p>
                <p class="text-lg font-semibold mt-1">{{ $systemInfo['session_driver'] }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
