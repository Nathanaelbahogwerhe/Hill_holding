@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Carburant</h1>
        <a href="{{ route('fuel_records.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouveau Ravitaillement
        </a>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Véhicule</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantité (L)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kilométrage</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Consommation</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Validé</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($fuelRecords as $fuel)
                <tr>
                    <td class="px-6 py-4">
                        <span class="font-mono">{{ $fuel->vehicle->immatriculation }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $fuel->date_ravitaillement->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-bold">{{ $fuel->quantite }} L</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($fuel->montant, 0, ',', ' ') }} FCFA</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($fuel->kilometrage, 0, ',', ' ') }} km</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($fuel->consommation)
                            <span class="{{ $fuel->consommation > ($fuel->vehicle->consommation_moyenne ?? 999) ? 'text-red-600 font-bold' : 'text-green-600' }}">
                                {{ number_format($fuel->consommation, 2) }} L/100km
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($fuel->valide)
                            <span class="text-green-600">✓</span>
                        @else
                            <span class="text-gray-400">✗</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('fuel_records.show', $fuel) }}" class="text-blue-600 hover:underline mr-3">Voir</a>
                        @if(!$fuel->valide)
                        <form action="{{ route('fuel_records.destroy', $fuel) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">Aucun ravitaillement trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $fuelRecords->links() }}
    </div>
</div>
@endsection
