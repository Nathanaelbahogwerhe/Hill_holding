<!DOCTYPE html>
<html lang="fr" class="h-full" x-data="{ dark: false }" :class="{ 'dark': dark }">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Hill Holding')</title>

    {{-- CSS et JS Vite --}}
    @vite(['resources/css/app.css', 'resources/css/custom-sidebar.css', 'resources/js/app.js', 'resources/css/hillholding.css'])

    {{-- Hill Holding CSS --}}
    <link rel="stylesheet" href="{{ asset('css/hillholding.css') }}">
    {{-- Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="h-full bg-hh-dark text-hh-light font-sans">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-neutral-900 via-black to-neutral-900 border-r border-neutral-800 flex flex-col shadow-2xl" x-data="{ open: null }">
        <div class="p-6 flex items-center gap-4 border-b border-[#D4AF37]/30 bg-gradient-to-r from-[#D4AF37]/10 to-transparent">
            <!-- Logo -->
            <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gradient-to-br from-[#D4AF37] to-yellow-600 p-1 shadow-2xl shadow-[#D4AF37]/70 hover:shadow-[#D4AF37]/90 transition-all duration-300">
                <div class="w-full h-full rounded-xl overflow-hidden bg-black flex items-center justify-center">
                    <img src="{{ asset('images/hill holding.png') }}" alt="Hill Holding" class="w-full h-full object-cover">
                </div>
            </div>
            <div>
                <div class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#D4AF37] to-yellow-500">Hill Holding</div>
                <div class="text-sm text-neutral-400 font-medium">Gestion Centralisée</div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="p-4 flex-1 overflow-auto">
            <ul class="space-y-1 text-sm">

                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('dashboard') }}" class="sidebar-link">Dashboard</a>
                </li>

                {{-- RH --}}
                @role('Super Admin|RH Manager')
                <li>
                    <button @click="open === 'rh' ? open = null : open = 'rh'" class="sidebar-link justify-between">
                        RH
                        <span x-text="open === 'rh' ? '▲' : '▼'"></span>
                    </button>
                    <ul x-show="open === 'rh'" x-cloak class="mt-2 pl-4 space-y-1">
                        <li><a href="{{ route('employees.index') }}" class="sub-link">Employés</a></li>
                        <li><a href="{{ route('departments.index') }}" class="sub-link">Départements</a></li>
                        <li><a href="{{ route('positions.index') }}" class="sub-link">Postes</a></li>
                        <li><a href="{{ route('filiales.index') }}" class="sub-link">Filiales</a></li>
                        <li><a href="{{ route('agences.index') }}" class="sub-link">Agences</a></li>
                        <li><a href="{{ route('payrolls.index') }}" class="sub-link">Paie</a></li>
                        <li><a href="{{ route('leaves.index') }}" class="sub-link">Congés</a></li>
                        <li><a href="{{ route('attendances.index') }}" class="sub-link">Présences</a></li>
                        <li><a href="{{ route('contracts.index') }}" class="sub-link">Contrats</a></li>
                        <li><a href="{{ route('employee_insurances.index') }}" class="sub-link">Assurances</a></li>
                        <li><a href="{{ route('leave_types.index') }}" class="sub-link">Types de congés</a></li>
                    </ul>
                </li>
                @endrole

                {{-- Finance --}}
                @role('Super Admin|Admin Finance')
                <li>
                    <button @click="open === 'fin' ? open = null : open = 'fin'" class="sidebar-link justify-between">
                        Finance
                        <span x-text="open === 'fin' ? '▲' : '▼'"></span>
                    </button>
                    <ul x-show="open === 'fin'" x-cloak class="mt-2 pl-4 space-y-1">
                        <li><a href="{{ route('transactions.index') }}" class="sub-link">Transactions</a></li>
                        <li><a href="{{ route('expenses.index') }}" class="sub-link">Dépenses</a></li>
                        <li><a href="{{ route('revenues.index') }}" class="sub-link">Revenus</a></li>
                        <li><a href="{{ route('budgets.index') }}" class="sub-link">Budgets</a></li>
                        <li><a href="{{ route('invoices.index') }}" class="sub-link">Factures</a></li>
                        <li><a href="{{ route('finance.reports.index') }}" class="sub-link">Rapports financiers</a></li>
                    </ul>
                </li>
                @endrole

                {{-- Opérations --}}
                @role('Super Admin|Chargé des Opérations|Operations Manager')
                <li>
                    <button @click="open === 'ops' ? open = null : open = 'ops'" class="sidebar-link justify-between">
                        Opérations
                        <span x-text="open === 'ops' ? '▲' : '▼'"></span>
                    </button>
                    <ul x-show="open === 'ops'" x-cloak class="mt-2 pl-4 space-y-1">
                        <li><a href="{{ route('clients.index') }}" class="sub-link">Clients</a></li>
                        <li><a href="{{ route('projects.index') }}" class="sub-link">Projets</a></li>
                        <li><a href="{{ route('tasks.index') }}" class="sub-link">Tâches</a></li>
                        <li><a href="{{ route('client_payments.index') }}" class="sub-link">Paiements clients</a></li>
                        <li><a href="{{ route('contracts_business.index') }}" class="sub-link">Contrats Business</a></li>
                        
                        <!-- Séparateur -->
                        <li class="pt-2 border-t border-neutral-700 mt-2"><strong class="text-xs text-gray-500">SUIVI & RAPPORTS</strong></li>
                        <li><a href="{{ route('activities.index') }}" class="sub-link">Activités</a></li>
                        <li><a href="{{ route('daily_operations.index') }}" class="sub-link">Opérations Journalières</a></li>
                        <li><a href="{{ route('evaluations.index') }}" class="sub-link">Évaluations</a></li>
                        <li><a href="{{ route('stocks.index') }}" class="sub-link">Stock</a></li>
                        <li><a href="{{ route('reports.index') }}" class="sub-link">Rapports</a></li>
                        <li><a href="{{ route('report_schedules.index') }}" class="sub-link">Calendrier Rapports</a></li>
                        
                        <!-- Achats -->
                        <li class="pt-2 border-t border-neutral-700 mt-2"><strong class="text-xs text-gray-500">ACHATS</strong></li>
                        <li><a href="{{ route('purchase_requests.index') }}" class="sub-link">Demandes d'Achat</a></li>
                        <li><a href="{{ route('purchase_orders.index') }}" class="sub-link">Bons de Commande</a></li>
                        <li><a href="{{ route('receptions.index') }}" class="sub-link">Réceptions</a></li>
                        <li><a href="{{ route('supplier_contracts.index') }}" class="sub-link">Contrats Fournisseurs</a></li>
                        
                        <!-- Maintenance -->
                        <li class="pt-2 border-t border-neutral-700 mt-2"><strong class="text-xs text-gray-500">MAINTENANCE</strong></li>
                        <li><a href="{{ route('equipment.index') }}" class="sub-link">Équipements</a></li>
                        <li><a href="{{ route('maintenances.index') }}" class="sub-link">Maintenances</a></li>
                        <li><a href="{{ route('breakdowns.index') }}" class="sub-link">Pannes</a></li>
                        <li><a href="{{ route('interventions.index') }}" class="sub-link">Interventions</a></li>
                        
                        <!-- Logistique -->
                        <li class="pt-2 border-t border-neutral-700 mt-2"><strong class="text-xs text-gray-500">LOGISTIQUE</strong></li>
                        <li><a href="{{ route('vehicles.index') }}" class="sub-link">Véhicules</a></li>
                        <li><a href="{{ route('missions.index') }}" class="sub-link">Missions</a></li>
                        <li><a href="{{ route('fuel_records.index') }}" class="sub-link">Carburant</a></li>
                        <li><a href="{{ route('vehicle_maintenances.index') }}" class="sub-link">Maintenance Véhicules</a></li>
                        
                        <!-- Informatique -->
                        <li class="pt-2 border-t border-neutral-700 mt-2"><strong class="text-xs text-gray-500">INFORMATIQUE</strong></li>
                        <li><a href="{{ route('it_equipment.index') }}" class="sub-link">Équipements IT</a></li>
                        <li><a href="{{ route('software_licenses.index') }}" class="sub-link">Licences Logiciels</a></li>
                        <li><a href="{{ route('it_interventions.index') }}" class="sub-link">Support IT</a></li>
                    </ul>
                </li>
                @endrole

                {{-- Outils --}}
                @auth
                <li>
                    <button @click="open === 'tools' ? open = null : open = 'tools'" class="sidebar-link justify-between">
                        Outils
                        <span x-text="open === 'tools' ? '▲' : '▼'"></span>
                    </button>
                    <ul x-show="open === 'tools'" x-cloak class="mt-2 pl-4 space-y-1">
                        <li><a href="{{ route('messages.index') }}" class="sub-link">Messages</a></li>
                        <li><a href="{{ route('assets.index') }}" class="sub-link">Actifs</a></li>
                        <li><a href="{{ route('settings.index') }}" class="sub-link">Paramètres</a></li>
                    </ul>
                </li>
                @endauth

                {{-- Administration --}}
                @role('Super Admin|RH Manager')
                <li>
                    <button @click="open === 'admin' ? open = null : open = 'admin'" class="sidebar-link justify-between">
                        Administration
                        <span x-text="open === 'admin' ? '▲' : '▼'"></span>
                    </button>
                    <ul x-show="open === 'admin'" x-cloak class="mt-2 pl-4 space-y-1">
                        <li><a href="{{ route('users.index') }}" class="sub-link">Utilisateurs</a></li>
                        @role('Super Admin')
                        <li class="pt-2 border-t border-neutral-700 mt-2"></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="sub-link">Dashboard Admin</a></li>
                        <li><a href="{{ route('admin.activity-logs.index') }}" class="sub-link">Logs d'Activité</a></li>
                        <li><a href="{{ route('admin.system-settings.index') }}" class="sub-link">Paramètres Système</a></li>
                        <li><a href="{{ route('admin.backups.index') }}" class="sub-link">Sauvegardes</a></li>
                        <li><a href="{{ route('admin.system-notifications.index') }}" class="sub-link">Notifications Système</a></li>
                        <li class="pt-2 border-t border-neutral-700 mt-2"></li>
                        <li><a href="{{ route('admin.roles.index') }}" class="sub-link">Rôles</a></li>
                        <li><a href="{{ route('admin.permissions.index') }}" class="sub-link">Permissions</a></li>
                        @endrole
                    </ul>
                </li>
                @endrole

                {{-- Profil --}}
                <li>
                    <a href="{{ route('profile.index') }}" class="sidebar-link">Profil</a>
                </li>

                {{-- Déconnexion --}}
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-link">Déconnexion</button>
                    </form>
                </li>

            </ul>
        </nav>

        {{-- Footer Sidebar --}}
        <div class="p-4 border-t border-[#D4AF37]/30 bg-gradient-to-r from-[#D4AF37]/5 to-transparent">
            <div class="flex items-center justify-center gap-2 text-xs text-neutral-400">
                <svg class="w-4 h-4 text-[#D4AF37]" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                <span class="font-medium">© {{ date('Y') }} Hill Holding</span>
            </div>
            <div class="text-center text-xs text-neutral-600 mt-1">Version 1.0.0</div>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        {{-- HEADER --}}
        <header class="bg-gradient-to-r from-neutral-900 via-black to-neutral-900 border-b border-[#D4AF37]/30 px-6 py-4 flex items-center justify-between sticky top-0 z-50 shadow-lg">
            <div>
                <h1 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#D4AF37] to-yellow-500">@yield('title', 'Dashboard')</h1>
                <p class="text-xs text-neutral-400 mt-0.5">{{ now()->format('l d F Y') }}</p>
            </div>

            <div class="flex items-center gap-4">
                {{-- Dark / Light Mode --}}
                <button @click="dark = !dark" class="p-2.5 rounded-xl bg-neutral-800 hover:bg-neutral-700 border border-neutral-700 hover:border-[#D4AF37]/50 transition-all duration-200" title="Mode sombre">
                    <svg class="w-5 h-5 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                {{-- Notifications --}}
                @php
                    use App\Models\Notification;
                    $notifications = auth()->check()
                        ? Notification::where('user_id', auth()->id())
                            ->where('is_read', false)
                            ->latest()
                            ->take(5)
                            ->get()
                        : [];
                @endphp
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="relative p-2.5 rounded-xl bg-neutral-800 hover:bg-neutral-700 border border-neutral-700 hover:border-[#D4AF37]/50 transition-all duration-200">
                        <svg class="w-5 h-5 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if($notifications->count())
                            <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-red-500 border-2 border-neutral-900 flex items-center justify-center text-xs text-white font-bold">{{ $notifications->count() }}</span>
                        @endif
                    </button>

                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-3 w-96 bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 shadow-2xl rounded-2xl overflow-hidden z-50">
                        <div class="p-4 border-b border-neutral-800 bg-gradient-to-r from-[#D4AF37]/10 to-transparent">
                            <h3 class="font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                Notifications
                                @if($notifications->count())
                                    <span class="ml-auto px-2 py-0.5 bg-red-500 text-white text-xs rounded-full">{{ $notifications->count() }}</span>
                                @endif
                            </h3>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            @forelse($notifications as $note)
                                <div class="p-4 border-b border-neutral-800 hover:bg-neutral-800/50 transition-colors">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 {{ $note->type == 'success' ? 'bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/300/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                            @if($note->type == 'success')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-neutral-300">{{ $note->message }}</p>
                                            <p class="text-xs text-neutral-500 mt-1">{{ $note->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center">
                                    <svg class="w-12 h-12 text-neutral-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-sm text-neutral-400">Aucune notification</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Profil --}}
                <div class="flex items-center gap-3 px-4 py-2 rounded-xl bg-neutral-800 border border-neutral-700 hover:border-[#D4AF37]/50 transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#D4AF37] to-yellow-600 flex items-center justify-center text-black font-bold text-lg shadow-lg">
                        {{ strtoupper(mb_substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="text-sm">
                        <div class="font-bold text-white">{{ auth()->user()?->name ?? 'Invité' }}</div>
                        <div class="text-xs text-neutral-400">{{ auth()->user()?->email ?? '' }}</div>
                    </div>
                </div>
            </div>
        </header>

        {{-- TOASTS --}}
        @if(session('success') || session('error'))
            <div x-data="{ show: true }" 
                 x-init="setTimeout(() => show = false, 5000)" 
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-8"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform translate-x-8"
                 class="fixed bottom-6 right-6 z-50 w-96 p-5 rounded-2xl shadow-2xl border-2
                 {{ session('success') ? 'bg-gradient-to-br from-green-900 to-green-800 border-green-600' : 'bg-gradient-to-br from-red-900 to-red-800 border-red-600' }}">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ session('success') ? 'bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/300' : 'bg-red-500' }}">
                        @if(session('success'))
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-white mb-1">{{ session('success') ? 'Succès' : 'Erreur' }}</h4>
                        <p class="text-sm text-white/90">{{ session('success') ?? session('error') }}</p>
                    </div>
                    <button @click="show = false" class="text-white/70 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- CONTENT --}}
        <main class="p-6 flex-1 overflow-auto bg-gradient-to-br from-neutral-950 via-black to-neutral-950">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
