@php
    $user = auth()->user();
    // Niveau : mere / filiale / agence
    $niveau = $user?->agence_id ? 'agence' : ($user?->filiale_id ? 'filiale' : 'mere');
@endphp

<nav class="p-4">
    <ul class="space-y-1 text-sm">
        <li>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-[#0f0f0f]">
                <span class="text-[#D4AF37]">ðŸ </span>
                <span>Dashboard</span>
            </a>
        </li>

        @role('Super Admin|RH Manager')
            @if($niveau !== 'agence')
                <li class="mt-3 text-xs text-[#9b9b9b] px-3">RH</li>
                <li><a href="{{ route('employees.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">EmployÃ©s</a></li>
                <li><a href="{{ route('departments.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">DÃ©partements</a></li>
                @if($niveau === 'mere')
                    <li><a href="{{ route('filiales.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">Filiales</a></li>
                @endif
                <li><a href="{{ route('agences.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">Agences</a></li>
                <li><a href="{{ route('payrolls.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">Paie</a></li>
            @endif
        @endrole

        @role('Super Admin|Admin Finance')
            <li class="mt-3 text-xs text-[#9b9b9b] px-3">Finance</li>
            <li><a href="{{ route('transactions.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">Transactions</a></li>
            <li><a href="{{ route('budgets.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">Budgets</a></li>
        @endrole

        @role('ChargÃ© des OpÃ©rations|Operations Manager|Super Admin')
            <li class="mt-3 text-xs text-[#9b9b9b] px-3">OpÃ©rations</li>
            <li><a href="{{ route('projects.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">Projets</a></li>
            <li><a href="{{ route('clients.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">Clients</a></li>
        @endrole

        <li class="mt-3 text-xs text-[#9b9b9b] px-3">Outils</li>
        <li><a href="{{ route('messages.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">Messages</a></li>
        <li><a href="{{ route('profile.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">Profil</a></li>

        @role('Super Admin')
            <li class="mt-3 text-xs text-[#9b9b9b] px-3">Admin</li>
            <li><a href="{{ route('roles.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">RÃ´les</a></li>
            <li><a href="{{ route('permissions.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#0f0f0f]">Permissions</a></li>
        @endrole
    </ul>
</nav>







