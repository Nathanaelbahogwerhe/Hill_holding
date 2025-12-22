@extends('layouts.app')
@section('title', 'Créer Contrat')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">📋 Créer un Contrat</h1>
        <a href="{{ route('contracts.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg">← Retour</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-lg mb-6">
            <h3 class="font-bold mb-2">❌ Erreurs:</h3>
            <ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="bg-black rounded-lg shadow-xl p-8 border border-neutral-800">
        <form action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Employé <span class="text-red-500">*</span></label>
                    <select name="employee_id" id="employee_id" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" data-filiale="{{ $emp->filiale_id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->first_name }} {{ $emp->last_name }}
                                @if($emp->filiale)
                                    ({{ $emp->filiale->name }})
                                @else
                                    (Maison Mère)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Filiale <span class="text-neutral-400 text-sm">(auto-remplie)</span></label>
                    <input type="text" id="filiale_name" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Type de Contrat <span class="text-red-500">*</span></label>
                    <select name="contract_type" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="CDI" {{ old('contract_type') == 'CDI' ? 'selected' : '' }}>CDI - Contrat à Durée Indéterminée</option>
                        <option value="CDD" {{ old('contract_type') == 'CDD' ? 'selected' : '' }}>CDD - Contrat à Durée Déterminée</option>
                        <option value="Stage" {{ old('contract_type') == 'Stage' ? 'selected' : '' }}>Stage</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Département</label>
                    <input type="text" id="department_name" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Date de début <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Date de fin</label>
                    <input type="date" name="end_date" id="end_date" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">
                    <small class="text-neutral-400">Optionnel, doit être après la date de début</small>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Salaire <span class="text-red-500">*</span></label>
                    <input type="number" name="salary" value="{{ old('salary') }}" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" min="0" step="0.01" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Devise</label>
                    <input type="text" value="FBu" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Description</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">{{ old('description') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-[#D4AF37]">📎 Documents du contrat</label>
                    <x-file-upload :model="null" route="contracts" />
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded-lg font-bold transition">✅ Créer</button>
                <a href="{{ route('contracts.index') }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg font-bold transition">❌ Annuler</a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('employee_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const filialeId = selectedOption.getAttribute('data-filiale');
    const filialeInput = document.getElementById('filiale_name');
    
    if (filialeId && filialeId !== 'null') {
        filialeInput.value = selectedOption.text.split('(')[1].replace(')', '');
    } else {
        filialeInput.value = 'Maison Mère';
    }
});
</script>
@endsection
