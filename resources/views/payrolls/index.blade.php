@extends('layouts.app')

@section('title', 'Gestion des Paies')

@section('content')
<div class="px-6 py-6">
    <!-- Header avec gradient -->
    <div class="mb-8">
        <h2 class="text-5xl font-bold mb-2 bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">
            💰 Gestion des Paies
        </h2>
        <p class="text-neutral-400">Gérez les salaires et paiements de vos employés</p>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Paies -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 rounded-xl">
                    <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-[#D4AF37] to-yellow-500 bg-clip-text text-transparent mb-2">
                {{ $payrolls->total() }}
            </div>
            <div class="text-neutral-400 text-sm">Total des paies</div>
        </div>

        <!-- Masse salariale mensuelle -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-green-500 to-green-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-green-400 to-green-500 bg-clip-text text-transparent mb-2">
                {{ number_format($payrolls->sum('net_salary'), 0, ',', ' ') }}
            </div>
            <div class="text-neutral-400 text-sm">Masse salariale (FBu)</div>
        </div>

        <!-- Paies ce mois -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-blue-500 bg-clip-text text-transparent mb-2">
                {{ $payrolls->filter(fn($p) => $p->payment_date?->format('Y-m') === now()->format('Y-m'))->count() }}
            </div>
            <div class="text-neutral-400 text-sm">Paies ce mois</div>
        </div>

        <!-- Employés payés -->
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-purple-500 bg-clip-text text-transparent mb-2">
                {{ $payrolls->unique('employee_id')->count() }}
            </div>
            <div class="text-neutral-400 text-sm">Employés payés</div>
        </div>
    </div>

    <!-- Filtres et Recherche -->
    <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl p-6 shadow-2xl mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Recherche -->
            <div>
                <label class="block text-[#D4AF37] font-semibold mb-2 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Rechercher
                </label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Nom employé..."
                       class="w-full px-4 py-2 bg-neutral-800 border border-neutral-700 rounded-xl text-white focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all">
            </div>

            <!-- Filiale -->
            <div>
                <label class="block text-[#D4AF37] font-semibold mb-2 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Filiale
                </label>
                <select name="filiale_id" 
                        class="w-full px-4 py-2 bg-neutral-800 border border-neutral-700 rounded-xl text-white focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all">
                    <option value="">Toutes</option>
                    @foreach(\App\Models\Filiale::all() as $filiale)
                        <option value="{{ $filiale->id }}" {{ request('filiale_id') == $filiale->id ? 'selected' : '' }}>
                            {{ $filiale->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Département -->
            <div>
                <label class="block text-[#D4AF37] font-semibold mb-2 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Département
                </label>
                <select name="department_id" 
                        class="w-full px-4 py-2 bg-neutral-800 border border-neutral-700 rounded-xl text-white focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all">
                    <option value="">Tous</option>
                    @foreach(\App\Models\Department::all() as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Mois -->
            <div>
                <label class="block text-[#D4AF37] font-semibold mb-2 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Mois
                </label>
                <input type="month" 
                       name="month" 
                       value="{{ request('month') }}" 
                       class="w-full px-4 py-2 bg-neutral-800 border border-neutral-700 rounded-xl text-white focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all">
            </div>

            <!-- Boutons d'action -->
            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="flex-1 px-6 py-2 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50">
                    🔍 Filtrer
                </button>
                <a href="{{ route('payrolls.index') }}" 
                   class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-semibold transition-all">
                    ↺
                </a>
            </div>
        </form>
    </div>

    <!-- Actions rapides -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex gap-3">
            <a href="{{ route('payrolls.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle Paie
            </a>
        </div>
        
        <div class="text-neutral-400 text-sm">
            {{ $payrolls->total() }} résultat(s)
        </div>
    </div>

    <!-- Message de succès -->
    @if (session('success'))
        <div class="bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500 text-green-300 p-4 rounded-xl mb-6 flex items-center gap-3 animate-fade-in">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Tableau des paies -->
    <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-[#D4AF37] to-yellow-500">
                        <th class="px-6 py-4 text-left text-sm font-bold text-black">Employé</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-black">Filiale</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-black">Agence</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-black">Département</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-black">Salaire Brut</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-black">Déductions</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-black">Salaire Net</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-black">Date</th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-black">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($payrolls as $payroll)
                        <tr class="hover:bg-neutral-800/50 transition-all duration-200 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#D4AF37] to-yellow-500 flex items-center justify-center text-black font-bold">
                                        {{ strtoupper(substr($payroll->employee?->first_name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-white">
                                            {{ $payroll->employee?->first_name }} {{ $payroll->employee?->last_name }}
                                        </div>
                                        <div class="text-xs text-neutral-400">
                                            {{ $payroll->employee?->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-gradient-to-r from-blue-900/50 to-blue-800/50 border border-blue-500/30 text-blue-300 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $payroll->employee?->filiale?->name ?? '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-gradient-to-r from-purple-900/50 to-purple-800/50 border border-purple-500/30 text-purple-300 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $payroll->employee?->agence?->name ?? '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-gradient-to-r from-[#D4AF37]/20 to-yellow-500/20 border border-[#D4AF37]/30 text-[#D4AF37] px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $payroll->employee?->department?->name ?? '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-blue-400 font-semibold">
                                    {{ number_format($payroll->gross_salary ?? 0, 0, ',', ' ') }} FBu
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-red-400 font-semibold">
                                    {{ number_format($payroll->total_deductions ?? 0, 0, ',', ' ') }} FBu
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-green-400 font-bold">
                                    {{ number_format($payroll->net_salary ?? 0, 0, ',', ' ') }} FBu
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-neutral-300">
                                    {{ $payroll->payment_date?->format('d/m/Y') ?? '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('payrolls.show', $payroll->id) }}" 
                                       class="p-2 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50"
                                       title="Voir">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('payrolls.edit', $payroll->id) }}" 
                                       class="p-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl transition-all"
                                       title="Modifier">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('payrolls.destroy', $payroll->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-all"
                                                title="Supprimer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-4">
                                    <svg class="w-16 h-16 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <div class="text-neutral-400">Aucune paie trouvée</div>
                                    <a href="{{ route('payrolls.create') }}" 
                                       class="px-4 py-2 bg-[#D4AF37] hover:bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 text-black rounded-xl font-semibold transition">
                                        + Créer la première paie
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($payrolls->hasPages())
            <div class="px-6 py-4 border-t border-neutral-800">
                {{ $payrolls->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
