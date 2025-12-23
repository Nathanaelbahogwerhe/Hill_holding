@extends('layouts.app')

@section('title', 'Détails Dépense')

@section('content')
<div class="max-w-3xl mx-auto py-6">

    <div class="bg-hh-card p-6 rounded-xl shadow border border-hh-border">
        <h2 class="text-xl font-semibold text-hh-gold mb-4">📄 Détails de la Dépense</h2>

        <div class="space-y-4 text-sm text-neutral-300">

            <div class="detail-row">
                <span class="label">Description :</span>
                <span>{{ $expense->description }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Catégorie :</span>
                <span>
                    @if($expense->category)
                        <span class="px-2 py-1 bg-gray-700 rounded text-xs">📁 {{ $expense->category }}</span>
                    @else
                        <span class="text-gray-500">—</span>
                    @endif
                </span>
            </div>

            <div class="detail-row">
                <span class="label">Montant :</span>
                <span class="text-red-400 font-bold text-lg">- {{ number_format($expense->amount, 0, ',', ' ') }} FBu</span>
            </div>

            <div class="detail-row">
                <span class="label">Date :</span>
                <span>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Filiale :</span>
                <span>{{ $expense->filiale->name ?? '—' }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Agence :</span>
                <span>{{ $expense->agence->name ?? '—' }}</span>
            </div>

            @if($expense->attachment)
            <div class="detail-row">
                <span class="label">Document joint :</span>
                <a href="{{ Storage::url($expense->attachment) }}" target="_blank" 
                   class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300">
                    <i class="fas fa-file-download"></i>
                    <span>Télécharger le document</span>
                </a>
            </div>
            @endif

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('expenses.edit', $expense) }}" class="hh-btn-secondary">Modifier</a>

            <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                  onsubmit="return confirm('Supprimer cette dépense ?')">
                @csrf @method('DELETE')
                <button class="hh-btn-danger">Supprimer</button>
            </form>
        </div>

    </div>

</div>
@endsection




