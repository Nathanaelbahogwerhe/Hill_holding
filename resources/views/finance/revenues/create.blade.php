@extends('layouts.app')

@section('title', 'Nouveau Revenu')

@section('content')
<div class="max-w-3xl mx-auto py-6">

    <div class="bg-hh-card p-6 rounded-xl shadow border border-hh-border">
        <h2 class="text-xl font-semibold text-hh-gold mb-4">➕ Nouveau Revenu</h2>

        <form action="{{ route('revenues.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="hh-label">Description *</label>
                <input type="text" name="description" value="{{ old('description') }}" class="hh-input" required
                       placeholder="Ex: Vente de produits">
                @error('description')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="hh-label">Montant (FBu) *</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" class="hh-input" required min="0"
                       placeholder="Ex: 100000">
                @error('amount')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="hh-label">Date *</label>
                <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="hh-input" required>
                @error('date')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="hh-label">Filiale</label>
                <select name="filiale_id" class="hh-input">
                    <option value="">— Sélectionner —</option>
                    @foreach($filiales as $filiale)
                        <option value="{{ $filiale->id }}" @selected(old('filiale_id')==$filiale->id)>{{ $filiale->name }}</option>
                    @endforeach
                </select>
                @error('filiale_id')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="hh-label">Agence</label>
                <select name="agence_id" class="hh-input">
                    <option value="">— Sélectionner —</option>
                    @foreach($agences as $agence)
                        <option value="{{ $agence->id }}" @selected(old('agence_id')==$agence->id)>{{ $agence->name }}</option>
                    @endforeach
                </select>
                @error('agence_id')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="hh-label">Pièce Jointe (optionnel)</label>
                <input type="file" name="attachment" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                       class="hh-input text-gray-300">
                <p class="text-xs text-gray-400 mt-1">Formats: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (max 10MB)</p>
                @error('attachment')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('revenues.index') }}" class="hh-btn-secondary">Annuler</a>
                <button type="submit" class="hh-btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>

</div>
@endsection




