@extends('layouts.app')

@section('title', 'Types de Congés')

@section('content')
<div class="px-6 py-6">
    <!-- Header avec gradient -->
    <div class="mb-8">
        <h2 class="text-5xl font-bold mb-2 bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">
            🏝️ Types de Congés
        </h2>
        <p class="text-neutral-400">Gérez les différents types de congés disponibles</p>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Types -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 rounded-xl">
                    <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-[#D4AF37] to-yellow-500 bg-clip-text text-transparent mb-2">
                @if(method_exists($leaveTypes, 'total'))
                    {{ $leaveTypes->total() }}
                @else
                    {{ $leaveTypes->count() }}
                @endif
            </div>
            <div class="text-neutral-400 text-sm">Total des types</div>
        </div>

        <!-- Types Payés -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-green-500 to-green-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-green-400 to-green-500 bg-clip-text text-transparent mb-2">
                {{ $leaveTypes->where('is_paid', true)->count() }}
            </div>
            <div class="text-neutral-400 text-sm">Congés payés</div>
        </div>

        <!-- Types Non Payés -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-red-500 to-red-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-red-400 to-red-500 bg-clip-text text-transparent mb-2">
                {{ $leaveTypes->where('is_paid', false)->count() }}
            </div>
            <div class="text-neutral-400 text-sm">Non payés</div>
        </div>
    </div>

    <!-- Bouton Ajouter -->
    <div class="mb-6">
        <a href="{{ route('leave_types.create') }}"
           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black font-bold shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter un type de congé
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

    <!-- Table des Types de Congés -->
    <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl overflow-hidden">
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gradient-to-r from-[#D4AF37]/20 via-yellow-500/20 to-[#D4AF37]/20 border-b border-[#D4AF37]/30">
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Nom</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Description</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Statut Payé</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Jours Max</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-neutral-800">
                @forelse($leaveTypes as $type)
                    <tr class="hover:bg-neutral-800/50 transition-colors duration-200">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-r from-blue-600/30 to-blue-700/30 border border-blue-500/50 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-white font-semibold">{{ $type->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-neutral-400">ID: #{{ $type->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="text-neutral-300 text-sm max-w-md">
                                {{ $type->description ?? '—' }}
                            </div>
                        </td>
                        <td class="p-4">
                            @if($type->is_paid)
                                <span class="px-3 py-1 rounded-xl bg-green-900/30 border border-green-500/50 text-green-300 text-sm font-semibold flex items-center gap-1 w-fit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Payé
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-xl bg-red-900/30 border border-red-500/50 text-red-300 text-sm font-semibold flex items-center gap-1 w-fit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Non payé
                                </span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="inline-flex items-center gap-2 px-3 py-1 bg-neutral-800 rounded-xl">
                                <svg class="w-4 h-4 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-white font-semibold">{{ $type->max_days ?? '∞' }}</span>
                                <span class="text-neutral-400 text-sm">jours</span>
                            </div>
                        </td>

                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="{{ route('leave_types.show', $type->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl text-sm font-semibold shadow-lg hover:scale-105 transition-all duration-200"
                                   title="Voir">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <a href="{{ route('leave_types.edit', $type->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white rounded-xl text-sm font-semibold shadow-lg hover:scale-105 transition-all duration-200"
                                   title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form action="{{ route('leave_types.destroy', $type->id) }}" method="POST"
                                      onsubmit="return confirm('Supprimer ce type de congé ?')">
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
                        <td colspan="5" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <svg class="w-16 h-16 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <div class="text-neutral-400 text-lg">Aucun type de congé trouvé</div>
                                <a href="{{ route('leave_types.create') }}"
                                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black font-bold shadow-lg hover:scale-105 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Créer votre premier type de congé
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($leaveTypes, 'hasPages') && $leaveTypes->hasPages())
        <div class="mt-6">
            <div class="flex justify-between items-center">
                <div class="text-neutral-400">
                    Affichage de {{ $leaveTypes->firstItem() ?? 0 }} à {{ $leaveTypes->lastItem() ?? 0 }} sur {{ $leaveTypes->total() }} types
                </div>
                <div class="pagination-custom">
                    {{ $leaveTypes->links() }}
                </div>
            </div>
        </div>
    @endif

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
