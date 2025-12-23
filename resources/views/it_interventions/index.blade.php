@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Support IT</h1>
        <a href="{{ route('it_interventions.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouvelle Demande
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4">
            <div class="text-sm text-gray-500">Total</div>
            <div class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/30 rounded-xl shadow p-4">
            <div class="text-sm text-white">Ouverte</div>
            <div class="text-2xl font-bold text-white">{{ $stats['ouverte'] }}</div>
        </div>
        <div class="bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/30 rounded-xl shadow p-4">
            <div class="text-sm text-white">En Cours</div>
            <div class="text-2xl font-bold text-white">{{ $stats['en_cours'] }}</div>
        </div>
        <div class="bg-gradient-to-br from-green-900/50 to-green-800/50 border border-green-500/30 rounded-xl shadow p-4">
            <div class="text-sm text-white">Résolue</div>
            <div class="text-2xl font-bold text-white">{{ $stats['resolue'] }}</div>
        </div>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Objet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Demandeur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Technicien</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priorité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($interventions as $intervention)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('it_interventions.show', $intervention) }}" class="text-white hover:underline font-mono">{{ $intervention->numero }}</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ ucfirst($intervention->type) }}</span>
                    </td>
                    <td class="px-6 py-4">{{ Str::limit($intervention->objet, 40) }}</td>
                    <td class="px-6 py-4">{{ $intervention->demandeur->name }}</td>
                    <td class="px-6 py-4">
                        @if($intervention->technicien)
                            {{ $intervention->technicien->name }}
                        @else
                            <span class="text-gray-400">Non assigné</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded bg-{{ $intervention->priorite_color }}-100 text-{{ $intervention->priorite_color }}-800">
                            {{ ucfirst($intervention->priorite) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded bg-{{ $intervention->statut_color }}-100 text-{{ $intervention->statut_color }}-800">
                            {{ ucfirst($intervention->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('it_interventions.show', $intervention) }}" class="text-white hover:underline">Voir</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">Aucune intervention trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $interventions->links() }}
    </div>
</div>
@endsection
