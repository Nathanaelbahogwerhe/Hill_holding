@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Rapport de Stock par Article</h1>
            <a href="{{ route('stocks.index') }}" 
               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                Retour
            </a>
        </div>

        <!-- Filtres -->
        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filiale</label>
                <select name="filiale_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Toutes</option>
                    @foreach($filiales as $filiale)
                        <option value="{{ $filiale->id }}" {{ request('filiale_id') == $filiale->id ? 'selected' : '' }}>
                            {{ $filiale->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Agence</label>
                <select name="agence_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Toutes</option>
                    @foreach($agences as $agence)
                        <option value="{{ $agence->id }}" {{ request('agence_id') == $agence->id ? 'selected' : '' }}>
                            {{ $agence->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Filtrer
                </button>
            </div>
        </form>

        <!-- Tableau du rapport -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Article
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Entrées Totales
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sorties Totales
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stock Actuel
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Valeur Stock
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rapport as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $item->articles }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-green-600 font-semibold">
                                +{{ number_format($item->total_entrees, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-red-600 font-semibold">
                                -{{ number_format($item->total_sorties, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="font-semibold {{ $item->stock_actuel > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($item->stock_actuel, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-blue-600 font-semibold">
                                {{ number_format($item->valeur_stock, 2) }} FC
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Aucun mouvement de stock trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($rapport->count() > 0)
                <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                    <tr class="font-bold">
                        <td class="px-6 py-4">TOTAL</td>
                        <td class="px-6 py-4 text-right text-green-600">
                            +{{ number_format($rapport->sum('total_entrees'), 2) }}
                        </td>
                        <td class="px-6 py-4 text-right text-red-600">
                            -{{ number_format($rapport->sum('total_sorties'), 2) }}
                        </td>
                        <td class="px-6 py-4 text-right text-blue-600">
                            {{ number_format($rapport->sum('stock_actuel'), 2) }}
                        </td>
                        <td class="px-6 py-4 text-right text-blue-600">
                            {{ number_format($rapport->sum('valeur_stock'), 2) }} FC
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
