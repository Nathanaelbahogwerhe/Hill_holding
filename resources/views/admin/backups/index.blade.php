@extends('layouts.app')
@section('title', 'Sauvegardes Système')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-hh-light">Sauvegardes Système</h1>
            <p class="text-sm text-hh-muted mt-1">Créer et gérer les sauvegardes de la base de données et des fichiers</p>
        </div>
    </div>

    {{-- Create Backup Form --}}
    <div class="bg-hh-card rounded-lg p-6 border border-hh-border">
        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-hh-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Créer une nouvelle sauvegarde
        </h3>

        <form method="POST" action="{{ route('admin.backups.create') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-hh-muted mb-3">Type de sauvegarde</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Database Backup --}}
                    <label class="relative flex items-center p-4 border-2 border-hh-border rounded-lg cursor-pointer hover:border-hh-gold transition">
                        <input type="radio" name="type" value="database" required class="w-4 h-4 text-hh-gold focus:ring-hh-gold">
                        <div class="ml-3">
                            <div class="text-sm font-medium text-hh-light">Base de Données</div>
                            <div class="text-xs text-hh-muted">Sauvegarde MySQL uniquement</div>
                        </div>
                    </label>

                    {{-- Files Backup --}}
                    <label class="relative flex items-center p-4 border-2 border-hh-border rounded-lg cursor-pointer hover:border-hh-gold transition">
                        <input type="radio" name="type" value="files" class="w-4 h-4 text-hh-gold focus:ring-hh-gold">
                        <div class="ml-3">
                            <div class="text-sm font-medium text-hh-light">Fichiers</div>
                            <div class="text-xs text-hh-muted">Dossiers storage et public</div>
                        </div>
                    </label>

                    {{-- Full Backup --}}
                    <label class="relative flex items-center p-4 border-2 border-hh-border rounded-lg cursor-pointer hover:border-hh-gold transition">
                        <input type="radio" name="type" value="full" class="w-4 h-4 text-hh-gold focus:ring-hh-gold">
                        <div class="ml-3">
                            <div class="text-sm font-medium text-hh-light">Complète</div>
                            <div class="text-xs text-hh-muted">Base de données + fichiers</div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="px-6 py-3 bg-hh-gold text-hh-dark rounded-lg hover:bg-hh-gold/90 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Créer la sauvegarde
                </button>
            </div>
        </form>
    </div>

    {{-- Warning Info --}}
    <div class="bg-orange-500/10 border border-orange-500/20 rounded-lg p-4">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <div>
                <p class="text-sm font-medium text-orange-500">Attention</p>
                <p class="text-xs text-hh-muted mt-1">Les sauvegardes complètes peuvent prendre du temps et consommer de l'espace disque. Assurez-vous d'avoir suffisamment d'espace disponible.</p>
            </div>
        </div>
    </div>

    {{-- Backups List --}}
    <div class="bg-hh-card rounded-lg border border-hh-border overflow-hidden">
        <div class="px-6 py-4 bg-hh-dark/50 border-b border-hh-border">
            <h3 class="text-lg font-semibold">Liste des Sauvegardes</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-hh-dark/30">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Nom du Fichier</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Taille</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Créé par</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-hh-muted uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-hh-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-hh-border">
                    @forelse($backups as $backup)
                    <tr class="hover:bg-hh-dark/30 transition">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-hh-light truncate max-w-xs" title="{{ $backup->filename }}">
                                {{ $backup->filename }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($backup->type === 'database')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-500/20 text-blue-500">
                                Base de données
                            </span>
                            @elseif($backup->type === 'files')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-500/20 text-green-500">
                                Fichiers
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-500/20 text-purple-500">
                                Complète
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-hh-muted">
                            {{ $backup->size_formatted }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-hh-light">{{ $backup->creator->name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $backup->status_color }}">
                                {{ ucfirst($backup->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-hh-muted">
                            {{ $backup->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                            @if($backup->status === 'completed')
                            <a href="{{ route('admin.backups.download', $backup) }}" class="text-blue-500 hover:text-blue-400">
                                Télécharger
                            </a>
                            @endif
                            <form method="POST" action="{{ route('admin.backups.destroy', $backup) }}" class="inline" onsubmit="return confirm('Supprimer cette sauvegarde?')">
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
                            Aucune sauvegarde trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($backups->hasPages())
        <div class="px-6 py-4 border-t border-hh-border">
            {{ $backups->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
