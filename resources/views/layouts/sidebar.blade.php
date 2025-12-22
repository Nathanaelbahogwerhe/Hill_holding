<!-- SIDEBAR -->
<aside class="w-64 bg-hh-card border-r border-hh-border flex flex-col" x-data="{ open: null }">
    <div class="p-4 flex items-center gap-3 border-b border-hh-border">
        <!-- Logo Image -->
        <div class="w-10 h-10 rounded-md overflow-hidden flex items-center justify-center bg-hh-light/10">
            <img src="{{ asset('images/hill holding.png') }}" alt="Hill Holding" class="w-full h-full object-cover">
        </div>
        <div>
            <div class="text-lg font-semibold">Hill Holding</div>
            <div class="text-xs text-hh-muted">Gestion centralisée</div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="p-4 flex-1 overflow-auto">
        <ul class="space-y-1 text-sm">

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('dashboard') }}" class="sidebar-link">
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- RH --}}
            @role('Super Admin|RH Manager')
            <li>
                <button @click="open === 'rh' ? open = null : open = 'rh'" class="sidebar-link justify-between">
                    <span class="flex items-center gap-2">RH</span>

                    <svg x-show="open !== 'rh'" class="w-4 h-4 text-hh-muted" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="1.6"/>
                    </svg>

                    <svg x-show="open === 'rh'" class="w-4 h-4 text-hh-muted" viewBox="0 0 24 24">
                        <path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="1.6"/>
                    </svg>
                </button>

                <ul x-show="open === 'rh'" x-cloak class="mt-2 pl-6 space-y-1">
                    <li><a href="{{ route('employees.index') }}" class="sub-link">Employés</a></li>
                    <li><a href="{{ route('departments.index') }}" class="sub-link">Départements</a></li>
                    <li><a href="{{ route('positions.index') }}" class="sub-link">Postes</a></li>
                    <li><a href="{{ route('filiales.index') }}" class="sub-link">Filiales</a></li>
                    <li><a href="{{ route('agences.index') }}" class="sub-link">Agences</a></li>
                    <li><a href="{{ route('payrolls.index') }}" class="sub-link">Paie</a></li>
                    <li><a href="{{ route('leaves.index') }}" class="sub-link">Congés</a></li>
                    <li><a href="{{ route('attendances.index') }}" class="sub-link">Présences</a></li>
                    <li><a href="{{ route('contracts.index') }}" class="sub-link">Contrats</a></li>
                    <li><a href="{{ route('insurances.index') }}" class="sub-link">Assurances</a></li>
                    <li><a href="{{ route('leave_types.index') }}" class="sub-link">Types de congés</a></li>
                </ul>
            </li>
            @endrole

            {{-- Finance --}}
            @role('Super Admin|Admin Finance')
            <li>
                <button @click="open === 'fin' ? open = null : open = 'fin'" class="sidebar-link justify-between">
                    <span class="flex items-center gap-2">Finance</span>

                    <svg x-show="open !== 'fin'" class="w-4 h-4 text-hh-muted">
                        <path d="M6 9l6 6 6-6" stroke-width="1.6"/>
                    </svg>
                    <svg x-show="open === 'fin'" class="w-4 h-4 text-hh-muted">
                        <path d="M18 15l-6-6-6 6" stroke-width="1.6"/>
                    </svg>
                </button>

                <ul x-show="open === 'fin'" x-cloak class="mt-2 pl-6 space-y-1">
                    <li><a href="{{ route('transactions.index') }}" class="sub-link">Transactions</a></li>
                    <li><a href="{{ route('expenses.index') }}" class="sub-link">Dépenses</a></li>
                    <li><a href="{{ route('revenues.index') }}" class="sub-link">Revenus</a></li>
                    <li><a href="{{ route('budgets.index') }}" class="sub-link">Budgets</a></li>
                    <li><a href="{{ route('invoices.index') }}" class="sub-link">Factures</a></li>
                    <li><a href="{{ route('financial_reports.index') }}" class="sub-link">Rapports financiers</a></li>
                    <li><a href="{{ route('finances.index') }}" class="sub-link">Finances</a></li>
                </ul>
            </li>
            @endrole

            {{-- Opérations --}}
            @role('Super Admin|Chargé des Opérations|Operations Manager')
            <li>
                <button @click="open === 'ops' ? open = null : open = 'ops'" class="sidebar-link justify-between">
                    <span class="flex items-center gap-2">Opérations</span>

                    <svg x-show="open !== 'ops'" class="w-4 h-4 text-hh-muted">
                        <path d="M6 9l6 6 6-6" stroke-width="1.6"/>
                    </svg>
                    <svg x-show="open === 'ops'" class="w-4 h-4 text-hh-muted">
                        <path d="M18 15l-6-6-6 6" stroke-width="1.6"/>
                    </svg>
                </button>

                <ul x-show="open === 'ops'" x-cloak class="mt-2 pl-6 space-y-1">
                    <li><a href="{{ route('clients.index') }}" class="sub-link">Clients</a></li>
                    <li><a href="{{ route('projects.index') }}" class="sub-link">Projets</a></li>
                    <li><a href="{{ route('tasks.index') }}" class="sub-link">Tâches</a></li>
                    <li><a href="{{ route('client_payments.index') }}" class="sub-link">Paiements clients</a></li>
                    <li><a href="{{ route('products.index') }}" class="sub-link">Produits</a></li>
                    <li><a href="{{ route('stock_transfers.index') }}" class="sub-link">Transferts de stock</a></li>
                    <li><a href="{{ route('contracts_business.index') }}" class="sub-link">Contrats Business</a></li>
                </ul>
            </li>
            @endrole

            {{-- Outils --}}
            @auth
            <li>
                <button @click="open === 'tools' ? open = null : open = 'tools'" class="sidebar-link justify-between">
                    <span class="flex items-center gap-2">Outils</span>

                    <svg x-show="open !== 'tools'" class="w-4 h-4 text-hh-muted">
                        <path d="M6 9l6 6 6-6" stroke-width="1.6"/>
                    </svg>
                    <svg x-show="open === 'tools'" class="w-4 h-4 text-hh-muted">
                        <path d="M18 15l-6-6-6 6" stroke-width="1.6"/>
                    </svg>
                </button>

                <ul x-show="open === 'tools'" x-cloak class="mt-2 pl-6 space-y-1">
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
                    <span class="flex items-center gap-2">Administration</span>

                    <svg x-show="open !== 'admin'" class="w-4 h-4 text-hh-muted">
                        <path d="M6 9l6 6 6-6" stroke-width="1.6"/>
                    </svg>
                    <svg x-show="open === 'admin'" class="w-4 h-4 text-hh-muted">
                        <path d="M18 15l-6-6-6 6" stroke-width="1.6"/>
                    </svg>
                </button>

                <ul x-show="open === 'admin'" x-cloak class="mt-2 pl-6 space-y-1">
                    <li><a href="{{ route('users.index') }}" class="sub-link">Utilisateurs</a></li>
                    @role('Super Admin')
                    <li><a href="{{ route('roles.index') }}" class="sub-link">Rôles</a></li>
                    <li><a href="{{ route('permissions.index') }}" class="sub-link">Permissions</a></li>
                    @endrole
                </ul>
            </li>
            @endrole

            {{-- Profil --}}
            <li>
                <a href="{{ route('profile.index') }}" class="sidebar-link">
                    <span>Profil</span>
                </a>
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

    <div class="p-4 border-t border-hh-border text-xs text-hh-muted">
        © {{ date('Y') }} Hill Holding
    </div>
</aside>
