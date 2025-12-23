@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Demandes d'Achat</h1>
        <a href="{{ route('purchase_requests.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Nouvelle Demande
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-neutral-400">Brouillon</p>
            <p class="text-2xl font-bold text-[#D4AF37]">{{ $stats['brouillon'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-neutral-400">Soumises</p>
            <p class="text-2xl font-bold text-white">{{ $stats['soumise'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-neutral-400">Approuvées</p>
            <p class="text-2xl font-bold text-white">{{ $stats['approuvee'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-neutral-400">Rejetées</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['rejetee'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-xl shadow mb-6 p-4">
        <form method="GET" action="{{ route('purchase_requests.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Filiale</label>
                <select name="filiale_id" class="form-select w-full">
                    <option value="">Toutes</option>
                    @foreach($filiales as $filiale)
                    <option value="{{ $filiale->id }}" {{ request('filiale_id') == $filiale->id ? 'selected' : '' }}>
                        {{ $filiale->nom }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Statut</label>
                <select name="statut" class="form-select w-full">
                    <option value="">Tous</option>
                    <option value="brouillon" {{ request('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                    <option value="soumise" {{ request('statut') == 'soumise' ? 'selected' : '' }}>Soumise</option>
                    <option value="approuvee" {{ request('statut') == 'approuvee' ? 'selected' : '' }}>Approuvée</option>
                    <option value="rejetee" {{ request('statut') == 'rejetee' ? 'selected' : '' }}>Rejetée</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Priorité</label>
                <select name="priorite" class="form-select w-full">
                    <option value="">Toutes</option>
                    <option value="basse" {{ request('priorite') == 'basse' ? 'selected' : '' }}>Basse</option>
                    <option value="moyenne" {{ request('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                    <option value="haute" {{ request('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                    <option value="urgente" {{ request('priorite') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary mr-2">Filtrer</button>
                <a href="{{ route('purchase_requests.index') }}" class="btn-secondary">Réinitialiser</a>
            </div>
        </form>
    </div>

    {{-- Liste --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Filiale</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Demandeur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Objet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant Estimé</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priorité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($purchaseRequests as $request)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('purchase_requests.show', $request) }}" class="text-white hover:underline">
                            {{ $request->numero }}
                        </a>
                    </td>
                    <td class="px-6 py-4">{{ $request->filiale->nom }}</td>
                    <td class="px-6 py-4">{{ $request->demandeur->name }}</td>
                    <td class="px-6 py-4">{{ Str::limit($request->objet, 40) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($request->montant_estime, 0, ',', ' ') }} FCFA</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded {{ $request->priorite_color }}">
                            {{ ucfirst($request->priorite) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($request->statut === 'brouillon') bg-gray-100 text-gray-800
                            @elseif($request->statut === 'soumise') bg-gradient-to-r from-blue-900/50 to-blue-800/50 border border-blue-500/30 text-blue-300
                            @elseif($request->statut === 'approuvee') bg-gradient-to-r from-green-900/50 to-green-800/50 border border-green-500/30 text-green-300
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($request->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $request->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('purchase_requests.show', $request) }}" class="text-white hover:underline mr-3">Voir</a>
                        @if($request->statut === 'brouillon')
                        <form action="{{ route('purchase_requests.destroy', $request) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">Aucune demande trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $purchaseRequests->links() }}
    </div>
</div>
@endsection
