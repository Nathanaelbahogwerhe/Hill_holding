@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="px-6 py-6">

    <!-- Header avec gradient doré -->
    <div class="mb-8">
        <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] mb-2 tracking-wide animate-gradient">
            🧭 Tableau de Bord
        </h2>
        <p class="text-lg text-neutral-400">Vue globale de votre organisation Hill Holding</p>
    </div>

    <!-- Indicateur de Filiale/Périmètre avec design moderne -->
    @if(auth()->user()->filiale_id)
    <div class="mb-8 bg-gradient-to-br from-blue-600/20 via-blue-500/10 to-transparent border border-blue-500/50 rounded-2xl p-6 shadow-[0_0_30px_rgba(59,130,246,0.2)]">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-500/20 rounded-2xl flex items-center justify-center">
                <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-2xl font-bold text-blue-400 mb-1">📍 Périmètre : {{ auth()->user()->filiale->name ?? 'Filiale' }}</h3>
                <p class="text-neutral-400">Vous consultez les données de votre filiale uniquement</p>
            </div>
        </div>
    </div>
    @elseif(auth()->user()->hasRole('Super Admin'))
    <div class="mb-8 bg-gradient-to-br from-red-600/20 via-red-500/10 to-transparent border border-red-500/50 rounded-2xl p-6 shadow-[0_0_30px_rgba(239,68,68,0.2)]">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-red-500/20 rounded-2xl flex items-center justify-center">
                <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-2xl font-bold text-red-400 mb-1">👑 Mode Super Admin</h3>
                <p class="text-neutral-400">Vous avez accès à toutes les données du groupe Hill Holding</p>
            </div>
        </div>
    </div>
    @else
    <div class="mb-8 bg-gradient-to-br from-[#D4AF37]/20 via-yellow-500/10 to-transparent border border-[#D4AF37]/50 rounded-2xl p-6 shadow-[0_0_30px_rgba(212,175,55,0.2)]">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-[#D4AF37]/20 rounded-2xl flex items-center justify-center">
                <svg class="w-10 h-10 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-2xl font-bold text-[#D4AF37] mb-1">🏢 Périmètre : Maison Mère</h3>
                <p class="text-neutral-400">Vous consultez les données de la maison mère Hill Holding</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Statut de chargement moderne -->
    <div id="status" class="mb-6 flex items-center gap-3 text-neutral-400 bg-neutral-900/50 border border-neutral-800 rounded-xl p-4">
        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        <span>Chargement des statistiques...</span>
    </div>

    <!-- RACCOURCIS ADMIN (RH Manager / Super Admin) -->
    @canany(['Super Admin', 'RH Manager'])
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-[#D4AF37] to-yellow-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h3 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#D4AF37] to-yellow-500">
                Raccourcis Administration
            </h3>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Créer Utilisateur -->
            <a href="{{ route('users.create') }}" class="group p-6 rounded-xl border-2 border-[#D4AF37]/30 bg-gradient-to-br from-neutral-900 to-black hover:from-[#D4AF37]/10 hover:to-neutral-900 hover:border-[#D4AF37] transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(212,175,55,0.3)]">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">👤</div>
                <h4 class="text-lg font-bold text-white mb-1">Nouvel Utilisateur</h4>
                <p class="text-sm text-neutral-400">Créer un compte avec rôles</p>
            </a>

            <!-- Créer Filiale -->
            <a href="{{ route('filiales.create') }}" class="group p-6 rounded-xl border-2 border-[#D4AF37]/30 bg-gradient-to-br from-neutral-900 to-black hover:from-[#D4AF37]/10 hover:to-neutral-900 hover:border-[#D4AF37] transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(212,175,55,0.3)]">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🏭</div>
                <h4 class="text-lg font-bold text-white mb-1">Nouvelle Filiale</h4>
                <p class="text-sm text-neutral-400">Ajouter une filiale au groupe</p>
            </a>

            <!-- Créer Agence -->
            <a href="{{ route('agences.create') }}" class="group p-6 rounded-xl border-2 border-[#D4AF37]/30 bg-gradient-to-br from-neutral-900 to-black hover:from-[#D4AF37]/10 hover:to-neutral-900 hover:border-[#D4AF37] transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(212,175,55,0.3)]">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">📍</div>
                <h4 class="text-lg font-bold text-white mb-1">Nouvelle Agence</h4>
                <p class="text-sm text-neutral-400">Créer une agence locale</p>
            </a>

            <!-- Créer Employé -->
            <a href="{{ route('employees.create') }}" class="group p-6 rounded-xl border-2 border-[#D4AF37]/30 bg-gradient-to-br from-neutral-900 to-black hover:from-[#D4AF37]/10 hover:to-neutral-900 hover:border-[#D4AF37] transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(212,175,55,0.3)]">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">👥</div>
                <h4 class="text-lg font-bold text-white mb-1">Nouvel Employé</h4>
                <p class="text-sm text-neutral-400">Ajouter un collaborateur</p>
            </a>

            <!-- Voir Utilisateurs -->
            <a href="{{ route('users.index') }}" class="group p-6 rounded-xl border-2 border-neutral-700 bg-gradient-to-br from-neutral-900 to-black hover:from-neutral-800 hover:to-neutral-900 hover:border-neutral-500 transition-all duration-300 hover:scale-105">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">📋</div>
                <h4 class="text-lg font-bold text-white mb-1">Gérer Utilisateurs</h4>
                <p class="text-sm text-neutral-400">Liste et permissions</p>
            </a>

            <!-- Voir Filiales -->
            <a href="{{ route('filiales.index') }}" class="group p-6 rounded-xl border-2 border-neutral-700 bg-gradient-to-br from-neutral-900 to-black hover:from-neutral-800 hover:to-neutral-900 hover:border-neutral-500 transition-all duration-300 hover:scale-105">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🏢</div>
                <h4 class="text-lg font-bold text-white mb-1">Gérer Filiales</h4>
                <p class="text-sm text-neutral-400">Structure organisationnelle</p>
            </a>

            <!-- Voir Agences -->
            <a href="{{ route('agences.index') }}" class="group p-6 rounded-xl border-2 border-neutral-700 bg-gradient-to-br from-neutral-900 to-black hover:from-neutral-800 hover:to-neutral-900 hover:border-neutral-500 transition-all duration-300 hover:scale-105">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🗺️</div>
                <h4 class="text-lg font-bold text-white mb-1">Gérer Agences</h4>
                <p class="text-sm text-neutral-400">Points de présence</p>
            </a>

            @role('Super Admin')
            <!-- Administration Avancée -->
            <a href="{{ route('admin.dashboard') }}" class="group p-6 rounded-xl border-2 border-red-600/30 bg-gradient-to-br from-red-950 to-black hover:from-red-900 hover:to-red-950 hover:border-red-600 transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(220,38,38,0.3)]">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">⚙️</div>
                <h4 class="text-lg font-bold text-white mb-1">Admin Système</h4>
                <p class="text-sm text-red-300">Rôles & Permissions</p>
            </a>
            @endrole
        </div>

        <!-- Liens vers les guides -->
        <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('help.filiale-guide') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-600 text-white rounded-lg font-bold transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(37,99,235,0.5)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                🎯 Guide : Créer une Filiale et y Accéder
            </a>
            <a href="{{ route('help.admin-guide') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-600 hover:from-yellow-600 hover:to-[#D4AF37] text-black rounded-lg font-bold transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(212,175,55,0.5)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                📚 Guide Complet d'Administration
            </a>
        </div>
    </div>
    @endcanany

    <!-- CARDS STATISTIQUES avec design moderne -->
    <div id="stats-cards" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-10">
        <!-- Injecté par JavaScript -->
    </div>

    <!-- GRAPHIQUES avec design amélioré -->
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h3 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600">
                Analytiques
            </h3>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:shadow-[0_0_40px_rgba(212,175,55,0.15)] transition-all duration-300">
                <h4 class="text-lg font-bold text-neutral-300 mb-4 flex items-center gap-2">
                    <span class="text-2xl">📊</span>
                    Projets vs Tâches
                </h4>
                <canvas id="projectsTasksChart" class="w-full h-64"></canvas>
            </div>

            <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:shadow-[0_0_40px_rgba(212,175,55,0.15)] transition-all duration-300">
                <h4 class="text-lg font-bold text-neutral-300 mb-4 flex items-center gap-2">
                    <span class="text-2xl">👥</span>
                    Répartition RH
                </h4>
                <canvas id="employeesChart" class="w-full h-64"></canvas>
            </div>
        </div>
    </div>

    <!-- KPIs avec design moderne -->
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <h3 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-purple-600">
                Indicateurs de Performance
            </h3>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl">
                <h4 class="text-lg font-bold text-neutral-300 mb-4 flex items-center gap-2">
                    <span class="text-2xl">📈</span>
                    Congés Utilisateurs
                </h4>
                <div id="leaves-progress" class="space-y-4"></div>
            </div>

            <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl">
                <h4 class="text-lg font-bold text-neutral-300 mb-4 flex items-center gap-2">
                    <span class="text-2xl">🛠️</span>
                    Projets — Progression
                </h4>
                <div id="projects-progress" class="space-y-4"></div>
            </div>
        </div>
    </div>

    <!-- DERNIÈRES ACTIONS avec design moderne -->
    <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-neutral-300">Dernières actions</h3>
        </div>
        <ul id="latest-actions" class="space-y-2 text-neutral-400 pl-4">
            <li class="flex items-center gap-2">
                <span class="w-2 h-2 bg-neutral-600 rounded-full animate-pulse"></span>
                <span>Chargement…</span>
            </li>
        </ul>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const status = document.getElementById('status');
    const statsContainer = document.getElementById('stats-cards');
    const latestActions = document.getElementById('latest-actions');
    const leavesProgress = document.getElementById('leaves-progress');
    const projectsProgress = document.getElementById('projects-progress');

    async function loadDashboard() {
        status.textContent = "⏳ Mise Àjour en cours...";

        try {
            const response = await fetch("{{ route('dashboard.data') }}");
            if (!response.ok) throw new Error("Erreur réseau");
            const data = await response.json();

            // CARDS
            const cards = [
                {title: 'Employés', value: data.employees, icon: '👥'},
                {title: 'Départements', value: data.departments, icon: '🏢'},
                {title: 'Filiales', value: data.filiales, icon: '🏭'},
                {title: 'Agences', value: data.agences, icon: '📍'},
                {title: 'Utilisateurs', value: data.users, icon: '👤'},
                {title: 'Clients', value: data.clients, icon: '🤝'},
                {title: 'Projets', value: data.projects, icon: '📁'},
                {title: 'Tâches', value: data.tasks, icon: '📝'},
                {title: 'Notes', value: data.notes, icon: '🗒️'},
            ];

            statsContainer.innerHTML = cards.map((card, index) => `
                <div class="group relative bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 
                            shadow-xl hover:shadow-[0_0_40px_rgba(212,175,55,0.25)] 
                            transition-all duration-500 hover:scale-105 hover:border-[#D4AF37]/50
                            animate-fadeIn" style="animation-delay: ${index * 0.1}s">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-4xl group-hover:scale-110 transition-transform duration-300">${card.icon}</div>
                        <div class="w-12 h-12 bg-[#D4AF37]/10 rounded-xl flex items-center justify-center group-hover:bg-[#D4AF37]/20 transition-colors">
                            <svg class="w-6 h-6 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-sm font-semibold text-neutral-400 tracking-wide mb-2">
                        ${card.title}
                    </div>
                    <div class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#D4AF37] to-yellow-500">
                        ${card.value}
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#D4AF37] to-yellow-500 rounded-b-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
            `).join('');

            // GRAPHIQUES avec couleurs modernes
            new Chart(document.getElementById('projectsTasksChart'), {
                type: 'bar',
                data: {
                    labels: ['Projets', 'Tâches'],
                    datasets: [{
                        data: [data.projects, data.tasks],
                        backgroundColor: [
                            'rgba(212, 175, 55, 0.8)',
                            'rgba(234, 179, 8, 0.8)'
                        ],
                        borderColor: [
                            'rgb(212, 175, 55)',
                            'rgb(234, 179, 8)'
                        ],
                        borderWidth: 2,
                        borderRadius: 12,
                    }]
                },
                options: { 
                    plugins: { legend: { display: false }},
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: { color: '#9CA3AF' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9CA3AF' }
                        }
                    }
                }
            });

            new Chart(document.getElementById('employeesChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Employés', 'Clients', 'Utilisateurs'],
                    datasets: [{
                        data: [data.employees, data.clients, data.users],
                        backgroundColor: [
                            'rgba(212, 175, 55, 0.8)',
                            'rgba(234, 179, 8, 0.8)',
                            'rgba(250, 204, 21, 0.8)'
                        ],
                        borderColor: [
                            'rgb(212, 175, 55)',
                            'rgb(234, 179, 8)',
                            'rgb(250, 204, 21)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: { 
                    plugins: { 
                        legend: { 
                            position: 'bottom',
                            labels: { color: '#9CA3AF', padding: 15 }
                        }
                    }
                }
            });

            // PROGRESS BARS avec design moderne
            leavesProgress.innerHTML = (data.leaves || []).map(l => `
                <div class="group">
                    <div class="flex justify-between text-neutral-300 text-sm mb-2">
                        <span class="font-semibold">${l.title}</span>
                        <span class="text-[#D4AF37] font-bold">${l.value}%</span>
                    </div>
                    <div class="w-full bg-neutral-800 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#D4AF37] to-yellow-500 h-3 rounded-full transition-all duration-1000 ease-out shadow-[0_0_10px_rgba(212,175,55,0.5)]" 
                             style="width:0%"
                             data-width="${l.value}%"></div>
                    </div>
                </div>
            `).join('');

            projectsProgress.innerHTML = (data.projects_progress || []).map(p => `
                <div class="group">
                    <div class="flex justify-between text-neutral-300 text-sm mb-2">
                        <span class="font-semibold">${p.title}</span>
                        <span class="text-[#D4AF37] font-bold">${p.value}%</span>
                    </div>
                    <div class="w-full bg-neutral-800 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-1000 ease-out shadow-[0_0_10px_rgba(59,130,246,0.5)]" 
                             style="width:0%"
                             data-width="${p.value}%"></div>
                    </div>
                </div>
            `).join('');

            // Animer les barres de progression
            setTimeout(() => {
                document.querySelectorAll('[data-width]').forEach(bar => {
                    bar.style.width = bar.getAttribute('data-width');
                });
            }, 100);

            // ACTIONS avec design moderne
            latestActions.innerHTML = (data.latest_actions || [])
                .map(a => `
                    <li class="flex items-start gap-3 p-3 rounded-lg hover:bg-neutral-800/50 transition-colors">
                        <span class="w-2 h-2 bg-[#D4AF37] rounded-full mt-2 flex-shrink-0"></span>
                        <span class="text-neutral-300">${a}</span>
                    </li>
                `)
                .join('') || '<li class="flex items-center gap-2 text-neutral-500"><span class="w-2 h-2 bg-neutral-600 rounded-full"></span>Aucune action récente</li>';

            // Mettre à jour le statut
            const statusEl = document.getElementById('status');
            statusEl.innerHTML = `
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-green-400">Données chargées avec succès</span>
                <span class="text-neutral-500 ml-auto">${new Date().toLocaleTimeString()}</span>
            `;
            statusEl.className = "mb-6 flex items-center gap-3 text-neutral-400 bg-green-900/10 border border-green-900/50 rounded-xl p-4";

        } catch (error) {
            const statusEl = document.getElementById('status');
            statusEl.innerHTML = `
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-red-400">Erreur de chargement des données</span>
                <button onclick="location.reload()" class="ml-auto px-4 py-1 bg-red-900/30 hover:bg-red-900/50 text-red-400 rounded-lg text-sm transition">
                    Réessayer
                </button>
            `;
            statusEl.className = "mb-6 flex items-center gap-3 text-neutral-400 bg-red-900/10 border border-red-900/50 rounded-xl p-4";
        }
    }

    loadDashboard();
    setInterval(loadDashboard, 60000); // Refresh toutes les 60 secondes
});
</script>

<style>
/* Animations personnalisées */
@keyframes fadeIn {
    from { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

@keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.animate-fadeIn { 
    animation: fadeIn 0.6s ease-out forwards;
    opacity: 0;
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

/* Scrollbar personnalisée */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #171717;
}

::-webkit-scrollbar-thumb {
    background: #D4AF37;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #eab308;
}
</style>
@endsection
