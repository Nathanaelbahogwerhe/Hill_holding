@extends('layouts.app')

@section('title', 'Guide Administration')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37] mb-2">📚 Guide d'Administration</h1>
        <p class="text-neutral-400">Tout ce que vous devez savoir pour gérer votre système Hill Holding</p>
    </div>

    <!-- Navigation rapide -->
    <div class="bg-neutral-900 rounded-lg p-6 border border-neutral-800 mb-8">
        <h3 class="text-xl font-bold text-[#D4AF37] mb-4">🔗 Navigation Rapide</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="#users" class="p-4 bg-black border border-neutral-700 rounded-lg hover:border-[#D4AF37] transition text-center">
                <div class="text-2xl mb-2">👤</div>
                <div class="text-sm text-white">Utilisateurs</div>
            </a>
            <a href="#filiales" class="p-4 bg-black border border-neutral-700 rounded-lg hover:border-[#D4AF37] transition text-center">
                <div class="text-2xl mb-2">🏭</div>
                <div class="text-sm text-white">Filiales</div>
            </a>
            <a href="#agences" class="p-4 bg-black border border-neutral-700 rounded-lg hover:border-[#D4AF37] transition text-center">
                <div class="text-2xl mb-2">📍</div>
                <div class="text-sm text-white">Agences</div>
            </a>
            <a href="#roles" class="p-4 bg-black border border-neutral-700 rounded-lg hover:border-[#D4AF37] transition text-center">
                <div class="text-2xl mb-2">🎭</div>
                <div class="text-sm text-white">Rôles</div>
            </a>
        </div>
    </div>

    <!-- Section Utilisateurs -->
    <div id="users" class="bg-neutral-900 rounded-lg p-6 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-4 flex items-center gap-2">
            <span>👤</span> Gérer les Utilisateurs
        </h2>

        <div class="space-y-4">
            <div class="bg-black p-4 rounded-lg border border-neutral-700">
                <h3 class="text-lg font-semibold text-white mb-2">✅ Créer un nouvel utilisateur</h3>
                <ol class="list-decimal list-inside space-y-2 text-neutral-300 ml-4">
                    <li>Depuis le <strong>Dashboard</strong>, cliquez sur le bouton <span class="px-2 py-1 bg-[#D4AF37] text-black rounded text-sm">👤 Nouvel Utilisateur</span></li>
                    <li>Remplissez les informations obligatoires:
                        <ul class="list-disc list-inside ml-6 mt-1 space-y-1">
                            <li><strong>Nom complet</strong> de l'utilisateur</li>
                            <li><strong>Email</strong> (servira d'identifiant de connexion)</li>
                            <li><strong>Mot de passe</strong> (minimum 6 caractères)</li>
                            <li><strong>Confirmation du mot de passe</strong></li>
                        </ul>
                    </li>
                    <li>Sélectionnez la <strong>Filiale</strong> (laissez vide pour la maison mère)</li>
                    <li>Cochez les <strong>Rôles</strong> appropriés:
                        <ul class="list-disc list-inside ml-6 mt-1 space-y-1">
                            <li><strong>Super Admin</strong>: Accès complet au système</li>
                            <li><strong>RH Manager</strong>: Gestion RH complète</li>
                            <li><strong>Operations Manager</strong>: Gestion opérationnelle</li>
                            <li><strong>IT Manager</strong>: Gestion IT</li>
                            <li><strong>Employee</strong>: Employé standard</li>
                        </ul>
                    </li>
                    <li>Ajoutez des <strong>Permissions spécifiques</strong> si nécessaire</li>
                    <li>Cliquez sur <span class="px-2 py-1 bg-[#D4AF37] text-black rounded text-sm">✅ Créer l'utilisateur</span></li>
                </ol>
            </div>

            <div class="bg-black p-4 rounded-lg border border-neutral-700">
                <h3 class="text-lg font-semibold text-white mb-2">✏️ Modifier un utilisateur existant</h3>
                <ol class="list-decimal list-inside space-y-2 text-neutral-300 ml-4">
                    <li>Allez dans <strong>RH → Utilisateurs</strong></li>
                    <li>Trouvez l'utilisateur dans la liste</li>
                    <li>Cliquez sur le bouton <span class="px-2 py-1 bg-yellow-600 text-white rounded text-sm">✏️ Éditer</span></li>
                    <li>Modifiez les informations nécessaires</li>
                    <li>Changez les rôles ou permissions si besoin</li>
                    <li>Laissez le mot de passe vide si vous ne voulez pas le changer</li>
                    <li>Cliquez sur <span class="px-2 py-1 bg-[#D4AF37] text-black rounded text-sm">✅ Mettre à jour</span></li>
                </ol>
            </div>

            <div class="bg-amber-900/20 border border-amber-700 p-4 rounded-lg">
                <h4 class="font-semibold text-amber-400 mb-2">💡 Conseils</h4>
                <ul class="list-disc list-inside space-y-1 text-amber-200">
                    <li>Un utilisateur peut avoir plusieurs rôles simultanément</li>
                    <li>Les permissions des rôles sont cumulatives</li>
                    <li>Les permissions directes s'ajoutent aux permissions des rôles</li>
                    <li>Utilisez des emails professionnels comme identifiants</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Section Filiales -->
    <div id="filiales" class="bg-neutral-900 rounded-lg p-6 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-4 flex items-center gap-2">
            <span>🏭</span> Gérer les Filiales
        </h2>

        <div class="space-y-4">
            <div class="bg-black p-4 rounded-lg border border-neutral-700">
                <h3 class="text-lg font-semibold text-white mb-2">✅ Créer une nouvelle filiale</h3>
                <ol class="list-decimal list-inside space-y-2 text-neutral-300 ml-4">
                    <li>Depuis le Dashboard, cliquez sur <span class="px-2 py-1 bg-[#D4AF37] text-black rounded text-sm">🏭 Nouvelle Filiale</span></li>
                    <li>Remplissez les informations:
                        <ul class="list-disc list-inside ml-6 mt-1 space-y-1">
                            <li><strong>Nom de la filiale</strong> (obligatoire, unique)</li>
                            <li><strong>Code</strong> (optionnel, ex: FIL-001)</li>
                            <li><strong>Localisation</strong> (adresse ou ville)</li>
                            <li><strong>Logo</strong> (image, max 2MB)</li>
                        </ul>
                    </li>
                    <li>Sélectionnez <strong>Hill Holding</strong> comme maison mère</li>
                    <li>Cliquez sur <span class="px-2 py-1 bg-[#D4AF37] text-black rounded text-sm">✅ Créer</span></li>
                </ol>
            </div>

            <div class="bg-black p-4 rounded-lg border border-neutral-700">
                <h3 class="text-lg font-semibold text-white mb-2">📊 Consulter les détails d'une filiale</h3>
                <p class="text-neutral-300 mb-2">Allez dans <strong>RH → Filiales</strong>, puis cliquez sur une filiale pour voir:</p>
                <ul class="list-disc list-inside space-y-1 text-neutral-300 ml-4">
                    <li>Informations générales</li>
                    <li>Liste des départements</li>
                    <li>Liste des agences rattachées</li>
                    <li>Nombre d'employés</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Section Agences -->
    <div id="agences" class="bg-neutral-900 rounded-lg p-6 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-4 flex items-center gap-2">
            <span>📍</span> Gérer les Agences
        </h2>

        <div class="space-y-4">
            <div class="bg-black p-4 rounded-lg border border-neutral-700">
                <h3 class="text-lg font-semibold text-white mb-2">✅ Créer une nouvelle agence</h3>
                <ol class="list-decimal list-inside space-y-2 text-neutral-300 ml-4">
                    <li>Depuis le Dashboard, cliquez sur <span class="px-2 py-1 bg-[#D4AF37] text-black rounded text-sm">📍 Nouvelle Agence</span></li>
                    <li>Remplissez les informations:
                        <ul class="list-disc list-inside ml-6 mt-1 space-y-1">
                            <li><strong>Nom de l'agence</strong> (obligatoire, unique)</li>
                            <li><strong>Code</strong> (optionnel, ex: AGN-001)</li>
                            <li><strong>Localisation</strong> (adresse précise)</li>
                            <li><strong>Filiale parente</strong> (obligatoire)</li>
                            <li><strong>Logo</strong> (image, max 2MB)</li>
                        </ul>
                    </li>
                    <li>Cliquez sur <span class="px-2 py-1 bg-[#D4AF37] text-black rounded text-sm">✅ Créer</span></li>
                </ol>
            </div>

            <div class="bg-blue-900/20 border border-blue-700 p-4 rounded-lg">
                <h4 class="font-semibold text-blue-400 mb-2">ℹ️ Structure Hiérarchique</h4>
                <div class="text-blue-200">
                    <p class="mb-2">Hill Holding (Maison Mère)</p>
                    <p class="ml-4 mb-2">└── Filiale 1</p>
                    <p class="ml-8 mb-1">├── Agence 1A</p>
                    <p class="ml-8 mb-1">└── Agence 1B</p>
                    <p class="ml-4 mb-2">└── Filiale 2</p>
                    <p class="ml-8">└── Agence 2A</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Rôles -->
    <div id="roles" class="bg-neutral-900 rounded-lg p-6 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-4 flex items-center gap-2">
            <span>🎭</span> Comprendre les Rôles et Permissions
        </h2>

        <div class="space-y-4">
            <div class="bg-black p-4 rounded-lg border border-neutral-700">
                <h3 class="text-lg font-semibold text-white mb-3">Rôles disponibles</h3>
                
                <div class="space-y-3">
                    <div class="p-3 bg-red-900/20 border border-red-700 rounded">
                        <h4 class="font-semibold text-red-400 mb-1">🔴 Super Admin</h4>
                        <p class="text-sm text-red-200">Accès complet à toutes les fonctionnalités, peut gérer les rôles et permissions</p>
                    </div>

                    <div class="p-3 bg-blue-900/20 border border-blue-700 rounded">
                        <h4 class="font-semibold text-blue-400 mb-1">👥 RH Manager</h4>
                        <p class="text-sm text-blue-200">Gestion complète des employés, contrats, congés, paies, utilisateurs, filiales et agences</p>
                    </div>

                    <div class="p-3 bg-purple-900/20 border border-purple-700 rounded">
                        <h4 class="font-semibold text-purple-400 mb-1">🔧 Operations Manager</h4>
                        <p class="text-sm text-purple-200">Gestion des équipements, véhicules, missions, interventions, maintenances</p>
                    </div>

                    <div class="p-3 bg-green-900/20 border border-green-700 rounded">
                        <h4 class="font-semibold text-green-400 mb-1">💻 IT Manager</h4>
                        <p class="text-sm text-green-200">Gestion du matériel informatique, licences logicielles, interventions IT</p>
                    </div>

                    <div class="p-3 bg-gray-800/20 border border-gray-700 rounded">
                        <h4 class="font-semibold text-gray-400 mb-1">👤 Employee</h4>
                        <p class="text-sm text-gray-300">Accès limité aux fonctionnalités de consultation et de gestion personnelle</p>
                    </div>
                </div>
            </div>

            @role('Super Admin')
            <div class="bg-black p-4 rounded-lg border border-neutral-700">
                <h3 class="text-lg font-semibold text-white mb-2">⚙️ Gérer les rôles (Super Admin uniquement)</h3>
                <ol class="list-decimal list-inside space-y-2 text-neutral-300 ml-4">
                    <li>Allez dans <strong>Administration → Rôles & Permissions</strong></li>
                    <li>Créez de nouveaux rôles selon vos besoins</li>
                    <li>Assignez des permissions spécifiques à chaque rôle</li>
                    <li>Créez des permissions personnalisées si nécessaire</li>
                </ol>
            </div>
            @endrole
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="bg-gradient-to-r from-[#D4AF37]/10 to-transparent rounded-lg p-6 border border-[#D4AF37]/30 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-4">⚡ Actions Rapides</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('users.create') }}" class="flex items-center gap-3 p-4 bg-black rounded-lg border border-neutral-700 hover:border-[#D4AF37] transition">
                <span class="text-3xl">👤</span>
                <div>
                    <div class="font-semibold text-white">Créer un utilisateur</div>
                    <div class="text-sm text-neutral-400">Nouvel accès au système</div>
                </div>
            </a>

            <a href="{{ route('filiales.create') }}" class="flex items-center gap-3 p-4 bg-black rounded-lg border border-neutral-700 hover:border-[#D4AF37] transition">
                <span class="text-3xl">🏭</span>
                <div>
                    <div class="font-semibold text-white">Créer une filiale</div>
                    <div class="text-sm text-neutral-400">Nouvelle entité du groupe</div>
                </div>
            </a>

            <a href="{{ route('agences.create') }}" class="flex items-center gap-3 p-4 bg-black rounded-lg border border-neutral-700 hover:border-[#D4AF37] transition">
                <span class="text-3xl">📍</span>
                <div>
                    <div class="font-semibold text-white">Créer une agence</div>
                    <div class="text-sm text-neutral-400">Nouveau point de présence</div>
                </div>
            </a>

            <a href="{{ route('employees.create') }}" class="flex items-center gap-3 p-4 bg-black rounded-lg border border-neutral-700 hover:border-[#D4AF37] transition">
                <span class="text-3xl">👥</span>
                <div>
                    <div class="font-semibold text-white">Créer un employé</div>
                    <div class="text-sm text-neutral-400">Nouveau collaborateur</div>
                </div>
            </a>
        </div>
    </div>

    <!-- Retour au dashboard -->
    <div class="text-center">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded-lg font-bold transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour au Dashboard
        </a>
    </div>
</div>
@endsection
