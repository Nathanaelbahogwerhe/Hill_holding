@extends('layouts.app')

@section('title', 'Assurances')

@section('content')
<div class="px-6 py-6">
    <!-- Header avec gradient -->
    <div class="mb-8">
        <h2 class="text-5xl font-bold mb-2 bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">
            🛡️ Gestion des Assurances
        </h2>
        <p class="text-neutral-400">Gérez les assurances des employés</p>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Assurances -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 rounded-xl">
                    <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-[#D4AF37] to-yellow-500 bg-clip-text text-transparent mb-2">
                {{ $insurances->total() }}
            </div>
            <div class="text-neutral-400 text-sm">Total des assurances</div>
        </div>

        <!-- Employés Couverts -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-blue-500 bg-clip-text text-transparent mb-2">
                {{ $insurances->unique('employee_id')->count() }}
            </div>
            <div class="text-neutral-400 text-sm">Employés couverts</div>
        </div>

        <!-- Total Primes -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-green-500 to-green-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-green-400 to-green-500 bg-clip-text text-transparent mb-2">
                {{ number_format($insurances->sum('premium') ?? 0, 0, ',', ' ') }}
            </div>
            <div class="text-neutral-400 text-sm">Total primes (FBu)</div>
        </div>

        <!-- Types d'Assurances -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-purple-500 bg-clip-text text-transparent mb-2">
                {{ $insurances->unique('type')->count() }}
            </div>
            <div class="text-neutral-400 text-sm">Types d'assurances</div>
        </div>
    </div>

    <!-- Bouton Ajouter -->
    <div class="mb-6">
        <a href="{{ route('insurances.create') }}"
           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black font-bold shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter une assurance
        </a>
    </div>

    @if(session('success'))
        <div class="px-6 py-4 mb-6 bg-gradient-to-r from-green-900/50 to-green-800/30 border border-green-500 text-green-200 rounded-xl flex items-center gap-3 animate-fadeIn">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Table des Assurances -->
    <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl overflow-hidden">
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gradient-to-r from-[#D4AF37]/20 via-yellow-500/20 to-[#D4AF37]/20 border-b border-[#D4AF37]/30">
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Employé</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Type</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Compagnie</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Période</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Prime</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-neutral-800">
                @forelse($insurances as $insurance)
                    <tr class="hover:bg-neutral-800/50 transition-colors duration-200">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-cyan-500 to-cyan-600 flex items-center justify-center text-white font-bold shadow-lg">
                                    {{ strtoupper(substr($insurance->employee?->name ?? 'U', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="text-white font-semibold">
                                        {{ $insurance->employee?->name ?? 'Employé inconnu' }}
                                    </div>
                                    <div class="text-xs text-neutral-400">
                                        ID: #{{ $insurance->employee_id }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-xl bg-purple-900/30 border border-purple-500/50 text-purple-300 text-sm font-semibold">
                                {{ $insurance->type ?? '—' }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="text-neutral-300">{{ $insurance->company ?? '—' }}</div>
                        </td>
                        <td class="p-4">
                            <div class="text-neutral-300 text-sm">
                                <div>{{ \Carbon\Carbon::parse($insurance->start_date)->format('d/m/Y') ?? '—' }}</div>
                                <div class="text-xs text-neutral-500">au {{ \Carbon\Carbon::parse($insurance->end_date)->format('d/m/Y') ?? '—' }}</div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-[#D4AF37] font-semibold text-sm">
                                    {{ number_format($insurance->premium ?? 0, 0, ',', ' ') }} FBu
                                </span>
                            </div>
                        </td>

                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="{{ route('insurances.show', $insurance->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl text-sm font-semibold shadow-lg hover:scale-105 transition-all duration-200"
                                   title="Voir">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <a href="{{ route('insurances.edit', $insurance->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white rounded-xl text-sm font-semibold shadow-lg hover:scale-105 transition-all duration-200"
                                   title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form action="{{ route('insurances.destroy', $insurance->id) }}" method="POST"
                                      onsubmit="return confirm('Supprimer cette assurance ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl text-sm font-semibold shadow-lg hover:scale-105 transition-all duration-200"
                                            title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <svg class="w-16 h-16 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <div class="text-neutral-400 text-lg">Aucune assurance trouvée</div>
                                <a href="{{ route('insurances.create') }}"
                                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black font-bold shadow-lg hover:scale-105 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Créer votre première assurance
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        <div class="flex justify-between items-center">
            <div class="text-neutral-400">
                Affichage de {{ $insurances->firstItem() ?? 0 }} à {{ $insurances->lastItem() ?? 0 }} sur {{ $insurances->total() }} assurances
            </div>
            <div class="pagination-custom">
                {{ $insurances->links() }}
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

.pagination-custom nav {
    @apply flex gap-2;
}

.pagination-custom nav a,
.pagination-custom nav span {
    @apply px-4 py-2 rounded-xl border transition-all duration-200;
}

.pagination-custom nav a {
    @apply border-neutral-700 bg-neutral-900 text-white hover:border-[#D4AF37] hover:bg-[#D4AF37]/20 hover:scale-105;
}

.pagination-custom nav span[aria-current="page"] {
    @apply border-[#D4AF37] bg-gradient-to-r from-[#D4AF37] to-yellow-500 text-black font-bold;
}

.pagination-custom nav span[aria-disabled="true"] {
    @apply border-neutral-800 bg-neutral-900 text-neutral-600 cursor-not-allowed;
}
</style>
@endsection
