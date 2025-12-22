@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Interventions</h1>
        <a href="{{ route('interventions.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouvelle Intervention
        </a>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Technicien</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($interventions as $intervention)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('interventions.show', $intervention) }}" class="text-blue-600 hover:underline">{{ $intervention->numero }}</a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-mono">{{ $intervention->equipment->code }}</span>
                        <p class="text-sm text-gray-500">{{ $intervention->equipment->nom }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @if($intervention->breakdown_id)
                            <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Panne</span>
                        @else
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Maintenance</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ Str::limit($intervention->description, 40) }}</td>
                    <td class="px-6 py-4">{{ $intervention->technicien->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $intervention->date_intervention->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('interventions.show', $intervention) }}" class="text-blue-600 hover:underline">Voir</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Aucune intervention trouvée</td>
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
