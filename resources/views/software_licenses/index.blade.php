@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Licences Logiciels</h1>
        <a href="{{ route('software_licenses.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouvelle Licence
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-500">Total</div>
            <div class="text-2xl font-bold">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-4">
            <div class="text-sm text-green-600">Active</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</div>
        </div>
        <div class="bg-orange-50 rounded-lg shadow p-4">
            <div class="text-sm text-orange-600">Expire Bientôt</div>
            <div class="text-2xl font-bold text-orange-600">{{ $stats['expire_soon'] }}</div>
        </div>
        <div class="bg-red-50 rounded-lg shadow p-4">
            <div class="text-sm text-red-600">Expirée</div>
            <div class="text-2xl font-bold text-red-600">{{ $stats['expiree'] }}</div>
        </div>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Logiciel</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Postes</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expiration</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($licenses as $license)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('software_licenses.show', $license) }}" class="text-blue-600 hover:underline font-mono">{{ $license->numero }}</a>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ $license->nom_logiciel }}</div>
                        @if($license->version)
                        <div class="text-sm text-gray-500">v{{ $license->version }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ ucfirst($license->type) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="{{ $license->postes_disponibles > 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                            {{ $license->postes_utilises }}/{{ $license->nombre_postes }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($license->date_expiration)
                            <span class="{{ $license->jours_restants !== null && $license->jours_restants < 30 ? 'text-red-600 font-bold' : '' }}">
                                {{ $license->date_expiration->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-gray-400">Perpétuelle</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded bg-{{ $license->statut_color }}-100 text-{{ $license->statut_color }}-800">
                            {{ ucfirst($license->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('software_licenses.show', $license) }}" class="text-blue-600 hover:underline">Voir</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Aucune licence trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $licenses->links() }}
    </div>
</div>
@endsection
