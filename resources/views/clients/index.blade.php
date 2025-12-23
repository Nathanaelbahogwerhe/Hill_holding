@extends('layouts.app')

@section('title', 'Liste des Clients')

@section('content')
<div class="p-6">

    <!-- ðŸ”¹ Résumé des clients -->
    <div class="grid grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-gray-500 text-sm">Total Clients</h2>
            <p class="text-2xl font-semibold text-gray-800">{{ $summary['total_clients'] }}</p>
        </div>
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-gray-500 text-sm">Total Due</h2>
            <p class="text-2xl font-semibold text-gray-800">{{ number_format($summary['total_due'], 2) }}</p>
        </div>
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-gray-500 text-sm">Total Paid</h2>
            <p class="text-2xl font-semibold text-gray-800">{{ number_format($summary['total_paid'], 2) }}</p>
        </div>
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-gray-500 text-sm">Total Balance</h2>
            <p class="text-2xl font-semibold text-gray-800">{{ number_format($summary['total_balance'], 2) }}</p>
        </div>
    </div>

    <!-- ðŸ”¹ Entàªte et bouton Nouveau client -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold text-gray-800">Liste des Clients</h1>
        <a href="{{ route('clients.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 flex items-center">
           <i class="fa fa-user-plus text-yellow-500 mr-2"></i> Nouveau client
        </a>
    </div>

    <!-- ðŸ”¹ Tableau des clients -->
    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-neutral-400">#</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-neutral-400">Nom</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-neutral-400">Email</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-neutral-400">Téléphone</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-neutral-400">Total Due</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-neutral-400">Balance</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-neutral-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $loop->iteration + ($clients->currentPage() - 1) * $clients->perPage() }}</td>
                    <td class="px-4 py-3">{{ $client->name }}</td>
                    <td class="px-4 py-3">{{ $client->email }}</td>
                    <td class="px-4 py-3">{{ $client->phone }}</td>
                    <td class="px-4 py-3">{{ number_format($client->total_due, 2) }}</td>
                    <td class="px-4 py-3">{{ number_format($client->balance, 2) }}</td>
                    <td class="px-4 py-3 flex space-x-3">
                        <a href="{{ route('clients.show', $client->id) }}" class="text-white hover:text-blue-800">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('clients.edit', $client->id) }}" class="text-yellow-500 hover:text-yellow-700">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Supprimer ce client ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-3 text-center text-gray-500">Aucun client trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- ðŸ”¹ Pagination -->
        <div class="p-4">
            {{ $clients->links() }}
        </div>
    </div>
</div>
@endsection



