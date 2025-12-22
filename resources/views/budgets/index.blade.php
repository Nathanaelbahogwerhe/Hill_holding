@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 text-white">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-yellow-500">💰 Budgets</h1>
            <p class="text-gray-400 text-sm">
                Budgets par maison mère, filiale et agence
            </p>
        </div>

        {{-- Créer --}}
        @if(auth()->user()->hasRole('superadmin') || auth()->user()->filiale_id)
        <a href="{{ route('budgets.create') }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-5 py-2 rounded-lg shadow">
            ➕ Nouveau budget
        </a>
        @endif
    </div>

    {{-- Filtres --}}
    <form method="GET" class="bg-gray-900 border border-yellow-600 rounded-xl p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">

        {{-- Filiale --}}
        @if(auth()->user()->hasRole('superadmin'))
        <div>
            <label class="text-sm text-yellow-400">Filiale</label>
            <select name="filiale_id" class="w-full bg-black border border-gray-700 rounded px-3 py-2">
                <option value="">Toutes</option>
                @foreach($filiales as $filiale)
                    <option value="{{ $filiale->id }}" @selected(request('filiale_id') == $filiale->id)>
                        {{ $filiale->name }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        {{-- Agence --}}
        <div>
            <label class="text-sm text-yellow-400">Agence</label>
            <select name="agence_id" class="w-full bg-black border border-gray-700 rounded px-3 py-2">
                <option value="">Toutes</option>
                @foreach($agences as $agence)
                    <option value="{{ $agence->id }}" @selected(request('agence_id') == $agence->id)>
                        {{ $agence->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Projet --}}
        <div>
            <label class="text-sm text-yellow-400">Projet</label>
            <select name="project_id" class="w-full bg-black border border-gray-700 rounded px-3 py-2">
                <option value="">Tous</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" @selected(request('project_id') == $project->id)>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Bouton --}}
        <div class="flex items-end">
            <button class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-4 py-2 rounded w-full">
                🔍 Filtrer
            </button>
        </div>
    </form>

    {{-- Tableau --}}
    <div class="bg-black border border-yellow-600 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-900 text-yellow-400">
                <tr>
                    <th class="px-4 py-3 text-left">Titre / Catégorie</th>
                    <th class="px-4 py-3">Filiale</th>
                    <th class="px-4 py-3">Agence</th>
                    <th class="px-4 py-3 text-right">Budget</th>
                    <th class="px-4 py-3 text-left">Utilisation</th>
                    <th class="px-4 py-3 text-center">Statut</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($budgets as $budget)
                <tr class="border-t border-gray-800 hover:bg-gray-900">
                    <td class="px-4 py-3">
                        <div class="font-semibold">{{ $budget->title }}</div>
                        @if($budget->category)
                        <div class="text-xs text-gray-400">📁 {{ $budget->category }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $budget->filiale->name ?? 'Maison mère' }}</td>
                    <td class="px-4 py-3">{{ $budget->agence->name ?? 'Toutes' }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="font-semibold text-yellow-500">
                            {{ number_format($budget->amount, 0, ',', ' ') }} FBu
                        </div>
                        <div class="text-xs text-gray-400">
                            Utilisé: {{ number_format($budget->amount_used, 0, ',', ' ') }} FBu
                        </div>
                        <div class="text-xs @if($budget->amount_remaining >= 0) text-green-400 @else text-red-400 @endif">
                            Reste: {{ number_format($budget->amount_remaining, 0, ',', ' ') }} FBu
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="flex-1">
                                <div class="w-full bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                    <div class="h-2.5 rounded-full transition-all
                                        @if($budget->percentage_used >= 100) bg-red-500
                                        @elseif($budget->percentage_used >= 80) bg-orange-500
                                        @elseif($budget->percentage_used > 0) bg-green-500
                                        @else bg-gray-500
                                        @endif"
                                        style="width: {{ min($budget->percentage_used, 100) }}%">
                                    </div>
                                </div>
                            </div>
                            <span class="text-xs font-semibold
                                @if($budget->percentage_used >= 100) text-red-400
                                @elseif($budget->percentage_used >= 80) text-orange-400
                                @else text-gray-400
                                @endif">
                                {{ number_format($budget->percentage_used, 1) }}%
                            </span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($budget->budget_status === 'exceeded')
                            <span class="px-2 py-1 bg-red-900 text-red-300 rounded text-xs font-semibold">⚠️ Dépassé</span>
                        @elseif($budget->budget_status === 'warning')
                            <span class="px-2 py-1 bg-orange-900 text-orange-300 rounded text-xs font-semibold">⚡ Alerte</span>
                        @elseif($budget->budget_status === 'active')
                            <span class="px-2 py-1 bg-green-900 text-green-300 rounded text-xs font-semibold">✓ Actif</span>
                        @else
                            <span class="px-2 py-1 bg-gray-800 text-gray-400 rounded text-xs">○ Non utilisé</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('budgets.show', $budget) }}" class="text-blue-400 hover:underline text-xs">
                            Voir
                        </a>
                        <a href="{{ route('budgets.edit', $budget) }}" class="text-yellow-400 hover:underline text-xs">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('budgets.destroy', $budget) }}" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Supprimer ce budget ?')"
                                    class="text-red-500 hover:underline text-xs">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">
                        Aucun budget trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
