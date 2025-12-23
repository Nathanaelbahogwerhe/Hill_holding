@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Nouvelle Demande d'Achat</h1>
        <p class="text-neutral-400">Créer une demande d'achat pour approbation</p>
    </div>

    <form action="{{ route('purchase_requests.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Filiale --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Filiale <span class="text-red-500">*</span></label>
                <select name="filiale_id" class="form-select w-full @error('filiale_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($filiales as $filiale)
                    <option value="{{ $filiale->id }}" {{ old('filiale_id') == $filiale->id ? 'selected' : '' }}>
                        {{ $filiale->nom }}
                    </option>
                    @endforeach
                </select>
                @error('filiale_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Service --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Service <span class="text-red-500">*</span></label>
                <select name="service_id" class="form-select w-full @error('service_id') border-red-500 @enderror" required>
                    <option value="">Sélectionner</option>
                    @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                        {{ $service->nom }}
                    </option>
                    @endforeach
                </select>
                @error('service_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Objet --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Objet <span class="text-red-500">*</span></label>
                <input type="text" name="objet" value="{{ old('objet') }}" class="form-input w-full @error('objet') border-red-500 @enderror" required placeholder="Ex: Achat de matériel informatique">
                @error('objet')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Description --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="form-input w-full @error('description') border-red-500 @enderror" required placeholder="Détails de la demande...">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Justification --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Justification <span class="text-red-500">*</span></label>
                <textarea name="justification" rows="3" class="form-input w-full @error('justification') border-red-500 @enderror" required placeholder="Justification de la demande...">{{ old('justification') }}</textarea>
                @error('justification')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Montant Estimé --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Montant Estimé (FCFA) <span class="text-red-500">*</span></label>
                <input type="number" name="montant_estime" value="{{ old('montant_estime') }}" class="form-input w-full @error('montant_estime') border-red-500 @enderror" required step="0.01" min="0">
                @error('montant_estime')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Priorité --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Priorité <span class="text-red-500">*</span></label>
                <select name="priorite" class="form-select w-full @error('priorite') border-red-500 @enderror" required>
                    <option value="basse" {{ old('priorite') == 'basse' ? 'selected' : '' }}>Basse</option>
                    <option value="moyenne" {{ old('priorite', 'moyenne') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                    <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                    <option value="urgente" {{ old('priorite') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                </select>
                @error('priorite')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Date Nécessité --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Date de Nécessité <span class="text-red-500">*</span></label>
                <input type="date" name="date_necessite" value="{{ old('date_necessite') }}" class="form-input w-full @error('date_necessite') border-red-500 @enderror" required>
                @error('date_necessite')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Catégorie --}}
            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Catégorie</label>
                <input type="text" name="categorie" value="{{ old('categorie') }}" class="form-input w-full @error('categorie') border-red-500 @enderror" placeholder="Ex: Informatique, Fournitures...">
                @error('categorie')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Pièces jointes --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Pièces Jointes</label>
                <input type="file" name="attachments[]" multiple class="form-input w-full @error('attachments') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Vous pouvez joindre des devis, spécifications, etc.</p>
                @error('attachments')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Remarques --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Remarques</label>
                <textarea name="remarques" rows="2" class="form-input w-full @error('remarques') border-red-500 @enderror" placeholder="Remarques ou informations complémentaires...">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('purchase_requests.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" name="action" value="save" class="btn-secondary">Enregistrer Brouillon</button>
            <button type="submit" name="action" value="submit" class="btn-primary">Soumettre pour Approbation</button>
        </div>
    </form>
</div>
@endsection
