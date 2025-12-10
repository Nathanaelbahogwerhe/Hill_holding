@extends('layouts.app')

@section('title', 'Nouvelle DÃ©pense')

@section('content')
<div class="max-w-3xl mx-auto py-6">

    <div class="bg-hh-card p-6 rounded-xl shadow border border-hh-border">
        <h2 class="text-xl font-semibold text-hh-gold mb-4">âž• Nouvelle DÃ©pense</h2>

        <form action="{{ route('expenses.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="hh-label">Titre</label>
                <input type="text" name="title" class="hh-input" required>
            </div>

            <div>
                <label class="hh-label">Montant</label>
                <input type="number" step="0.01" name="amount" class="hh-input" required>
            </div>

            <div>
                <label class="hh-label">Date</label>
                <input type="date" name="date" class="hh-input" required>
            </div>

            <div>
                <label class="hh-label">Filiale</label>
                <select name="filiale_id" class="hh-input">
                    <option value="">â€” SÃ©lectionner â€”</option>
                    @foreach($filiales as $filiale)
                        <option value="{{ $filiale->id }}">{{ $filiale->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="hh-label">Agence</label>
                <select name="agence_id" class="hh-input">
                    <option value="">â€” SÃ©lectionner â€”</option>
                    @foreach($agences as $agence)
                        <option value="{{ $agence->id }}">{{ $agence->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="hh-label">Description</label>
                <textarea name="description" rows="3" class="hh-input"></textarea>
            </div>

            <div class="flex justify-end">
                <button class="hh-btn-primary">Enregistrer</button>
            </div>

        </form>
    </div>

</div>
@endsection







