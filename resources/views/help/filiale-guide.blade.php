@extends('layouts.app')

@section('title', 'Guide - Créer une Filiale')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37] mb-2">🎯 Guide Pratique : Créer une Filiale et y Accéder</h1>
        <p class="text-neutral-400">Suivez ces étapes pour créer une filiale et configurer un utilisateur qui y aura accès</p>
    </div>

    <!-- Étape 1 -->
    <div class="bg-gradient-to-r from-blue-600/20 to-transparent border-l-4 border-blue-500 rounded-lg p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-2xl font-bold text-white">1</div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-blue-400 mb-3">Créer la Filiale</h2>
                
                <div class="space-y-4">
                    <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                        <h3 class="text-lg font-semibold text-white mb-2">📍 Navigation</h3>
                        <p class="text-neutral-300 mb-2">Depuis le dashboard, cliquez sur :</p>
                        <div class="bg-[#D4AF37]/20 border border-[#D4AF37] rounded-lg p-3 inline-flex items-center gap-2">
                            <span class="text-2xl">🏭</span>
                            <span class="font-bold text-white">Nouvelle Filiale</span>
                        </div>
                        <p class="text-sm text-neutral-400 mt-2">Ou allez dans : <strong>RH → Filiales → + Créer</strong></p>
                    </div>

                    <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                        <h3 class="text-lg font-semibold text-white mb-2">✍️ Informations à remplir</h3>
                        <ul class="space-y-2 text-neutral-300">
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] font-bold">•</span>
                                <div>
                                    <strong class="text-white">Nom de la filiale</strong> <span class="text-red-500">*</span>
                                    <p class="text-sm text-neutral-400">Ex: "Hill Holding Côte d'Ivoire"</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] font-bold">•</span>
                                <div>
                                    <strong class="text-white">Code</strong> (optionnel)
                                    <p class="text-sm text-neutral-400">Ex: "HHCI" ou "FIL-001"</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] font-bold">•</span>
                                <div>
                                    <strong class="text-white">Localisation</strong>
                                    <p class="text-sm text-neutral-400">Ex: "Abidjan, Côte d'Ivoire"</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] font-bold">•</span>
                                <div>
                                    <strong class="text-white">Logo</strong> (optionnel)
                                    <p class="text-sm text-neutral-400">Image PNG ou JPG, max 2MB</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-green-900/20 border border-green-600 p-4 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <strong class="text-green-400">Exemple complet :</strong>
                        </div>
                        <div class="bg-black/50 p-3 rounded border border-green-800">
                            <p class="text-neutral-300"><strong>Nom :</strong> Hill Holding Côte d'Ivoire</p>
                            <p class="text-neutral-300"><strong>Code :</strong> HHCI</p>
                            <p class="text-neutral-300"><strong>Localisation :</strong> Plateau, Abidjan</p>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <a href="{{ route('filiales.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded-lg font-bold transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Créer ma filiale maintenant
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Étape 2 -->
    <div class="bg-gradient-to-r from-purple-600/20 to-transparent border-l-4 border-purple-500 rounded-lg p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-2xl font-bold text-white">2</div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-purple-400 mb-3">Créer un Utilisateur pour cette Filiale</h2>
                
                <div class="space-y-4">
                    <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                        <h3 class="text-lg font-semibold text-white mb-2">📍 Navigation</h3>
                        <p class="text-neutral-300 mb-2">Depuis le dashboard, cliquez sur :</p>
                        <div class="bg-[#D4AF37]/20 border border-[#D4AF37] rounded-lg p-3 inline-flex items-center gap-2">
                            <span class="text-2xl">👤</span>
                            <span class="font-bold text-white">Nouvel Utilisateur</span>
                        </div>
                        <p class="text-sm text-neutral-400 mt-2">Ou allez dans : <strong>RH → Utilisateurs → + Créer</strong></p>
                    </div>

                    <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                        <h3 class="text-lg font-semibold text-white mb-2">✍️ Informations de l'utilisateur</h3>
                        <ul class="space-y-2 text-neutral-300">
                            <li class="flex items-start gap-2">
                                <span class="text-purple-400 font-bold">•</span>
                                <div>
                                    <strong class="text-white">Nom complet</strong> <span class="text-red-500">*</span>
                                    <p class="text-sm text-neutral-400">Ex: "Marie Kouassi"</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-purple-400 font-bold">•</span>
                                <div>
                                    <strong class="text-white">Email</strong> <span class="text-red-500">*</span>
                                    <p class="text-sm text-neutral-400">Ex: "marie.kouassi@hillholding-ci.com"</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-purple-400 font-bold">•</span>
                                <div>
                                    <strong class="text-white">Mot de passe</strong> <span class="text-red-500">*</span>
                                    <p class="text-sm text-neutral-400">Minimum 6 caractères</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-amber-900/20 border border-amber-600 p-4 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <strong class="text-amber-400">IMPORTANT - Sélectionner la Filiale :</strong>
                        </div>
                        <p class="text-amber-200 mb-3">Dans la section "Informations de base", dans le champ <strong>Filiale</strong> :</p>
                        <div class="bg-black/50 p-3 rounded border border-amber-800">
                            <p class="text-white font-semibold mb-2">Sélectionnez la filiale que vous venez de créer</p>
                            <p class="text-sm text-amber-200">Ex: Choisir "Hill Holding Côte d'Ivoire" dans la liste déroulante</p>
                            <p class="text-sm text-red-300 mt-2">⚠️ Si vous laissez vide, l'utilisateur appartiendra à la maison mère</p>
                        </div>
                    </div>

                    <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                        <h3 class="text-lg font-semibold text-white mb-2">🎭 Attribuer des Rôles</h3>
                        <p class="text-neutral-300 mb-3">Cochez au moins un rôle pour définir les permissions :</p>
                        <div class="space-y-2">
                            <div class="bg-blue-900/20 border border-blue-700 p-3 rounded">
                                <strong class="text-blue-400">👥 RH Manager</strong>
                                <p class="text-sm text-blue-200">Recommandé pour un responsable de filiale</p>
                            </div>
                            <div class="bg-purple-900/20 border border-purple-700 p-3 rounded">
                                <strong class="text-purple-400">🔧 Operations Manager</strong>
                                <p class="text-sm text-purple-200">Pour la gestion opérationnelle</p>
                            </div>
                            <div class="bg-gray-800/20 border border-gray-700 p-3 rounded">
                                <strong class="text-gray-400">👤 Employee</strong>
                                <p class="text-sm text-gray-300">Pour un employé standard</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded-lg font-bold transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Créer l'utilisateur maintenant
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Étape 3 -->
    <div class="bg-gradient-to-r from-green-600/20 to-transparent border-l-4 border-green-500 rounded-lg p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-2xl font-bold text-white">3</div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-green-400 mb-3">Se Connecter en tant qu'Utilisateur de la Filiale</h2>
                
                <div class="space-y-4">
                    <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                        <h3 class="text-lg font-semibold text-white mb-2">🔐 Connexion</h3>
                        <ol class="list-decimal list-inside space-y-2 text-neutral-300 ml-4">
                            <li><strong>Déconnectez-vous</strong> de votre compte actuel (bouton Déconnexion en haut à droite)</li>
                            <li><strong>Reconnectez-vous</strong> avec les identifiants du nouvel utilisateur :
                                <div class="bg-black/50 p-3 rounded border border-neutral-800 mt-2">
                                    <p class="text-white">Email : <code class="text-[#D4AF37]">marie.kouassi@hillholding-ci.com</code></p>
                                    <p class="text-white">Mot de passe : <code class="text-[#D4AF37]">[le mot de passe défini]</code></p>
                                </div>
                            </li>
                        </ol>
                    </div>

                    <div class="bg-green-900/20 border border-green-600 p-4 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <strong class="text-green-400">Après connexion, vous verrez :</strong>
                        </div>
                        <ul class="space-y-2 text-green-200 ml-6">
                            <li class="flex items-start gap-2">
                                <span>✓</span>
                                <span>Un indicateur bleu en haut du dashboard : <strong>"📍 Périmètre : [Nom de votre filiale]"</strong></span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span>✓</span>
                                <span>Les statistiques afficheront <strong>uniquement les données de votre filiale</strong></span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span>✓</span>
                                <span>La liste des employés montrera <strong>uniquement ceux de votre filiale</strong></span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span>✓</span>
                                <span>Vous ne verrez <strong>pas les données des autres filiales</strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vérification -->
    <div class="bg-gradient-to-r from-[#D4AF37]/20 to-transparent border-l-4 border-[#D4AF37] rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-4">✅ Comment vérifier que ça fonctionne ?</h2>
        
        <div class="space-y-3">
            <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                <h3 class="text-white font-semibold mb-2">1. Vérifier l'indicateur de périmètre</h3>
                <p class="text-neutral-300">En haut du dashboard, vous devez voir une bannière bleue avec :</p>
                <div class="bg-blue-600/20 border border-blue-500 p-3 rounded mt-2">
                    <p class="text-blue-300">📍 Périmètre : Hill Holding Côte d'Ivoire</p>
                    <p class="text-sm text-neutral-400">Vous consultez les données de votre filiale uniquement</p>
                </div>
            </div>

            <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                <h3 class="text-white font-semibold mb-2">2. Vérifier les statistiques</h3>
                <p class="text-neutral-300">Les compteurs doivent afficher uniquement les données de votre filiale, pas du groupe entier</p>
            </div>

            <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                <h3 class="text-white font-semibold mb-2">3. Vérifier la liste des employés</h3>
                <p class="text-neutral-300">Allez dans <strong>RH → Employés</strong>. Vous ne devez voir que les employés de votre filiale</p>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="bg-neutral-900 rounded-lg p-6 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-4">❓ Questions Fréquentes</h2>
        
        <div class="space-y-4">
            <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                <h3 class="text-white font-semibold mb-2">Q: Je ne vois pas ma filiale dans la liste ?</h3>
                <p class="text-neutral-300">R: Assurez-vous de créer la filiale <strong>avant</strong> de créer l'utilisateur. Rafraîchissez la page si nécessaire.</p>
            </div>

            <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                <h3 class="text-white font-semibold mb-2">Q: L'utilisateur voit toutes les données du groupe ?</h3>
                <p class="text-neutral-300">R: Vérifiez que vous avez bien <strong>sélectionné la filiale</strong> lors de la création de l'utilisateur. Si oublié, modifiez l'utilisateur pour assigner la filiale.</p>
            </div>

            <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                <h3 class="text-white font-semibold mb-2">Q: Comment donner accès à plusieurs filiales ?</h3>
                <p class="text-neutral-300">R: Actuellement, un utilisateur est lié à une seule filiale. Pour accéder à plusieurs filiales, créez des comptes séparés ou utilisez le compte Super Admin.</p>
            </div>

            <div class="bg-black/50 p-4 rounded-lg border border-neutral-700">
                <h3 class="text-white font-semibold mb-2">Q: Comment revenir à la vue complète ?</h3>
                <p class="text-neutral-300">R: Connectez-vous avec un compte <strong>Super Admin</strong>. Les Super Admins voient toutes les données de toutes les filiales.</p>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="text-center space-y-4">
        <div class="flex justify-center gap-4">
            <a href="{{ route('filiales.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded-lg font-bold transition">
                <span class="text-xl">🏭</span>
                Créer une Filiale
            </a>
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold transition">
                <span class="text-xl">👤</span>
                Créer un Utilisateur
            </a>
        </div>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg font-bold transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour au Dashboard
        </a>
    </div>
</div>
@endsection
