@extends('layouts.app')
@section('title', 'Paramètres Système')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-hh-light">Paramètres Système</h1>
            <p class="text-sm text-hh-muted mt-1">Gérer les paramètres de configuration de l'application</p>
        </div>
        <a href="{{ route('admin.system-settings.create') }}" class="px-6 py-2 bg-hh-gold text-hh-dark rounded-xl hover:bg-hh-gold/90 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nouveau Paramètre
        </a>
    </div>

    {{-- Maintenance Mode Toggle --}}
    <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Mode Maintenance
                </h3>
                <p class="text-sm text-hh-muted mt-1">Activer/désactiver l'accès au site pour maintenance</p>
            </div>
            <form method="POST" action="{{ route('admin.system-settings.maintenance.toggle') }}">
                @csrf
                <button type="submit" class="px-6 py-3 {{ app()->isDownForMaintenance() ? 'bg-green-600 hover:bg-green-700' : 'bg-orange-600 hover:bg-orange-700' }} text-white rounded-xl transition flex items-center gap-2">
                    @if(app()->isDownForMaintenance())
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Désactiver Maintenance
                    @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Activer Maintenance
                    @endif
                </button>
            </form>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-hh-card rounded-xl p-4 border border-hh-border">
        <form method="GET" action="{{ route('admin.system-settings.index') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par clé ou description..." class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-xl text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold">
            </div>
            <div>
                <select name="category" class="px-4 py-2 bg-hh-dark border border-hh-border rounded-xl text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-hh-gold text-hh-dark rounded-xl hover:bg-hh-gold/90 transition">
                Filtrer
            </button>
            <a href="{{ route('admin.system-settings.index') }}" class="px-6 py-2 bg-hh-dark border border-hh-border rounded-xl hover:bg-hh-dark/50 transition">
                Réinitialiser
            </a>
        </form>
    </div>

    {{-- Settings by Category --}}
    @foreach($settingsByCategory as $category => $settings)
    <div class="bg-hh-card rounded-xl border border-hh-border overflow-hidden">
        <div class="px-6 py-4 bg-hh-dark/50 border-b border-hh-border">
            <h3 class="text-lg font-semibold">{{ ucfirst($category) }}</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-hh-dark/30">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Clé</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Valeur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Public</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-hh-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-hh-border">
                    @forelse($settings as $setting)
                    <tr class="hover:bg-hh-dark/30 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-hh-light">{{ $setting->key }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-hh-light max-w-xs">
                                @if($setting->type === 'boolean')
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $setting->value ? 'bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/300/20 text-green-500' : 'bg-red-500/20 text-red-500' }}">
                                    {{ $setting->value ? 'Oui' : 'Non' }}
                                </span>
                                @elseif($setting->type === 'json')
                                <code class="text-xs bg-hh-dark/50 px-2 py-1 rounded">JSON</code>
                                @else
                                {{ Str::limit($setting->value, 50) }}
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded bg-hh-dark/50 text-hh-muted">
                                {{ $setting->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-hh-muted max-w-md">
                            {{ $setting->description ? Str::limit($setting->description, 60) : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($setting->is_public)
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            @else
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                            <a href="{{ route('admin.system-settings.edit', $setting) }}" class="text-blue-500 hover:text-blue-400">
                                Modifier
                            </a>
                            <form method="POST" action="{{ route('admin.system-settings.destroy', $setting) }}" class="inline" onsubmit="return confirm('Supprimer ce paramètre?')">
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
                        <td colspan="6" class="px-6 py-4 text-center text-hh-muted">
                            Aucun paramètre trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

    {{-- Stats --}}
    <div class="bg-hh-card rounded-xl p-4 border border-hh-border">
        <p class="text-sm text-hh-muted">
            Total: <span class="font-semibold text-hh-light">{{ $totalCount }}</span> paramètre(s) | 
            <span class="font-semibold text-hh-light">{{ $settingsByCategory->count() }}</span> catégorie(s)
        </p>
    </div>
</div>
@endsection
