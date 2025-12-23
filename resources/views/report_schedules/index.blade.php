@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Calendrier des Rapports</h1>
            <a href="{{ route('report_schedules.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50">
                + Nouveau Calendrier
            </a>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/30 rounded-xl p-4">
                <p class="text-sm text-neutral-400">Total</p>
                <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/30 rounded-xl p-4">
                <p class="text-sm text-neutral-400">Actifs</p>
                <p class="text-2xl font-bold text-white">{{ $stats['actifs'] }}</p>
            </div>
            <div class="bg-red-50 rounded-xl p-4">
                <p class="text-sm text-neutral-400">En Retard</p>
                <p class="text-2xl font-bold text-red-600">{{ $stats['en_retard'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/30 rounded-xl p-4">
                <p class="text-sm text-neutral-400">À Venir (48h)</p>
                <p class="text-2xl font-bold text-white">{{ $stats['a_venir'] }}</p>
            </div>
        </div>

        <!-- Liste des calendriers -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fréquence</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Département</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prochaine Échéance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($schedules as $schedule)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $schedule->nom }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-gradient-to-r from-blue-900/50 to-blue-800/50 border border-blue-500/30 text-blue-300">
                                {{ ucfirst($schedule->type_rapport) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ ucfirst($schedule->frequence) }}
                            @if($schedule->frequence == 'weekly')
                                (Jour {{ $schedule->jour_semaine }})
                            @elseif($schedule->frequence == 'monthly')
                                ({{ $schedule->jour_mois }})
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $schedule->department->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($schedule->prochaine_echeance)
                                <div class="text-sm">
                                    {{ \Carbon\Carbon::parse($schedule->prochaine_echeance)->format('d/m/Y H:i') }}
                                    @if($schedule->isOverdue())
                                        <span class="ml-2 px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                            En retard
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400">Non défini</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($schedule->active)
                                <span class="px-2 py-1 text-xs rounded-full bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300">Actif</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Inactif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('report_schedules.show', $schedule) }}" 
                               class="text-white hover:text-blue-800 mr-3">Voir</a>
                            <a href="{{ route('report_schedules.edit', $schedule) }}" 
                               class="text-white hover:text-green-800">Modifier</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            Aucun calendrier trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $schedules->links() }}
        </div>
    </div>
</div>
@endsection
