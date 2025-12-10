@extends('layouts.app')

@section('title', 'Postes')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-semibold">Postes</h1>
    <a href="{{ route('positions.create') }}" class="btn btn-primary">Ajouter un poste</a>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-auto bg-hh-card rounded-lg shadow-sm">
    <table class="table-auto w-full text-left">
        <thead class="bg-hh-dark/50 text-hh-muted">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Nom du poste</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($positions as $pos)
                <tr class="border-b border-hh-border">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $pos->name }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('positions.edit', $pos) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('positions.destroy', $pos) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce poste ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-error">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-2 text-center text-hh-muted">Aucun poste trouvÃ©.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $positions->links() }}
</div>
@endsection







