<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HillHolding | Gestion Centralisée</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-black text-gray-200 font-sans">

    <!-- Navbar -->
    <header class="flex justify-between items-center px-10 py-6 border-b border-gray-800">
        <div class="text-2xl font-bold text-yellow-500 tracking-widest">HillHolding</div>
        <nav class="hidden md:flex space-x-8 text-sm uppercase">
            <a href="#" class="hover:text-yellow-500 transition">Accueil</a>
            <a href="#features" class="hover:text-yellow-500 transition">Fonctionnalités</a>
            <a href="#about" class="hover:text-yellow-500 transition">À propos</a>
            <a href="#contact" class="hover:text-yellow-500 transition">Contact</a>
        </nav>
        <div class="space-x-3">
            <a href="/login" class="bg-yellow-600 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg font-semibold">Connexion</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="text-center py-24 px-6 bg-gradient-to-b from-black to-gray-900">
        <h1 class="text-4xl md:text-6xl font-bold text-yellow-500 mb-4">
            Centralisez la gestion de votre entreprise
        </h1>
        <p class="text-lg text-gray-400 max-w-2xl mx-auto mb-8">
            Une solution unique pour superviser toutes vos filiales, vos finances et vos opérations en temps réel.
        </p>
        <div class="space-x-4">
            <a href="#features" class="bg-yellow-600 hover:bg-yellow-500 text-black px-6 py-3 rounded-lg font-semibold">
                Découvrir
            </a>
            <a href="/demo" class="border border-yellow-600 hover:bg-yellow-600 hover:text-black px-6 py-3 rounded-lg font-semibold">
                Essayer la démo
            </a>
        </div>
    </section>

    <!-- Fonctionnalités -->
    <section id="features" class="py-20 px-6 bg-black">
        <h2 class="text-3xl text-center font-bold text-yellow-500 mb-12">Fonctionnalités Clés</h2>
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="bg-gray-900 p-8 rounded-2xl shadow-lg hover:scale-105 transition">
                <h3 class="text-xl font-semibold text-yellow-500 mb-3">Gestion Financière</h3>
                <p class="text-gray-400 text-sm">
                    Suivez vos comptes, budgets et flux de trésorerie en temps réel avec des rapports automatisés.
                </p>
            </div>
            <div class="bg-gray-900 p-8 rounded-2xl shadow-lg hover:scale-105 transition">
                <h3 class="text-xl font-semibold text-yellow-500 mb-3">Suivi des Filiales</h3>
                <p class="text-gray-400 text-sm">
                    Supervisez facilement toutes vos filiales depuis un tableau de bord centralisé et intuitif.
                </p>
            </div>
            <div class="bg-gray-900 p-8 rounded-2xl shadow-lg hover:scale-105 transition">
                <h3 class="text-xl font-semibold text-yellow-500 mb-3">Gestion des Ressources</h3>
                <p class="text-gray-400 text-sm">
                    Optimisez la gestion du personnel, des stocks et du matériel avec des modules intégrés.
                </p>
            </div>
        </div>
    </section>

    <!-- À propos -->
    <section id="about" class="py-20 px-6 bg-gradient-to-t from-black to-gray-900">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-yellow-500 mb-6">À propos de HillHolding</h2>
            <p class="text-gray-400 text-lg leading-relaxed">
                HillHolding est une solution technologique de gestion intégrée, conçue pour simplifier
                la prise de décision et offrir une vision claire des performances de votre groupe.
            </p>
        </div>
    </section>

    <!-- Contact -->
    <footer id="contact" class="bg-black border-t border-gray-800 py-10">
        <div class="text-center text-gray-400 text-sm">
            <p>© {{ date('Y') }} HillHolding. Tous droits réservés.</p>
            <p class="mt-2">Contact : <a href="mailto:hillholdingcompany@hillhold.bi" class="text-yellow-500 hover:underline">hillholdingcompany@hillhold.bi</a></p>
        </div>