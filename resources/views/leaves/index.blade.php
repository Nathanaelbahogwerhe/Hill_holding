@extends('layouts.app')
@section('title', 'Congés')

@section('content')
<div class="max-w-7xl mx-auto bg-hh-card p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-semibold">Gestion des congés</h1>
        <a href="{{ route('leaves.create') }}" class="btn btn-primary flex items-center space-x-2">
            <span>Nouvelle demande</span>
        </a>
    </div>

    <table class="w-full table-auto border border-gray-700 rounded shadow">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-4 py-2 text-left text-hh-gold">Employé</th>
                <th class="px-4 py-2 text-left text-hh-gold">Type de congé</th>
                <th class="px-4 py-2 text-left text-hh-gold">Date début</th>
                <th class="px-4 py-2 text-left text-hh-gold">Date fin</th>
                <th class="px-4 py-2 text-left text-hh-gold">Jours</th>
                <th class="px-4 py-2 text-left text-hh-gold">Statut</th>
                <th class="px-4 py-2 text-left text-hh-gold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaves as $leave)
            <tr class="border-t border-gray-700">
                <td class="px-4 py-2">{{ $leave->employee?->name ?? '-' }}</td>
                <td class="px-4 py-2">{{ $leave->type?->name ?? '-' }}</td>
                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($leave->start_date)->translatedFormat('d F Y') }}</td>
                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($leave->end_date)->translatedFormat('d F Y') }}</td>
                <td class="px-4 py-2">{{ $leave->days }}</td>
                <td class="px-4 py-2">
                    @php
                        $statusColors = ['pending' => 'bg-yellow-600', 'approved' => 'bg-green-600', 'rejected' => 'bg-red-600'];
                    @endphp
                    <span class="px-2 py-1 rounded text-white {{ $statusColors[$leave->status] ?? 'bg-gray-500' }}">
                        {{ ucfirst($leave->status) }}
                    </span>
                </td>
                <td class="px-4 py-2 space-x-2">
                    <a href="{{ route('leaves.show', $leave) }}" class="text-blue-600 hover:underline">Voir</a>
                    <a href="{{ route('leaves.edit', $leave) }}" class="text-green-600 hover:underline">Éditer</a>
                    <form action="{{ route('leaves.destroy', $leave) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer ce congé ?')" class="text-red-600 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-2 text-center text-gray-400">Aucun congé trouvé.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{-- {{ $leaves->links() }} --}}
    </div>
</div>
@endsection







