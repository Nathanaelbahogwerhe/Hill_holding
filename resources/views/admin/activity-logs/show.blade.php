@extends('layouts.app')
@section('title', 'Détails du Log')

@section('content')
<div class="space-y-6">
    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.activity-logs.index') }}" class="inline-flex items-center gap-2 text-hh-gold hover:text-hh-gold/80 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Retour aux logs
        </a>
    </div>

    {{-- Log Details --}}
    <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold">Log d'Activité #{{ $log->id }}</h2>
            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $log->action_color }}">
                {{ ucfirst($log->action) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- User Info --}}
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-hh-muted mb-1">Utilisateur</label>
                    <div class="text-hh-light font-medium">{{ $log->user->name ?? 'Système' }}</div>
                    @if($log->user)
                    <div class="text-sm text-hh-muted">{{ $log->user->email }}</div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm text-hh-muted mb-1">Action</label>
                    <div class="text-hh-light">{{ ucfirst($log->action) }}</div>
                </div>

                <div>
                    <label class="block text-sm text-hh-muted mb-1">Description</label>
                    <div class="text-hh-light">{{ $log->description }}</div>
                </div>
            </div>

            {{-- Technical Info --}}
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-hh-muted mb-1">Modèle</label>
                    <div class="text-hh-light">{{ $log->model_type ? class_basename($log->model_type) : '-' }}</div>
                    @if($log->model_id)
                    <div class="text-sm text-hh-muted">ID: {{ $log->model_id }}</div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm text-hh-muted mb-1">Adresse IP</label>
                    <div class="text-hh-light">{{ $log->ip_address ?? '-' }}</div>
                </div>

                <div>
                    <label class="block text-sm text-hh-muted mb-1">User Agent</label>
                    <div class="text-hh-light text-sm break-all">{{ $log->user_agent ?? '-' }}</div>
                </div>

                <div>
                    <label class="block text-sm text-hh-muted mb-1">Date</label>
                    <div class="text-hh-light">{{ $log->created_at->format('d/m/Y à H:i:s') }}</div>
                    <div class="text-sm text-hh-muted">{{ $log->created_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>

        {{-- Changes --}}
        @if($log->changes)
        <div class="mt-6 pt-6 border-t border-hh-border">
            <h3 class="text-lg font-semibold mb-4">Modifications</h3>
            
            <div class="bg-hh-dark/50 rounded-xl p-4 border border-hh-border overflow-x-auto">
                <pre class="text-sm text-hh-light whitespace-pre-wrap">{{ json_encode($log->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
        @endif
    </div>

    {{-- Actions --}}
    <div class="flex justify-end">
        <form method="POST" action="{{ route('admin.activity-logs.destroy', $log) }}" onsubmit="return confirm('Supprimer ce log?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl transition">
                Supprimer ce log
            </button>
        </form>
    </div>
</div>
@endsection
