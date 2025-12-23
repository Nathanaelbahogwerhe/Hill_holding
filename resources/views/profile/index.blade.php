@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="px-6 py-6">
    <!-- Header avec gradient -->
    <div class="mb-8">
        <h2 class="text-5xl font-bold mb-2 bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">
            👤 Mon Profil
        </h2>
        <p class="text-neutral-400">Gérez vos informations personnelles et vos paramètres</p>
    </div>

    @if(session('success'))
        <div class="px-6 py-4 mb-6 bg-gradient-to-r from-green-900/50 to-green-800/30 border border-green-500 text-green-200 rounded-xl flex items-center gap-3 animate-fadeIn">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Carte Avatar et Informations Principales -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl">
                <!-- Avatar -->
                <div class="flex flex-col items-center mb-6">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-r from-[#D4AF37] to-yellow-500 flex items-center justify-center text-6xl font-bold text-black shadow-2xl mb-4 border-4 border-neutral-800">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-1">{{ $user->name }}</h3>
                    <p class="text-neutral-400 text-sm">{{ $user->email }}</p>
                </div>

                <!-- Informations Rôles -->
                @if($user->roles->count() > 0)
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-[#D4AF37] mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Rôles & Permissions
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($user->roles as $role)
                                <span class="px-3 py-1 rounded-xl bg-gradient-to-r from-purple-600/30 to-purple-700/30 border border-purple-500/50 text-purple-300 text-xs font-semibold">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Statistiques Rapides -->
                <div class="border-t border-neutral-800 pt-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-neutral-400">Membre depuis</span>
                            <span class="text-white font-semibold">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-neutral-400">Dernière connexion</span>
                            <span class="text-white font-semibold">{{ $user->updated_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations Détaillées -->
        <div class="lg:col-span-2">
            <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl">
                <h3 class="text-2xl font-bold text-[#D4AF37] mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informations du Compte
                </h3>

                <div class="space-y-4">
                    <!-- Nom -->
                    <div class="bg-neutral-800/50 rounded-xl p-4 border border-neutral-700 hover:border-[#D4AF37]/30 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-r from-[#D4AF37] to-yellow-500 rounded-xl">
                                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-neutral-400 mb-1">Nom complet</div>
                                    <div class="text-white font-semibold text-lg">{{ $user->name }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="bg-neutral-800/50 rounded-xl p-4 border border-neutral-700 hover:border-[#D4AF37]/30 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-neutral-400 mb-1">Adresse email</div>
                                    <div class="text-white font-semibold text-lg">{{ $user->email }}</div>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-xl bg-gradient-to-r from-green-500/20 to-green-600/20 border border-green-500/50 text-green-400 text-xs font-semibold">
                                Vérifié
                            </span>
                        </div>
                    </div>

                    <!-- Filiale -->
                    <div class="bg-neutral-800/50 rounded-xl p-4 border border-neutral-700 hover:border-[#D4AF37]/30 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-xs text-neutral-400 mb-1">Filiale</div>
                                <div class="text-white font-semibold text-lg">
                                    {{ $user->filiale?->name ?? 'Maison Mère' }}
                                </div>
                                @if($user->filiale)
                                    <div class="text-xs text-neutral-500 mt-1">
                                        {{ $user->filiale->location ?? 'Non spécifié' }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Agence (si applicable) -->
                    @if($user->agence)
                        <div class="bg-neutral-800/50 rounded-xl p-4 border border-neutral-700 hover:border-[#D4AF37]/30 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-neutral-400 mb-1">Agence</div>
                                    <div class="text-white font-semibold text-lg">{{ $user->agence->name }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Compte créé -->
                    <div class="bg-neutral-800/50 rounded-xl p-4 border border-neutral-700">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gradient-to-r from-green-500 to-green-600 rounded-xl">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-neutral-400 mb-1">Compte créé le</div>
                                <div class="text-white font-semibold">
                                    {{ $user->created_at->format('d F Y à H:i') }}
                                </div>
                                <div class="text-xs text-neutral-500 mt-1">
                                    Il y a {{ $user->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 pt-6 border-t border-neutral-800">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black font-bold shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Modifier mon profil
                        </a>

                        <form action="{{ route('profile.destroy') }}" method="POST" 
                              onsubmit="return confirm('⚠️ ATTENTION ⚠️\n\nÊtes-vous sûr de vouloir supprimer votre compte ?\n\nCette action est IRRÉVERSIBLE et supprimera:\n- Toutes vos informations personnelles\n- Votre historique d\'activité\n- Tous vos accès\n\nTapez OK pour confirmer la suppression.')"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer mon compte
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Sécurité & Confidentialité -->
    <div class="mt-6 bg-gradient-to-r from-blue-900/30 to-blue-800/20 border border-blue-500/50 rounded-2xl p-6">
        <div class="flex items-start gap-4">
            <div class="p-3 bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/300 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-blue-300 mb-2">🔒 Sécurité & Confidentialité</h3>
                <p class="text-blue-200 mb-3">
                    Votre compte est protégé. Vos informations personnelles sont sécurisées et ne sont jamais partagées avec des tiers.
                </p>
                <ul class="list-disc list-inside text-blue-200 space-y-1 ml-4">
                    <li>Changez régulièrement votre mot de passe</li>
                    <li>Ne partagez jamais vos identifiants</li>
                    <li>Déconnectez-vous après chaque session sur un ordinateur partagé</li>
                </ul>
            </div>
        </div>
    </div>

</div>

<style>
@keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}
</style>
@endsection
