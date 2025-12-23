@extends('layouts.app')
@section('title', 'Ajouter un Employé')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">
            ➕ Ajouter un Employé
        </h1>
        <a href="{{ route('employees.index') }}"
           class="px-4 py-2 bg-black border border-[#D4AF37] text-[#D4AF37] rounded-xl hover:bg-[#D4AF37] hover:text-black transition">
            ← Retour
        </a>
    </div>

    {{-- Erreurs --}}
    @if ($errors->any())
        <div class="bg-red-950 border border-red-700 text-red-200 p-4 rounded-xl mb-6">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire --}}
        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-black border border-neutral-800 rounded-xl p-8 shadow-xl">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Prénom --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Prénom *</label>
                <input type="text" name="first_name" required
                       value="{{ old('first_name') }}"
                       class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            {{-- Nom --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Nom *</label>
                <input type="text" name="last_name" required
                       value="{{ old('last_name') }}"
                       class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            {{-- Email --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Email</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            {{-- Salaire --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Salaire de base</label>
                <input type="number" name="basic_salary" min="0" step="0.01"
                       value="{{ old('basic_salary') }}"
                       class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            {{-- Date d'embauche --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Date d'embauche</label>
                <input type="date" name="hire_date"
                       value="{{ old('hire_date') }}"
                       class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            {{-- Filiale --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">
                    Filiale <span class="text-xs text-neutral-500">(vide = maison mère)</span>
                </label>
                <select name="filiale_id" id="filiale_id"
                        class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
                    <option value="">— HillHolding (Maison mère)</option>
                    @foreach($filiales as $filiale)
                        <option value="{{ $filiale->id }}"
                            {{ old('filiale_id') == $filiale->id ? 'selected' : '' }}>
                            {{ $filiale->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Agence (SEULEMENT SI FILIALE) --}}
            <div id="agency-wrapper" class="hidden">
                <label class="text-[#D4AF37] font-semibold">Agence</label>
                <select name="agency_id" id="agency_id"
                        class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
                    <option value="">— Sélectionner —</option>
                    @foreach($agences as $agence)
                        <option value="{{ $agence->id }}"
                              data-filiale="{{ $agence->filiale_id }}">
                            {{ $agence->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Département --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Département</label>
                <select name="department_id" id="department_id"
                        class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
                    <option value="">— Sélectionner —</option>
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}" data-filiale="{{ $d->filiale_id }}">
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Poste --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Poste</label>
                <select name="position_id" id="position_id"
                        class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
                    <option value="">— Sélectionner —</option>
                    @foreach($positions as $p)
                        <option value="{{ $p->id }}" data-filiale="{{ $p->filiale_id }}">
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Utilisateur --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Utilisateur lié</label>
                <select name="user_id"
                        class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
                    <option value="">— Aucun —</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Date de naissance --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Date de naissance</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            {{-- Lieu de naissance --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Lieu de naissance</label>
                <input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            {{-- Nationalité --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Nationalité</label>
                <input type="text" name="nationality" value="{{ old('nationality') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            {{-- Type / Numéro pièce & upload --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Type de pièce</label>
                <input type="text" name="id_document_type" value="{{ old('id_document_type') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            <div>
                <label class="text-[#D4AF37] font-semibold">Numéro pièce</label>
                <input type="text" name="id_document_number" value="{{ old('id_document_number') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            <div>
                <label class="text-[#D4AF37] font-semibold">Copie pièce (pdf/jpg/png)</label>
                <input type="file" name="id_document_file" accept=".pdf,image/*" class="w-full mt-1 text-white">
            </div>

            {{-- Contact perso --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Email personnel</label>
                <input type="email" name="personal_email" value="{{ old('personal_email') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            <div>
                <label class="text-[#D4AF37] font-semibold">Contact urgence (Nom)</label>
                <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            <div>
                <label class="text-[#D4AF37] font-semibold">Contact urgence (Téléphone)</label>
                <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            {{-- Bancaires & administratifs --}}
            <div>
                <label class="text-[#D4AF37] font-semibold">Matricule interne</label>
                <input type="text" name="matricule" value="{{ old('matricule') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            <div>
                <label class="text-[#D4AF37] font-semibold">INSS</label>
                <input type="text" name="inss_number" value="{{ old('inss_number') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            <div>
                <label class="text-[#D4AF37] font-semibold">NIF</label>
                <input type="text" name="nif" value="{{ old('nif') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            <div>
                <label class="text-[#D4AF37] font-semibold">RIB</label>
                <input type="text" name="rib" value="{{ old('rib') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            {{-- Contractuel / Qualifications --}}
            <div class="md:col-span-2">
                <label class="text-[#D4AF37] font-semibold">Type de contrat</label>
                <input type="text" name="contract_type" value="{{ old('contract_type') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            <div class="md:col-span-2">
                <label class="text-[#D4AF37] font-semibold">Qualifications / Diplômes</label>
                <textarea name="qualifications" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">{{ old('qualifications') }}</textarea>
            </div>

            <div>
                <label class="text-[#D4AF37] font-semibold">Situation matrimoniale</label>
                <input type="text" name="marital_status" value="{{ old('marital_status') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            <div>
                <label class="text-[#D4AF37] font-semibold">Nombre d'enfants à charge</label>
                <input type="number" name="children_count" value="{{ old('children_count') }}" min="0" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

            <div>
                <label class="text-[#D4AF37] font-semibold">Primes / Allocations</label>
                <input type="number" step="0.01" name="salary_allowances" value="{{ old('salary_allowances') }}" class="w-full mt-1 bg-black border border-neutral-700 rounded-xl px-4 py-2 text-white">
            </div>

        </div>
        {{-- Attachment Section --}}
        <div class="mt-6 pt-6 border-t border-neutral-800">
            <h3 class="text-xl font-bold text-[#D4AF37] mb-4">📎 Documents</h3>
            <x-file-upload :model="null" route="employees" />
        </div>
        {{-- Actions --}}
        <div class="flex gap-4 mt-10">
            <button type="submit"
                class="px-6 py-3 bg-[#D4AF37] text-black font-bold rounded-xl hover:bg-yellow-400 transition">
                ✅ Créer
            </button>

            <a href="{{ route('employees.index') }}"
               class="px-6 py-3 bg-neutral-900 border border-neutral-700 text-white rounded-xl">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>

{{-- JS logique HillHolding --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const filiale = document.getElementById('filiale_id');
    const agencyWrapper = document.getElementById('agency-wrapper');
    const agency = document.getElementById('agency_id');

    filiale.addEventListener('change', () => {
        if (!filiale.value) {
            agencyWrapper.classList.add('hidden');
            agency.value = '';
        } else {
            agencyWrapper.classList.remove('hidden');
            // Filtrer les agences selon la filiale sélectionnée
            [...agency.options].forEach(opt => {
                opt.hidden = opt.dataset.filiale && opt.dataset.filiale !== filiale.value;
            });
        }
    });
});
</script>
@endsection
