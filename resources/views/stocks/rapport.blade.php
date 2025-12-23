@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Rapport de Stock par Article</h1>
            <a href="{{ route('stocks.index') }}" 
               class="px-4 py-2 bg-gray-100 text-[#D4AF37] rounded-xl hover:bg-gray-200">
                Retour
            </a>
        </div>

        <!-- Filtres -->
        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-2">Filiale</label>
                <select name="filiale_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                    <option value="">Toutes</option>
                    @foreach($filiales as $filiale)
                        <option value="{{ $filiale->id }}" {{ request('filiale_id') == $filiale->id ? 'selected' : '' }}>
                            {{ $filiale->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-2">Agence</label>
                <select name="agence_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                    <option value="">Toutes</option>
                    @foreach($agences as $agence)
                        <option value="{{ $agence->id }}" {{ request('agence_id') == $agence->id ? 'selected' : '' }}>
                            {{ $agence->name }}
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
                            <span class="text-white font-semibold">
                                +{{ number_format($item->total_entrees, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-red-600 font-semibold">
                                -{{ number_format($item->total_sorties, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="font-semibold {{ $item->stock_actuel > 0 ? 'text-white' : 'text-red-600' }}">
                                {{ number_format($item->stock_actuel, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-white font-semibold">
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
                <tfoot class="bg-gray-50 border-t-2 border-neutral-700">
                    <tr class="font-bold">
                        <td class="px-6 py-4">TOTAL</td>
                        <td class="px-6 py-4 text-right text-white">
                            +{{ number_format($rapport->sum('total_entrees'), 2) }}
                        </td>
                        <td class="px-6 py-4 text-right text-red-600">
                            -{{ number_format($rapport->sum('total_sorties'), 2) }}
                        </td>
                        <td class="px-6 py-4 text-right text-white">
                            {{ number_format($rapport->sum('stock_actuel'), 2) }}
                        </td>
                        <td class="px-6 py-4 text-right text-white">
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
