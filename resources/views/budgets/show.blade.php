@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    
    {{-- En-tête --}}
    <div class="bg-black border border-yellow-600 rounded-xl p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h1 class="text-3xl font-bold text-yellow-500">{{ $budget->title }}</h1>
                @if($budget->category)
                <p class="text-gray-400 mt-1">📁 Catégorie: <span class="text-white">{{ $budget->category }}</span></p>
                @endif
            </div>
            
            {{-- Statut Badge --}}
            <div>
                @if($budget->budget_status === 'exceeded')
                    <span class="px-4 py-2 bg-red-900 text-red-300 rounded-xl text-sm font-semibold">⚠️ Budget Dépassé</span>
                @elseif($budget->budget_status === 'warning')
                    <span class="px-4 py-2 bg-orange-900 text-orange-300 rounded-xl text-sm font-semibold">⚡ Alerte Budgétaire</span>
                @elseif($budget->budget_status === 'active')
                    <span class="px-4 py-2 bg-green-900 text-green-300 rounded-xl text-sm font-semibold">✓ Budget Actif</span>
                @else
                    <span class="px-4 py-2 bg-gray-800 text-gray-400 rounded-xl text-sm">○ Non Utilisé</span>
                @endif
            </div>
        </div>

        {{-- Description --}}
        @if($budget->description)
        <p class="text-neutral-300 mb-4">{{ $budget->description }}</p>
        @endif

        {{-- Dates --}}
        <div class="flex gap-6 text-sm text-gray-400">
            <div>
                <span class="text-yellow-400">📅 Début:</span> 
                {{ $budget->start_date->format('d/m/Y') }}
            </div>
            <div>
                <span class="text-yellow-400">📅 Fin:</span> 
                {{ $budget->end_date->format('d/m/Y') }}
            </div>
            <div>
                <span class="text-yellow-400">⏱️ Durée:</span> 
                {{ $budget->start_date->diffInDays($budget->end_date) }} jours
            </div>
        </div>
    </div>

    {{-- Statistiques principales --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        
        {{-- Budget Total --}}
        <div class="bg-gradient-to-br from-yellow-600 to-yellow-800 rounded-xl p-6 text-white">
            <div class="text-sm opacity-90 mb-2">💰 Budget Total</div>
            <div class="text-3xl font-bold">{{ number_format($budget->amount, 0, ',', ' ') }}</div>
            <div class="text-sm mt-1">FBu</div>
        </div>

        {{-- Montant Utilisé --}}
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-6 text-white">
            <div class="text-sm opacity-90 mb-2">📊 Utilisé</div>
            <div class="text-3xl font-bold">{{ number_format($budget->amount_used, 0, ',', ' ') }}</div>
            <div class="text-sm mt-1">FBu ({{ number_format($budget->percentage_used, 1) }}%)</div>
        </div>

        {{-- Montant Restant --}}
        <div class="bg-gradient-to-br 
            @if($budget->amount_remaining >= 0) from-green-600 to-green-800 
            @else from-red-600 to-red-800 
            @endif rounded-xl p-6 text-white">
            <div class="text-sm opacity-90 mb-2">
                @if($budget->amount_remaining >= 0) ✓ Disponible @else ⚠️ Dépassement @endif
            </div>
            <div class="text-3xl font-bold">{{ number_format(abs($budget->amount_remaining), 0, ',', ' ') }}</div>
            <div class="text-sm mt-1">FBu</div>
        </div>
    </div>

    {{-- Barre de progression --}}
    <div class="bg-black border border-yellow-600 rounded-xl p-6 mb-6">
        <h3 class="text-xl font-semibold text-yellow-500 mb-4">📈 Progression du Budget</h3>
        
        <div class="mb-4">
            <div class="flex justify-between text-sm text-gray-400 mb-2">
                <span>Utilisation</span>
                <span class="font-semibold 
                    @if($budget->percentage_used >= 100) text-red-400
                    @elseif($budget->percentage_used >= 80) text-orange-400
                    @else text-green-400
                    @endif">
                    {{ number_format($budget->percentage_used, 2) }}%
                </span>
            </div>
            
            <div class="w-full bg-gray-700 rounded-full h-6 overflow-hidden relative">
                <div class="h-6 rounded-full transition-all duration-500 flex items-center justify-end pr-2
                    @if($budget->percentage_used >= 100) bg-gradient-to-r from-red-600 to-red-500
                    @elseif($budget->percentage_used >= 80) bg-gradient-to-r from-orange-600 to-orange-500
                    @elseif($budget->percentage_used > 0) bg-gradient-to-r from-green-600 to-green-500
                    @else bg-gray-500
                    @endif"
                    style="width: {{ min($budget->percentage_used, 100) }}%">
                    @if($budget->percentage_used > 5)
                    <span class="text-white text-xs font-bold">{{ number_format($budget->percentage_used, 1) }}%</span>
                    @endif
                </div>
                
                {{-- Marqueur 80% --}}
                @if($budget->percentage_used < 80)
                <div class="absolute top-0 left-[80%] h-full w-0.5 bg-orange-400 opacity-50"></div>
                @endif
            </div>
            
            <div class="flex justify-between text-xs text-gray-500 mt-2">
                <span>0 FBu</span>
                <span class="text-orange-400">⚡ 80%</span>
                <span>{{ number_format($budget->amount, 0, ',', ' ') }} FBu</span>
            </div>
        </div>

        {{-- Messages d'alerte --}}
        @if($budget->isOverBudget())
        <div class="bg-red-900/30 border border-red-600 rounded-xl p-4 mt-4">
            <div class="flex items-center gap-2 text-red-300">
                <span class="text-2xl">⚠️</span>
                <div>
                    <div class="font-semibold">Budget Dépassé !</div>
                    <div class="text-sm">Le montant utilisé excède le budget alloué de {{ number_format($budget->amount_used - $budget->amount, 0, ',', ' ') }} FBu</div>
                </div>
            </div>
        </div>
        @elseif($budget->isNearLimit())
        <div class="bg-orange-900/30 border border-orange-600 rounded-xl p-4 mt-4">
            <div class="flex items-center gap-2 text-orange-300">
                <span class="text-2xl">⚡</span>
                <div>
                    <div class="font-semibold">Alerte Budgétaire</div>
                    <div class="text-sm">Plus de 80% du budget a été utilisé. Il reste {{ number_format($budget->amount_remaining, 0, ',', ' ') }} FBu disponibles</div>
                </div>
            </div>
        </div>
        @elseif($budget->percentage_used > 0)
        <div class="bg-green-900/30 border border-green-600 rounded-xl p-4 mt-4">
            <div class="flex items-center gap-2 text-green-300">
                <span class="text-2xl">✓</span>
                <div>
                    <div class="font-semibold">Budget Sous Contrôle</div>
                    <div class="text-sm">{{ number_format($budget->amount_remaining, 0, ',', ' ') }} FBu encore disponibles</div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Informations hiérarchiques --}}
    <div class="bg-black border border-yellow-600 rounded-xl p-6 mb-6">
        <h3 class="text-xl font-semibold text-yellow-500 mb-4">🏢 Périmètre</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="text-sm text-gray-400">Filiale</div>
                <div class="text-white font-semibold">{{ $budget->filiale->name ?? 'Maison Mère' }}</div>
            </div>
            
            <div>
                <div class="text-sm text-gray-400">Agence</div>
                <div class="text-white font-semibold">{{ $budget->agence->name ?? 'Toutes les agences' }}</div>
            </div>
            
            @if($budget->status)
            <div>
                <div class="text-sm text-gray-400">Statut</div>
                <div class="text-white font-semibold">
                    @if($budget->status === 'active')
                        <span class="text-green-400">✓ Actif</span>
                    @else
                        <span class="text-gray-400">○ Inactif</span>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Document joint --}}
    @if($budget->attachment)
    <div class="bg-black border border-yellow-600 rounded-xl p-6 mb-6">
        <h3 class="text-xl font-semibold text-yellow-500 mb-4">📎 Document Joint</h3>
        <a href="{{ Storage::url($budget->attachment) }}" target="_blank" 
           class="inline-flex items-center gap-2 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold text-white px-4 py-2 rounded-xl transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Télécharger le document
        </a>
    </div>
    @endif

    {{-- Actions --}}
    <div class="flex justify-between items-center">
        <a href="{{ route('budgets.index') }}" 
           class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-xl transition">
            ← Retour à la liste
        </a>
        
        <div class="flex gap-3">
            @can('update', $budget)
            <a href="{{ route('budgets.edit', $budget) }}" 
               class="bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 hover:bg-yellow-600 text-black font-semibold px-6 py-2 rounded-xl transition">
                ✏️ Modifier
            </a>
            @endcan
            
            @can('delete', $budget)
            <form method="POST" action="{{ route('budgets.destroy', $budget) }}" class="inline">
                @csrf @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce budget ?')"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl transition">
                    🗑️ Supprimer
                </button>
            </form>
            @endcan
        </div>
    </div>

</div>
@endsection
