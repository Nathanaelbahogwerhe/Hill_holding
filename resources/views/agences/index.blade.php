@extends('layouts.app')

@section('title', 'Agences')

@section('content')
<div class="max-w-6xl mx-auto bg-hh-card p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Liste des agences</h2>
        <a href="{{ route('agences.create') }}" class="btn btn-primary">Ajouter une agence</a>
    </div>

    <form method="GET" class="mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..." class="input input-bordered w-full">
    </form>

    <table class="table-auto w-full border border-gray-700">
        <thead>
            <tr class="bg-gray-800">
                <th class="px-4 py-2 text-left text-hh-gold">ID</th>
                <th class="px-4 py-2 text-left text-hh-gold">Nom</th>
                <th class="px-4 py-2 text-left text-hh-gold">Filiale</th>
                <th class="px-4 py-2 text-left text-hh-gold">Adresse</th>
                <th class="px-4 py-2 text-left text-hh-gold">TÃ©lÃ©phone</th>
                <th class="px-4 py-2 text-hh-gold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($agences as $agence)
            <tr class="border-t border-gray-700">
                <td class="px-4 py-2">{{ $agence->id }}</td>
                <td class="px-4 py-2">{{ $agence->name }}</td>
                <td class="px-4 py-2">{{ $agence->filiale->name ?? '-' }}</td>
                <td class="px-4 py-2">{{ $agence->address ?? '-' }}</td>
                <td class="px-4 py-2">{{ $agence->phone ?? '-' }}</td>
                <td class="px-4 py-2 space-x-2">
                    <a href="{{ route('agences.show', $agence) }}" class="btn btn-sm btn-secondary">Voir</a>
                    <a href="{{ route('agences.edit', $agence) }}" class="btn btn-sm btn-primary">Modifier</a>
                    <form action="{{ route('agences.destroy', $agence) }}" method="POST" class="inline-block" onsubmit="return confirm('Confirmer la suppression ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-error">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-2 text-center">Aucune agence trouvÃ©e.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $agences->links() }}
    </div>
</div>
@endsection







