@extends('layouts.app')

@section('title', '💳 Transactions')

@section('content')
<div class="bg-hh-card dark:bg-hh-gray-dark rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">💳 Transactions</h2>
        <a href="{{ route('transactions.create') }}" class="px-4 py-2 bg-hh-primary text-white rounded hover:bg-hh-primary-dark">
            Nouvelle Transaction
        </a>
    </div>

    <table class="min-w-full text-sm text-left">
        <thead class="bg-hh-gray-light dark:bg-hh-gray-darker uppercase text-gray-700 dark:text-gray-200">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Référence</th>
                <th class="px-4 py-2">Type</th>
                <th class="px-4 py-2">Montant</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Utilisateur</th>
                <th class="px-4 py-2 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $tx)
            <tr class="border-b dark:border-hh-gray-darker hover:bg-gray-50 dark:hover:bg-hh-gray-darker/50">
                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 font-medium">{{ $tx->reference }}</td>
                <td class="px-4 py-2">
                    <span class="px-2 py-1 text-xs rounded font-medium
                        {{ $tx->type === 'expense' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        {{ ucfirst($tx->type) }}
                    </span>
                </td>
                <td class="px-4 py-2">{{ number_format($tx->amount, 2, ',', ' ') }}</td>
                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d/m/Y') }}</td>
                <td class="px-4 py-2">{{ $tx->user->name ?? '—' }}</td>
                <td class="px-4 py-2 text-right flex justify-end gap-2">
                    <a href="{{ route('transactions.show', $tx) }}" class="text-blue-500 hover:text-blue-700" title="Voir">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('transactions.edit', $tx) }}" class="text-yellow-500 hover:text-yellow-700" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('transactions.destroy', $tx) }}" method="POST" onsubmit="return confirm('Supprimer cette transaction ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700" title="Supprimer">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-gray-500">Aucune transaction enregistrée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection




