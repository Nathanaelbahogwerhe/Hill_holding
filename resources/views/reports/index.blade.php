@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Rapports</h1>
            <a href="{{ route('reports.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50">
                + Nouveau Rapport
            </a>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/30 rounded-xl p-4">
                <p class="text-sm text-neutral-400">Total</p>
                <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/30 rounded-xl p-4">
                <p class="text-sm text-neutral-400">Brouillons</p>
                <p class="text-2xl font-bold text-white">{{ $stats['brouillons'] }}</p>
            </div>
            <div class="bg-orange-50 rounded-xl p-4">
                <p class="text-sm text-neutral-400">En Attente</p>
                <p class="text-2xl font-bold text-orange-600">{{ $stats['en_attente'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/30 rounded-xl p-4">
                <p class="text-sm text-neutral-400">Validés</p>
                <p class="text-2xl font-bold text-white">{{ $stats['valides'] }}</p>
            </div>
        </div>

        <!-- Filtres -->
        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-2">Type</label>
                <select name="type" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                    <option value="">Tous</option>
                    <option value="journalier" {{ request('type') == 'journalier' ? 'selected' : '' }}>Journalier</option>
                    <option value="hebdomadaire" {{ request('type') == 'hebdomadaire' ? 'selected' : '' }}>Hebdomadaire</option>
                    <option value="mensuel" {{ request('type') == 'mensuel' ? 'selected' : '' }}>Mensuel</option>
                    <option value="projet" {{ request('type') == 'projet' ? 'selected' : '' }}>Projet</option>
                    <option value="mission" {{ request('type') == 'mission' ? 'selected' : '' }}>Mission</option>
                    <option value="département" {{ request('type') == 'département' ? 'selected' : '' }}>Département</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-2">Statut</label>
                <select name="statut" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                    <option value="">Tous</option>
                    <option value="brouillon" {{ request('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                    <option value="soumis" {{ request('statut') == 'soumis' ? 'selected' : '' }}>Soumis</option>
                    <option value="validé" {{ request('statut') == 'validé' ? 'selected' : '' }}>Validé</option>
                    <option value="rejeté" {{ request('statut') == 'rejeté' ? 'selected' : '' }}>Rejeté</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-2">Département</label>
                <select name="department_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                    <option value="">Tous</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg">
                    Filtrer
                </button>
            </div>
        </form>

        <!-- Liste des rapports -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Soumis par</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reports as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $report->titre }}</div>
                        </td>
                        <td class="px-6 py-4">
                            {!! $report->type_badge !!}
                        </td>
                        <td class="px-6 py-4">
                            {!! $report->status_badge !!}
                        </td>
                        <td class="px-6 py-4">
                            {{ $report->soumetteur->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $report->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('reports.show', $report) }}" 
                               class="text-white hover:text-blue-800 mr-3">Voir</a>
                            @if($report->statut == 'brouillon')
                                <a href="{{ route('reports.edit', $report) }}" 
                                   class="text-white hover:text-green-800">Modifier</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Aucun rapport trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection
