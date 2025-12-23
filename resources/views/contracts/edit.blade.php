@extends('layouts.app')
@section('title', 'Modifier Contrat')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">✏️ Modifier Contrat</h1>
        <a href="{{ route('contracts.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl">← Retour</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-xl mb-6">
            <h3 class="font-bold mb-2">❌ Erreurs:</h3>
            <ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800">
        <form action="{{ route('contracts.update', $contract->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Employé</label>
                    <input type="text" value="{{ $contract->employee?->first_name }} {{ $contract->employee?->last_name }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Filiale</label>
                    <input type="text" value="{{ $contract->employee?->filiale?->name ?? 'Maison Mère' }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Type de Contrat <span class="text-red-500">*</span></label>
                    <select name="contract_type" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="CDI" {{ $contract->contract_type == 'CDI' ? 'selected' : '' }}>CDI - Contrat à Durée Indéterminée</option>
                        <option value="CDD" {{ $contract->contract_type == 'CDD' ? 'selected' : '' }}>CDD - Contrat à Durée Déterminée</option>
                        <option value="Stage" {{ $contract->contract_type == 'Stage' ? 'selected' : '' }}>Stage</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Département</label>
                    <input type="text" value="{{ $contract->employee?->department?->name ?? '—' }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Date de début <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="{{ $contract->start_date?->format('Y-m-d') }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Date de fin</label>
                    <input type="date" name="end_date" value="{{ $contract->end_date?->format('Y-m-d') }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Salaire <span class="text-red-500">*</span></label>
                    <input type="number" name="salary" value="{{ $contract->salary }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" min="0" step="0.01" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Devise</label>
                    <input type="text" value="FBu" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Description</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">{{ $contract->description }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-[#D4AF37]">📎 Documents du contrat</label>
                    <x-file-upload :model="$contract" route="contracts" />
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-[#D4AF37] hover:bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 text-black rounded-xl font-bold transition">✅ Mettre à jour</button>
                <a href="{{ route('contracts.index') }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-bold transition">❌ Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
