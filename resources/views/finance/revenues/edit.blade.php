@extends('layouts.app')

@section('title', 'Modifier Revenu')

@section('content')
<div class="max-w-3xl mx-auto py-6">

    <div class="bg-hh-card p-6 rounded-xl shadow border border-hh-border">
        <h2 class="text-xl font-semibold text-hh-gold mb-4">✏️ Modifier Revenu</h2>

        <form action="{{ route('revenues.update', $revenue) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="hh-label">Description *</label>
                <input type="text" name="description" value="{{ old('description', $revenue->description) }}" class="hh-input" required
                       placeholder="Ex: Vente de produits">
                @error('description')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="hh-label">Montant (FBu) *</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount', $revenue->amount) }}" class="hh-input" required min="0">
                @error('amount')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="hh-label">Date *</label>
                <input type="date" name="date" value="{{ old('date', $revenue->date) }}" class="hh-input" required>
                @error('date')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="hh-label">Filiale</label>
                <select name="filiale_id" class="hh-input">
                    <option value="">— Sélectionner —</option>
                    @foreach($filiales as $filiale)
                        <option value="{{ $filiale->id }}" @selected(old('filiale_id', $revenue->filiale_id)==$filiale->id)>{{ $filiale->name }}</option>
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
                        <option value="{{ $agence->id }}" @selected(old('agence_id', $revenue->agence_id)==$agence->id)>{{ $agence->name }}</option>
                    @endforeach
                </select>
                @error('agence_id')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="hh-label">Pièce Jointe</label>
                
                @if($revenue->attachment)
                <div class="mb-2 flex items-center gap-2 text-sm text-gray-400">
                    <span>📎 Fichier actuel:</span>
                    <a href="{{ Storage::url($revenue->attachment) }}" target="_blank" class="text-blue-400 hover:underline">
                        Voir le document
                    </a>
                </div>
                @endif
                
                <input type="file" name="attachment" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                       class="hh-input text-neutral-300">
                <p class="text-xs text-gray-400 mt-1">
                    @if($revenue->attachment)
                        Choisir un nouveau fichier remplacera l'ancien. 
                    @endif
                    Formats: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (max 10MB)
                </p>
                @error('attachment')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('revenues.index') }}" class="hh-btn-secondary">Annuler</a>
                <button type="submit" class="hh-btn-primary">Mettre à jour</button>
            </div>
        </form>
    </div>

</div>
@endsection
