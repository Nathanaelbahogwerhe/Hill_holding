@extends('layouts.app')

@section('title', 'DÃ©tails DÃ©pense')

@section('content')
<div class="max-w-3xl mx-auto py-6">

    <div class="bg-hh-card p-6 rounded-xl shadow border border-hh-border">
        <h2 class="text-xl font-semibold text-hh-gold mb-4">ðŸ“„ DÃ©tails de la DÃ©pense</h2>

        <div class="space-y-4 text-sm text-gray-300">

            <div class="detail-row">
                <span class="label">Titre :</span>
                <span>{{ $expense->title }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Montant :</span>
                <span class="text-red-400 font-bold">- {{ number_format($expense->amount,2) }} Fbu</span>
            </div>

            <div class="detail-row">
                <span class="label">Date :</span>
                <span>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Filiale :</span>
                <span>{{ $expense->filiale->name ?? 'â€”' }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Agence :</span>
                <span>{{ $expense->agence->name ?? 'â€”' }}</span>
            </div>

            <div>
                <span class="label block">Description :</span>
                <p class="mt-1">{{ $expense->description ?? 'â€”' }}</p>
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('expenses.edit', $expense) }}" class="hh-btn-secondary">Modifier</a>

            <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                  onsubmit="return confirm('Supprimer cette dÃ©pense ?')">
                @csrf @method('DELETE')
                <button class="hh-btn-danger">Supprimer</button>
            </form>
        </div>

    </div>

</div>
@endsection







