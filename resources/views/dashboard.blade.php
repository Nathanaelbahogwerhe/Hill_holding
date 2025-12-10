@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="px-6 py-6">

    <h2 class="text-4xl font-extrabold text-hh-light mb-6 tracking-wide drop-shadow-md">
        🧭 Tableau de Bord — Vue Globale
    </h2>

    <div id="status" class="text-sm text-hh-light/70 mb-4 italic">
        Chargement des statistiques...
    </div>

    <!-- CARDS STATISTIQUES -->
    <div id="stats-cards" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        <!-- Cartes injectées par JS -->
    </div>

    <!-- GRAPHIQUES -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-hh-card/80 backdrop-blur-xl border border-hh-gold/40 rounded-2xl p-5 shadow-[0_0_20px_rgba(212,175,55,0.15)]">
            <h3 class="text-hh-light/70 font-semibold mb-3">📊 Projets vs Tâches</h3>
            <canvas id="projectsTasksChart" class="w-full h-64"></canvas>
        </div>

        <div class="bg-hh-card/80 backdrop-blur-xl border border-hh-gold/40 rounded-2xl p-5 shadow-[0_0_20px_rgba(212,175,55,0.15)]">
            <h3 class="text-hh-light/70 font-semibold mb-3">👥 Répartition RH</h3>
            <canvas id="employeesChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <!-- PROGRESS BARS KPI -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-hh-card/80 backdrop-blur-xl border border-hh-gold/40 rounded-2xl p-5 shadow-[0_0_20px_rgba(212,175,55,0.15)]">
            <h3 class="text-hh-light/70 font-semibold mb-3">📈 Congés Utilisateurs</h3>
            <div class="space-y-3" id="leaves-progress"></div>
        </div>

        <div class="bg-hh-card/80 backdrop-blur-xl border border-hh-gold/40 rounded-2xl p-5 shadow-[0_0_20px_rgba(212,175,55,0.15)]">
            <h3 class="text-hh-light/70 font-semibold mb-3">💼 Projets Progression</h3>
            <div class="space-y-3" id="projects-progress"></div>
        </div>
    </div>

    <!-- DERNIÈRES ACTIONS -->
    <div class="bg-hh-card/80 backdrop-blur-xl border border-hh-gold/40 rounded-2xl p-5 shadow-[0_0_20px_rgba(212,175,55,0.15)]">
        <h3 class="text-hh-light/70 font-semibold mb-4">🕒 Dernières actions</h3>
        <ul id="latest-actions" class="space-y-2 text-hh-light/70">
            <li>Chargement…</li>
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
        status.textContent = "⏳ Mise à jour en cours...";

        try {
            const response = await fetch("{{ route('dashboard.data') }}");
            if (!response.ok) throw new Error("Erreur réseau");
            const data = await response.json();

            // --- CARDS STATISTIQUES ---
            const cards = [
                {title: 'Employés', value: data.employees, icon: '👥'},
                {title: 'Départements', value: data.departments, icon: '🏢'},
                {title: 'Filiales', value: data.filiales, icon: '🏭'},
                {title: 'Agences', value: data.agences, icon: '📍'},
                {title: 'Utilisateurs', value: data.users, icon: '🧑‍💻'},
                {title: 'Clients', value: data.clients, icon: '🤝'},
                {title: 'Projets', value: data.projects, icon: '📁'},
                {title: 'Tâches', value: data.tasks, icon: '📝'},
                {title: 'Notes', value: data.notes, icon: '📒'},
            ];

            statsContainer.innerHTML = cards.map(card => `
                <div class="p-6 rounded-2xl border border-hh-gold/40 bg-hh-card/80 
                            backdrop-blur-xl shadow-[0_0_20px_rgba(212,175,55,0.15)]
                            transition transform hover:scale-105 hover:shadow-[0_0_35px_rgba(212,175,55,0.35)]
                            animate-fadeIn">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-lg font-semibold text-hh-light/70 tracking-wide">
                            ${card.icon} ${card.title}
                        </div>
                    </div>
                    <div class="text-5xl font-extrabold text-hh-light drop-shadow-lg">
                        ${card.value}
                    </div>
                </div>
            `).join('');

            // --- GRAPH: Projets vs Tâches ---
            new Chart(document.getElementById('projectsTasksChart'), {
                type: 'bar',
                data: {
                    labels: ['Projets', 'Tâches'],
                    datasets: [{
                        label: 'Nombre',
                        data: [data.projects, data.tasks],
                        backgroundColor: ['#d4af37', '#bfa32a'],
                        borderRadius: 10,
                    }]
                },
                options: { responsive: true }
            });

            // --- GRAPH: RH ---
            new Chart(document.getElementById('employeesChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Employés', 'Clients', 'Utilisateurs'],
                    datasets: [{
                        data: [data.employees, data.clients, data.users],
                        backgroundColor: ['#d4af37', '#bfa32a', '#c9a825'],
                    }]
                },
                options: { responsive: true }
            });

            // --- PROGRESS BARS ---
            leavesProgress.innerHTML = (data.leaves || []).map(l => `
                <div>
                    <div class="flex justify-between text-hh-light/70 text-sm mb-1">${l.title} (${l.value}%)</div>
                    <div class="w-full bg-hh-dark/50 rounded-full h-3">
                        <div class="bg-hh-gold h-3 rounded-full" style="width:${l.value}%"></div>
                    </div>
                </div>
            `).join('');

            projectsProgress.innerHTML = (data.projects_progress || []).map(p => `
                <div>
                    <div class="flex justify-between text-hh-light/70 text-sm mb-1">${p.title} (${p.value}%)</div>
                    <div class="w-full bg-hh-dark/50 rounded-full h-3">
                        <div class="bg-hh-gold h-3 rounded-full" style="width:${p.value}%"></div>
                    </div>
                </div>
            `).join('');

            // --- ACTIONS ---
            latestActions.innerHTML = (data.latest_actions || [])
                .map(a => `<li>• ${a}</li>`)
                .join('') || '<li>Aucune action récente</li>';

            status.textContent = "✓ Dernière mise à jour : " + new Date().toLocaleTimeString();

        } catch (error) {
            console.error(error);
            status.textContent = "⚠️ Erreur de chargement — vérifier connexion.";
        }
    }

    loadDashboard();
    setInterval(loadDashboard, 30000);
});
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn { animation: fadeIn 0.8s ease-out; }
</style>
@endsection
