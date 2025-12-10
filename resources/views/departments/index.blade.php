@extends('layouts.app')

@section('title', 'DÃ©partements')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- En-tÃªte + bouton Ajouter --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Liste des dÃ©partements</h2>
        <a href="{{ route('departments.create') }}" class="btn btn-primary">
            + Nouveau
        </a>
    </div>

    {{-- Barre de recherche --}}
    <form method="GET" action="{{ route('departments.index') }}" class="mb-4 flex gap-2">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Rechercher un dÃ©partement..."
            class="input input-bordered w-full"
        >
        <button type="submit" class="btn btn-secondary">
            Rechercher
        </button>
    </form>

    {{-- Table des dÃ©partements --}}
    <div class="overflow-x-auto bg-hh-card rounded shadow">
        <table class="table w-full">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-sm">
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Nom</th>
                    <th class="px-4 py-2 text-left">Filiale</th>
                    <th class="px-4 py-2 text-left">CrÃ©Ã© le</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($departments as $index => $department)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 font-medium">{{ $department->name }}</td>
                        <td class="px-4 py-2">
                            {{ $department->filiale ? $department->filiale->name : 'â€”' }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-500">
                            {{ $department->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-2 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-outline">
                                    Modifier
                                </a>

                                <form action="{{ route('departments.destroy', $department) }}" method="POST" onsubmit="return confirm('Confirmer la suppression de ce dÃ©partement ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error text-white">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                            Aucun dÃ©partement trouvÃ©.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($departments instanceof \Illuminate\Pagination\AbstractPaginator)
        <div class="mt-4">
            {{ $departments->links() }}
        </div>
    @endif
</div>
@endsection







