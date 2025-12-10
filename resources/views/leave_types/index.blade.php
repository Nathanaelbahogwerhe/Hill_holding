@extends('layouts.app')
@section('title', 'Types de congÃ©s')

@section('content')
<div class="max-w-7xl mx-auto bg-hh-card p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-semibold">Gestion des types de congÃ©s</h1>
        <a href="{{ route('leave_types.create') }}" class="btn btn-primary flex items-center space-x-2">
            <span>Nouveau type</span>
        </a>
    </div>

    <table class="w-full table-auto border border-gray-700 rounded shadow">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-4 py-2 text-left text-hh-gold">Nom</th>
                <th class="px-4 py-2 text-left text-hh-gold">Nombre de jours</th>
                <th class="px-4 py-2 text-hh-gold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaveTypes as $type)
            <tr class="border-t border-gray-700">
                <td class="px-4 py-2">{{ $type->name }}</td>
                <td class="px-4 py-2">{{ $type->days }}</td>
                <td class="px-4 py-2 space-x-2">
                    <a href="{{ route('leave_types.show', $type) }}" class="text-blue-600 hover:underline">Voir</a>
                    <a href="{{ route('leave_types.edit', $type) }}" class="text-green-600 hover:underline">Ã‰diter</a>
                    <form action="{{ route('leave_types.destroy', $type) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer ce type de congÃ© ?')" class="text-red-600 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-4 py-2 text-center text-gray-400">Aucun type trouvÃ©.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $leaveTypes->links() }}
    </div>
</div>
@endsection







