@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- En-tête --}}
    <div class="mb-6">
        <h1 class="text-4xl font-bold text-yellow-500">📊 Rapports Financiers</h1>
        <p class="text-gray-400 mt-2">
            Vue d'ensemble des budgets, dépenses, revenus et transactions
        </p>
    </div>

    {{-- Filtres --}}
    <form method="GET" class="bg-black border border-yellow-600 rounded-xl p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            @if(auth()->user()->hasRole('Super Admin'))
            <div>
                <label class="text-sm text-yellow-400 mb-1 block">Filiale</label>
                <select name="filiale_id" class="w-full bg-gray-900 border border-gray-700 rounded px-3 py-2 text-white">
                    <option value="">Toutes</option>
                    @foreach($filiales as $filiale)
                        <option value="{{ $filiale->id }}" @selected(request('filiale_id') == $filiale->id)>
                            {{ $filiale->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div>
                <label class="text-sm text-yellow-400 mb-1 block">Agence</label>
                <select name="agence_id" class="w-full bg-gray-900 border border-gray-700 rounded px-3 py-2 text-white">
                    <option value="">Toutes</option>
                    @foreach($agences as $agence)
                        <option value="{{ $agence->id }}" @selected(request('agence_id') == $agence->id)>
                            {{ $agence->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-yellow-400 mb-1 block">Date début</label>
                <input type="date" name="start_date" value="{{ $start_date }}"
                       class="w-full bg-gray-900 border border-gray-700 rounded px-3 py-2 text-white">
            </div>

            <div>
                <label class="text-sm text-yellow-400 mb-1 block">Date fin</label>
                <input type="date" name="end_date" value="{{ $end_date }}"
                       class="w-full bg-gray-900 border border-gray-700 rounded px-3 py-2 text-white">
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 hover:bg-yellow-600 text-black font-semibold px-6 py-2 rounded-xl transition">
                🔍 Filtrer
            </button>
        </div>
    </form>

    {{-- Statistiques Globales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        
        {{-- Budgets --}}
        <div class="bg-gradient-to-br from-yellow-600 to-yellow-800 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="text-sm opacity-90">💰 Budgets Total</div>
                @if($budgetStats['status'] === 'exceeded')
                    <span class="text-2xl">⚠️</span>
                @elseif($budgetStats['status'] === 'warning')
                    <span class="text-2xl">⚡</span>
                @else
                    <span class="text-2xl">✓</span>
                @endif
            </div>
            <div class="text-3xl font-bold mb-1">{{ number_format($totalBudget, 0, ',', ' ') }}</div>
            <div class="text-sm opacity-90">FBu</div>
            <div class="mt-3 pt-3 border-t border-white/20">
                <div class="text-xs">Utilisé: {{ number_format($budgetStats['used'], 0, ',', ' ') }} FBu</div>
                <div class="text-xs">{{ number_format($budgetStats['percentage'], 1) }}%</div>
            </div>
        </div>

        {{-- Dépenses --}}
        <div class="bg-gradient-to-br from-red-600 to-red-800 rounded-xl p-6 text-white">
            <div class="text-sm opacity-90 mb-3">📤 Dépenses</div>
            <div class="text-3xl font-bold mb-1">{{ number_format($totalExpenses, 0, ',', ' ') }}</div>
            <div class="text-sm opacity-90">FBu</div>
            <div class="mt-3 pt-3 border-t border-white/20">
                <div class="text-xs">{{ $expensesData->count() }} transactions</div>
            </div>
        </div>

        {{-- Revenus --}}
        <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-xl p-6 text-white">
            <div class="text-sm opacity-90 mb-3">📥 Revenus</div>
            <div class="text-3xl font-bold mb-1">{{ number_format($totalRevenues, 0, ',', ' ') }}</div>
            <div class="text-sm opacity-90">FBu</div>
            <div class="mt-3 pt-3 border-t border-white/20">
                <div class="text-xs">{{ $revenuesData->count() }} transactions</div>
            </div>
        </div>

        {{-- Balance --}}
        <div class="bg-gradient-to-br 
            @if($balance >= 0) from-blue-600 to-blue-800 
            @else from-red-600 to-red-800 
            @endif rounded-xl p-6 text-white">
            <div class="text-sm opacity-90 mb-3">
                @if($balance >= 0) ✓ Balance @else ⚠️ Déficit @endif
            </div>
            <div class="text-3xl font-bold mb-1">{{ number_format(abs($balance), 0, ',', ' ') }}</div>
            <div class="text-sm opacity-90">FBu</div>
        </div>
    </div>

    {{-- Alertes Budgétaires --}}
    @if($budgetStats['overBudget'] > 0 || $budgetStats['nearLimit'] > 0)
    <div class="bg-black border border-yellow-600 rounded-xl p-6 mb-6">
        <h3 class="text-xl font-semibold text-yellow-500 mb-4">⚠️ Alertes Budgétaires</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if($budgetStats['overBudget'] > 0)
            <div class="bg-red-900/30 border border-red-600 rounded-xl p-4">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">⚠️</span>
                    <div>
                        <div class="font-semibold text-red-300">{{ $budgetStats['overBudget'] }} Budget(s) Dépassé(s)</div>
                        <div class="text-sm text-red-400">Action immédiate requise</div>
                    </div>
                </div>
            </div>
            @endif

            @if($budgetStats['nearLimit'] > 0)
            <div class="bg-orange-900/30 border border-orange-600 rounded-xl p-4">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">⚡</span>
                    <div>
                        <div class="font-semibold text-orange-300">{{ $budgetStats['nearLimit'] }} Budget(s) en Alerte</div>
                        <div class="text-sm text-orange-400">Plus de 80% utilisé</div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Statistiques par Filiale --}}
    @if(auth()->user()->hasRole('Super Admin') && count($statsByFiliale) > 0)
    <div class="bg-black border border-yellow-600 rounded-xl p-6 mb-6">
        <h3 class="text-xl font-semibold text-yellow-500 mb-4">🏢 Statistiques par Filiale</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-900 text-yellow-400">
                    <tr>
                        <th class="px-4 py-3 text-left">Filiale</th>
                        <th class="px-4 py-3 text-right">Budget Total</th>
                        <th class="px-4 py-3 text-right">Budget Utilisé</th>
                        <th class="px-4 py-3 text-right">Dépenses</th>
                        <th class="px-4 py-3 text-right">Revenus</th>
                        <th class="px-4 py-3 text-right">Balance</th>
                    </tr>
                </thead>
                <tbody class="text-white">
                    @foreach($statsByFiliale as $stats)
                    <tr class="border-t border-gray-800 hover:bg-gray-900">
                        <td class="px-4 py-3 font-semibold">{{ $stats['name'] }}</td>
                        <td class="px-4 py-3 text-right">{{ number_format($stats['budgets'], 0, ',', ' ') }} FBu</td>
                        <td class="px-4 py-3 text-right">
                            <span class="@if($stats['budgets'] > 0 && ($stats['budgets_used'] / $stats['budgets'] * 100) >= 80) text-orange-400 @endif">
                                {{ number_format($stats['budgets_used'], 0, ',', ' ') }} FBu
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right text-red-400">{{ number_format($stats['expenses'], 0, ',', ' ') }} FBu</td>
                        <td class="px-4 py-3 text-right text-green-400">{{ number_format($stats['revenues'], 0, ',', ' ') }} FBu</td>
                        <td class="px-4 py-3 text-right font-semibold @if($stats['balance'] >= 0) text-blue-400 @else text-red-400 @endif">
                            {{ number_format($stats['balance'], 0, ',', ' ') }} FBu
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Statistiques par Agence --}}
    @if(count($statsByAgence) > 0)
    <div class="bg-black border border-yellow-600 rounded-xl p-6 mb-6">
        <h3 class="text-xl font-semibold text-yellow-500 mb-4">🏪 Statistiques par Agence</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-900 text-yellow-400">
                    <tr>
                        <th class="px-4 py-3 text-left">Agence</th>
                        <th class="px-4 py-3 text-left">Filiale</th>
                        <th class="px-4 py-3 text-right">Budget Total</th>
                        <th class="px-4 py-3 text-right">Budget Utilisé</th>
                        <th class="px-4 py-3 text-right">Dépenses</th>
                        <th class="px-4 py-3 text-right">Revenus</th>
                        <th class="px-4 py-3 text-right">Balance</th>
                    </tr>
                </thead>
                <tbody class="text-white">
                    @foreach($statsByAgence as $stats)
                    <tr class="border-t border-gray-800 hover:bg-gray-900">
                        <td class="px-4 py-3 font-semibold">{{ $stats['name'] }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $stats['filiale'] }}</td>
                        <td class="px-4 py-3 text-right">{{ number_format($stats['budgets'], 0, ',', ' ') }} FBu</td>
                        <td class="px-4 py-3 text-right">
                            <span class="@if($stats['budgets'] > 0 && ($stats['budgets_used'] / $stats['budgets'] * 100) >= 80) text-orange-400 @endif">
                                {{ number_format($stats['budgets_used'], 0, ',', ' ') }} FBu
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right text-red-400">{{ number_format($stats['expenses'], 0, ',', ' ') }} FBu</td>
                        <td class="px-4 py-3 text-right text-green-400">{{ number_format($stats['revenues'], 0, ',', ' ') }} FBu</td>
                        <td class="px-4 py-3 text-right font-semibold @if($stats['balance'] >= 0) text-blue-400 @else text-red-400 @endif">
                            {{ number_format($stats['balance'], 0, ',', ' ') }} FBu
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Budgets avec alertes --}}
    @php
        $alertBudgets = $budgetsData->filter(fn($b) => $b->percentage_used >= 80)->sortByDesc('percentage_used');
    @endphp

    @if($alertBudgets->count() > 0)
    <div class="bg-black border border-yellow-600 rounded-xl p-6">
        <h3 class="text-xl font-semibold text-yellow-500 mb-4">🎯 Budgets Nécessitant une Attention</h3>
        
        <div class="space-y-3">
            @foreach($alertBudgets as $budget)
            <div class="bg-gray-900 rounded-xl p-4 
                @if($budget->isOverBudget()) border-l-4 border-red-500
                @else border-l-4 border-orange-500
                @endif">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-semibold text-white">{{ $budget->title }}</div>
                        <div class="text-sm text-gray-400">
                            {{ $budget->category }} - {{ $budget->filiale->name ?? 'N/A' }}
                            @if($budget->agence)
                                / {{ $budget->agence->name }}
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        @if($budget->isOverBudget())
                            <span class="px-3 py-1 bg-red-900 text-red-300 rounded text-xs font-semibold">⚠️ Dépassé</span>
                        @else
                            <span class="px-3 py-1 bg-orange-900 text-orange-300 rounded text-xs font-semibold">⚡ Alerte</span>
                        @endif
                    </div>
                </div>
                
                <div class="mt-3 flex items-center gap-3">
                    <div class="flex-1">
                        <div class="w-full bg-gray-700 rounded-full h-2 overflow-hidden">
                            <div class="h-2 rounded-full 
                                @if($budget->percentage_used >= 100) bg-red-500
                                @else bg-orange-500
                                @endif"
                                style="width: {{ min($budget->percentage_used, 100) }}%">
                            </div>
                        </div>
                    </div>
                    <div class="text-sm font-semibold 
                        @if($budget->percentage_used >= 100) text-red-400
                        @else text-orange-400
                        @endif">
                        {{ number_format($budget->percentage_used, 1) }}%
                    </div>
                </div>

                <div class="mt-2 text-xs text-gray-400">
                    Budget: {{ number_format($budget->amount, 0, ',', ' ') }} FBu | 
                    Utilisé: {{ number_format($budget->amount_used, 0, ',', ' ') }} FBu |
                    @if($budget->amount_remaining >= 0)
                        Reste: {{ number_format($budget->amount_remaining, 0, ',', ' ') }} FBu
                    @else
                        Dépassement: {{ number_format(abs($budget->amount_remaining), 0, ',', ' ') }} FBu
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
