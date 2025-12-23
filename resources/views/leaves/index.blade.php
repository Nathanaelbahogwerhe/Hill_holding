@extends('layouts.app')

@section('title', 'Congés')

@section('content')
<div class="px-6 py-6">
    <!-- Header avec gradient -->
    <div class="mb-8">
        <h2 class="text-5xl font-bold mb-2 bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">
            🏖️ Gestion des Congés
        </h2>
        <p class="text-neutral-400">Gérez les demandes de congés et les absences</p>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- En Attente -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-amber-400 to-amber-500 bg-clip-text text-transparent mb-2">
                {{ $leaves->where('status', 'pending')->count() }}
            </div>
            <div class="text-neutral-400 text-sm">En attente</div>
        </div>

        <!-- Approuvés -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-green-500 to-green-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-green-400 to-green-500 bg-clip-text text-transparent mb-2">
                {{ $leaves->where('status', 'approved')->count() }}
            </div>
            <div class="text-neutral-400 text-sm">Approuvés</div>
        </div>

        <!-- Rejetés -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-red-500 to-red-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-red-400 to-red-500 bg-clip-text text-transparent mb-2">
                {{ $leaves->where('status', 'rejected')->count() }}
            </div>
            <div class="text-neutral-400 text-sm">Rejetés</div>
        </div>

        <!-- Total -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 rounded-xl">
                    <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-[#D4AF37] to-yellow-500 bg-clip-text text-transparent mb-2">
                {{ $leaves->total() }}
            </div>
            <div class="text-neutral-400 text-sm">Total</div>
        </div>
    </div>

    <!-- Bouton Ajouter -->
    <div class="mb-6">
        <a href="{{ route('leaves.create') }}"
           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black font-bold shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter un congé
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

    <!-- Table des Congés -->
    <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl overflow-hidden">
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gradient-to-r from-[#D4AF37]/20 via-yellow-500/20 to-[#D4AF37]/20 border-b border-[#D4AF37]/30">
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Employé</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Filiale</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Type</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Période</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Jours</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Statut</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-neutral-800">
                @forelse($leaves as $leave)
                    <tr class="hover:bg-neutral-800/50 transition-colors duration-200">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-lg">
                                    {{ strtoupper(substr($leave->employee?->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($leave->employee?->last_name ?? 'N', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-white font-semibold">
                                        {{ $leave->employee?->first_name }} {{ $leave->employee?->last_name }}
                                    </div>
                                    <div class="text-xs text-neutral-400">
                                        {{ $leave->employee?->department?->name ?? '—' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            @if($leave->employee?->filiale)
                                <span class="px-3 py-1 rounded-xl bg-gradient-to-r from-blue-600/30 to-blue-700/30 border border-blue-500/50 text-blue-300 text-sm font-semibold">
                                    {{ $leave->employee->filiale->name }}
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-xl bg-gradient-to-r from-[#D4AF37]/30 to-yellow-500/30 border border-[#D4AF37]/50 text-[#D4AF37] text-sm font-semibold">
                                    Maison Mère
                                </span>
                            @endif
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-xl bg-orange-900/30 border border-orange-500/50 text-orange-300 text-sm">
                                {{ $leave->leaveType?->name ?? '—' }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="text-neutral-300 text-sm">
                                <div>{{ $leave->start_date?->format('d/m/Y') ?? '—' }}</div>
                                <div class="text-xs text-neutral-500">au {{ $leave->end_date?->format('d/m/Y') ?? '—' }}</div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-xl bg-neutral-800 text-white text-sm font-semibold">
                                {{ $leave->start_date && $leave->end_date ? $leave->start_date->diffInDays($leave->end_date) + 1 : '—' }} j
                            </span>
                        </td>
                        <td class="p-4">
                            @if($leave->status === 'pending')
                                <span class="px-3 py-1 rounded-xl bg-amber-900/30 border border-amber-500/50 text-amber-300 text-sm font-semibold flex items-center gap-1 w-fit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    En attente
                                </span>
                            @elseif($leave->status === 'approved')
                                <span class="px-3 py-1 rounded-xl bg-green-900/30 border border-green-500/50 text-green-300 text-sm font-semibold flex items-center gap-1 w-fit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Approuvé
                                </span>
                            @elseif($leave->status === 'rejected')
                                <span class="px-3 py-1 rounded-xl bg-red-900/30 border border-red-500/50 text-red-300 text-sm font-semibold flex items-center gap-1 w-fit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Rejeté
                                </span>
                            @endif
                        </td>

                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="{{ route('leaves.show', $leave->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl text-sm font-semibold shadow-lg hover:scale-105 transition-all duration-200"
                                   title="Voir">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <a href="{{ route('leaves.edit', $leave->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white rounded-xl text-sm font-semibold shadow-lg hover:scale-105 transition-all duration-200"
                                   title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST"
                                      onsubmit="return confirm('Supprimer ce congé ?')">
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
                        <td colspan="7" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <svg class="w-16 h-16 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <div class="text-neutral-400 text-lg">Aucun congé trouvé</div>
                                <a href="{{ route('leaves.create') }}"
                                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black font-bold shadow-lg hover:scale-105 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Ajouter un congé
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
                Affichage de {{ $leaves->firstItem() ?? 0 }} à {{ $leaves->lastItem() ?? 0 }} sur {{ $leaves->total() }} congés
            </div>
            <div class="pagination-custom">
                {{ $leaves->links() }}
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
