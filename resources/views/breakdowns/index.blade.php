@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Pannes</h1>
        <a href="{{ route('breakdowns.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Signaler une Panne
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">En Attente</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['en_attente'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">En Réparation</p>
            <p class="text-2xl font-bold text-orange-600">{{ $stats['en_reparation'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Résolues</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['resolue'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Critiques</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['critique'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sévérité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($breakdowns as $breakdown)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('breakdowns.show', $breakdown) }}" class="text-blue-600 hover:underline">{{ $breakdown->numero }}</a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-mono">{{ $breakdown->equipment->code }}</span>
                        <p class="text-sm text-gray-500">{{ $breakdown->equipment->nom }}</p>
                    </td>
                    <td class="px-6 py-4">{{ Str::limit($breakdown->description, 40) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($breakdown->severite === 'mineure') bg-blue-100 text-blue-800
                            @elseif($breakdown->severite === 'moyenne') bg-yellow-100 text-yellow-800
                            @elseif($breakdown->severite === 'majeure') bg-orange-100 text-orange-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($breakdown->severite) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $breakdown->date_panne->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($breakdown->statut === 'en_attente') bg-blue-100 text-blue-800
                            @elseif($breakdown->statut === 'en_reparation') bg-orange-100 text-orange-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ str_replace('_', ' ', ucfirst($breakdown->statut)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('breakdowns.show', $breakdown) }}" class="text-blue-600 hover:underline">Voir</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Aucune panne trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $breakdowns->links() }}
    </div>
</div>
@endsection
