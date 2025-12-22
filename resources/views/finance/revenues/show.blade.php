@extends('layouts.app')

@section('title', 'Détails Revenu')

@section('content')
<div class="max-w-3xl mx-auto py-6">

    <div class="bg-hh-card p-6 rounded-xl shadow border border-hh-border">
        <h2 class="text-xl font-semibold text-hh-gold mb-4">📄 Détails du Revenu</h2>

        <div class="space-y-4 text-sm text-gray-300">

            <div class="detail-row">
                <span class="label">Description :</span>
                <span>{{ $revenue->description }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Montant :</span>
                <span class="text-green-400 font-bold text-lg">+ {{ number_format($revenue->amount, 0, ',', ' ') }} FBu</span>
            </div>

            <div class="detail-row">
                <span class="label">Date :</span>
                <span>{{ \Carbon\Carbon::parse($revenue->date)->format('d/m/Y') }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Filiale :</span>
                <span>{{ $revenue->filiale->name ?? '—' }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Agence :</span>
                <span>{{ $revenue->agence->name ?? '—' }}</span>
            </div>

            @if($revenue->attachment)
            <div class="detail-row">
                <span class="label">Document joint :</span>
                <a href="{{ Storage::url($revenue->attachment) }}" target="_blank" 
                   class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300">
                    <i class="fas fa-file-download"></i>
                    <span>Télécharger le document</span>
                </a>
            </div>
            @endif

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('revenues.index') }}" class="hh-btn-secondary">Retour</a>
            <a href="{{ route('revenues.edit', $revenue) }}" class="hh-btn-primary">Modifier</a>

            <form action="{{ route('revenues.destroy', $revenue) }}" method="POST"
                  onsubmit="return confirm('Supprimer ce revenu ?')">
                @csrf @method('DELETE')
                <button class="hh-btn-danger">Supprimer</button>
            </form>
        </div>

    </div>

</div>
@endsection
