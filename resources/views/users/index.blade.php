@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <!-- Header avec gradient doré -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#D4AF37] to-yellow-500 mb-2">
                    👥 Gestion des Utilisateurs
                </h1>
                <p class="text-neutral-400">Administration des comptes et permissions</p>
            </div>
            <a href="{{ route('users.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-600 hover:from-yellow-600 hover:to-[#D4AF37] text-black rounded-lg font-bold transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(212,175,55,0.5)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouvel Utilisateur
            </a>
        </div>
    </div>

    <!-- Messages de succès -->
    @if (session('success'))
        <div class="bg-gradient-to-r from-green-900/50 to-green-800/30 border-l-4 border-green-500 text-green-100 p-4 rounded-lg mb-6 flex items-center gap-3">
            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-[#D4AF37]/30 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-400 text-sm">Total Utilisateurs</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $users->total() ?? $users->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-full flex items-center justify-center">
                    <span class="text-2xl">👥</span>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-blue-500/30 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-400 text-sm">Actifs</p>
                    <p class="text-3xl font-bold text-blue-400 mt-1">{{ $users->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center">
                    <span class="text-2xl">✓</span>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-neutral-900 to-black border border-purple-500/30 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-400 text-sm">Rôles Assignés</p>
                    <p class="text-3xl font-bold text-purple-400 mt-1">{{ $users->sum(fn($u) => $u->roles->count()) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center">
                    <span class="text-2xl">🎭</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Table des utilisateurs -->
    <div class="bg-gradient-to-br from-neutral-900 to-black rounded-xl shadow-2xl overflow-hidden border border-neutral-800">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-[#D4AF37]/20 to-transparent border-b border-[#D4AF37]/30">
                        <th class="px-6 py-4 text-left text-sm font-bold text-[#D4AF37]">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-[#D4AF37]">Utilisateur</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-[#D4AF37]">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-[#D4AF37]">Filiale</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-[#D4AF37]">Rôles</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-[#D4AF37]">Statut</th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-[#D4AF37]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($users as $user)
                        <tr class="hover:bg-neutral-800/50 transition-all duration-200">
                            <td class="px-6 py-4 text-sm text-neutral-400">#{{ $user->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#D4AF37] to-yellow-600 flex items-center justify-center text-black font-bold">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">{{ $user->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-neutral-500">ID: {{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-300">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $user->email ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($user->filiale)
                                    <span class="inline-flex items-center gap-1 bg-blue-900/30 text-blue-300 px-3 py-1 rounded-full text-xs font-semibold border border-blue-700/50">
                                        🏢 {{ $user->filiale->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-[#D4AF37]/20 text-[#D4AF37] px-3 py-1 rounded-full text-xs font-semibold border border-[#D4AF37]/50">
                                        🏛️ Maison Mère
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($user->roles as $role)
                                        <span class="inline-flex items-center bg-purple-900/30 text-purple-300 px-2 py-1 rounded text-xs font-semibold border border-purple-700/50">
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-neutral-500">Aucun rôle</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 bg-green-900/30 text-green-300 px-3 py-1 rounded-full text-xs font-semibold border border-green-700/50">
                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                    Actif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('users.show', $user->id) }}" 
                                       class="p-2 bg-blue-900/30 hover:bg-blue-900/50 text-blue-400 rounded-lg transition-all duration-200 hover:scale-110"
                                       title="Voir">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                       class="p-2 bg-[#D4AF37]/20 hover:bg-[#D4AF37]/30 text-[#D4AF37] rounded-lg transition-all duration-200 hover:scale-110"
                                       title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 bg-red-900/30 hover:bg-red-900/50 text-red-400 rounded-lg transition-all duration-200 hover:scale-110"
                                                title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-4">
                                    <div class="w-20 h-20 bg-neutral-800 rounded-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-neutral-400 text-lg font-semibold">Aucun utilisateur trouvé</p>
                                        <p class="text-neutral-600 text-sm mt-1">Commencez par créer votre premier utilisateur</p>
                                    </div>
                                    <a href="{{ route('users.create') }}" 
                                       class="mt-4 inline-flex items-center gap-2 px-6 py-3 bg-[#D4AF37] hover:bg-yellow-600 text-black rounded-lg font-bold transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Créer un utilisateur
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination avec style amélioré -->
    @if(method_exists($users, 'hasPages') && $users->hasPages())
        <div class="mt-6">
            <div class="flex justify-center">
                {{ $users->links() }}
            </div>
        </div>
    @endif
</div>

<style>
    /* Style personnalisé pour la pagination */
    .pagination {
        display: flex;
        gap: 0.5rem;
    }
    .pagination > * {
        padding: 0.5rem 1rem;
        background: linear-gradient(to bottom right, #171717, #000);
        border: 1px solid #404040;
        border-radius: 0.5rem;
        color: #a3a3a3;
        transition: all 0.2s;
    }
    .pagination > *.active {
        background: linear-gradient(to right, #D4AF37, #eab308);
        border-color: #D4AF37;
        color: #000;
        font-weight: bold;
    }
    .pagination > *:hover:not(.active) {
        background: #262626;
        border-color: #D4AF37;
        color: #D4AF37;
    }
</style>
@endsection