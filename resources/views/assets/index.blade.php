@extends('layouts.app')

@section('title', 'Gestion des Actifs')

@section('content')
<div class="px-6 py-6">
    <!-- Header avec gradient -->
    <div class="mb-8">
        <h2 class="text-5xl font-bold mb-2 bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">
            🏢 Gestion des Actifs
        </h2>
        <p class="text-neutral-400">Suivi et gestion du patrimoine de l'entreprise</p>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Actifs -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 rounded-xl">
                    <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-[#D4AF37] to-yellow-500 bg-clip-text text-transparent mb-2">
                {{ $assets->total() }}
            </div>
            <div class="text-neutral-400 text-sm">Total des actifs</div>
        </div>

        <!-- Valeur Totale -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-green-500 to-green-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-green-400 to-green-500 bg-clip-text text-transparent mb-2">
                {{ number_format($assets->sum('value'), 0, ',', ' ') }} $
            </div>
            <div class="text-neutral-400 text-sm">Valeur totale</div>
        </div>

        <!-- Actifs Actifs -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-blue-500 bg-clip-text text-transparent mb-2">
                {{ $assets->where('status', 'active')->count() }}
            </div>
            <div class="text-neutral-400 text-sm">Actifs en service</div>
        </div>

        <!-- En Maintenance -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-amber-400 to-amber-500 bg-clip-text text-transparent mb-2">
                {{ $assets->where('status', 'maintenance')->count() }}
            </div>
            <div class="text-neutral-400 text-sm">En maintenance</div>
        </div>
    </div>

    <!-- Bouton Ajouter un Actif -->
    <div class="mb-6">
        <a href="{{ route('assets.create') }}"
           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black font-bold shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter un actif
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

    <!-- Table des Actifs -->
    <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl overflow-hidden">
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gradient-to-r from-[#D4AF37]/20 via-yellow-500/20 to-[#D4AF37]/20 border-b border-[#D4AF37]/30">
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Nom</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Catégorie</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Valeur</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Statut</th>
                    <th class="p-4 text-left text-[#D4AF37] font-bold">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-neutral-800">
                @forelse($assets as $asset)
                    <tr class="hover:bg-neutral-800/50 transition-colors duration-200">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-[#D4AF37] to-yellow-500 flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-white font-semibold">{{ $asset->name }}</div>
                                    @if($asset->acquisition_date)
                                        <div class="text-xs text-neutral-400">
                                            Acquis le {{ \Carbon\Carbon::parse($asset->acquisition_date)->format('d/m/Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-xl bg-gradient-to-r from-purple-600/30 to-purple-700/30 border border-purple-500/50 text-purple-300 text-sm font-semibold">
                                {{ $asset->category }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="text-white font-bold">{{ number_format($asset->value ?? 0, 2, ',', ' ') }} $</div>
                        </td>
                        <td class="p-4">
                            @php
                                $statusConfig = [
                                    'active' => ['label' => 'Actif', 'color' => 'from-green-500 to-green-600', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                    'inactive' => ['label' => 'Inactif', 'color' => 'from-gray-500 to-gray-600', 'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636'],
                                    'maintenance' => ['label' => 'Maintenance', 'color' => 'from-amber-500 to-amber-600', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                                    'disposed' => ['label' => 'Cédé', 'color' => 'from-red-500 to-red-600', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'],
                                ];
                                $status = $statusConfig[$asset->status] ?? $statusConfig['inactive'];
                            @endphp
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-xl bg-gradient-to-r {{ $status['color'] }} text-white text-sm font-semibold shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $status['icon'] }}" />
                                </svg>
                                {{ $status['label'] }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="{{ route('assets.show', $asset) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl text-sm font-semibold shadow-lg hover:scale-105 transition-all duration-200"
                                   title="Voir les détails">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <a href="{{ route('assets.edit', $asset) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white rounded-xl text-sm font-semibold shadow-lg hover:scale-105 transition-all duration-200"
                                   title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form action="{{ route('assets.destroy', $asset) }}" method="POST"
                                      onsubmit="return confirm('Supprimer cet actif ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl text-sm font-semibold shadow-lg hover:scale-105 transition-all duration-200"
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <div class="text-neutral-400 text-lg">Aucun actif enregistré</div>
                                <a href="{{ route('assets.create') }}"
                                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black font-bold shadow-lg hover:scale-105 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Ajouter votre premier actif
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <!-- Pagination avec style moderne -->
    <div class="mt-6">
        <div class="flex justify-between items-center">
            <div class="text-neutral-400">
                Affichage de {{ $assets->firstItem() ?? 0 }} à {{ $assets->lastItem() ?? 0 }} sur {{ $assets->total() }} actifs
            </div>
            <div class="pagination-custom">
                {{ $assets->links() }}
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
