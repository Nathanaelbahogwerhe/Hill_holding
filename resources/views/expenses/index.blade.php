@extends('layouts.app')

@section('title', 'DÃ©penses')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-hh-gold">ðŸ“‰ DÃ©penses</h2>

        <a href="{{ route('expenses.create') }}" class="hh-btn-primary">
            + Nouvelle DÃ©pense
        </a>
    </div>

    <div class="bg-hh-card rounded-xl shadow border border-hh-border p-4 overflow-x-auto">
        <table class="w-full table-auto hh-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Filiale</th>
                    <th>Agence</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($expenses as $expense)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $expense->title }}</td>
                        <td class="text-red-400 font-semibold">
                            - {{ number_format($expense->amount, 2) }} Fbu
                        </td>
                        <td>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</td>
                        <td>{{ $expense->filiale->name ?? 'â€”' }}</td>
                        <td>{{ $expense->agence->name ?? 'â€”' }}</td>

                        <td class="text-right space-x-3">
                            <a href="{{ route('expenses.show', $expense) }}" class="text-blue-400 hover:text-blue-300">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('expenses.edit', $expense) }}" class="text-yellow-400 hover:text-yellow-300">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Supprimer cette dÃ©pense ?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-300">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-400">Aucune dÃ©pense enregistrÃ©e.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection







