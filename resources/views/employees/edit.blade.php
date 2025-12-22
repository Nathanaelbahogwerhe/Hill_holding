@extends('layouts.app')
@section('title', 'Modifier Employé')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-yellow-400">✏️ Modifier un Employé</h1>
        <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">← Retour</a>
    </div>

    {{-- Erreurs --}}
    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-lg mb-6">
            <h3 class="font-bold mb-2">❌ Erreurs :</h3>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire --}}
    <div class="bg-black border border-yellow-600 rounded-xl shadow-xl p-8">
        <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Prénom --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Prénom <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}"
                           class="input-hh" required>
                </div>

                {{-- Nom --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}"
                           class="input-hh" required>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Email</label>
                    <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="input-hh">
                </div>

                {{-- Salaire de base --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Salaire de base</label>
                    <input type="number" name="basic_salary" value="{{ old('basic_salary', $employee->basic_salary) }}" min="0"
                           class="input-hh">
                </div>

                {{-- Filiale --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Filiale <span class="text-gray-400">(optionnel)</span></label>
                    <select id="filiale_id" name="filiale_id" class="input-hh">
                        <option value="">-- Maison Mère --</option>
                        @foreach($filiales as $f)
                            <option value="{{ $f->id }}" data-filiale="{{ $f->id }}" 
                                {{ old('filiale_id', $employee->filiale_id) == $f->id ? 'selected' : '' }}>
                                {{ $f->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Département --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Département</label>
                    <select id="department_id" name="department_id" class="input-hh">
                        <option value="">-- Sélectionner --</option>
                        @foreach($departments as $dep)
                            <option value="{{ $dep->id }}" data-filiale="{{ $dep->filiale_id }}"
                                {{ old('department_id', $employee->department_id) == $dep->id ? 'selected' : '' }}>
                                {{ $dep->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Poste --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Poste</label>
                    <select id="position_id" name="position_id" class="input-hh">
                        <option value="">-- Sélectionner --</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos->id }}" data-filiale="{{ $pos->filiale_id }}"
                                {{ old('position_id', $employee->position_id) == $pos->id ? 'selected' : '' }}>
                                {{ $pos->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Agence --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Agence</label>
                    <select id="agency_id" name="agency_id" class="input-hh">
                        <option value="">-- Sélectionner --</option>
                        @foreach($agences as $a)
                            <option value="{{ $a->id }}" data-filiale="{{ $a->filiale_id }}"
                                {{ old('agency_id', $employee->agency_id) == $a->id ? 'selected' : '' }}>
                                {{ $a->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Utilisateur lié --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Utilisateur lié</label>
                    <select id="user_id" name="user_id" class="input-hh">
                        <option value="">-- Aucun --</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" data-filiale="{{ $u->filiale_id }}"
                                {{ old('user_id', $employee->user_id) == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Date d'embauche --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Date d'embauche</label>
                    <input type="date" name="hire_date" value="{{ old('hire_date', $employee->hire_date) }}" class="input-hh">
                </div>

                {{-- Date de naissance --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Date de naissance</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth) }}" class="input-hh">
                </div>

                {{-- Lieu de naissance --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Lieu de naissance</label>
                    <input type="text" name="place_of_birth" value="{{ old('place_of_birth', $employee->place_of_birth) }}" class="input-hh">
                </div>

                {{-- Nationalité --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Nationalité</label>
                    <input type="text" name="nationality" value="{{ old('nationality', $employee->nationality) }}" class="input-hh">
                </div>

                {{-- Type de pièce --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Type de pièce</label>
                    <input type="text" name="id_document_type" value="{{ old('id_document_type', $employee->id_document_type) }}" class="input-hh" placeholder="CNI, Passeport">
                </div>

                {{-- Numéro pièce --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Numéro pièce</label>
                    <input type="text" name="id_document_number" value="{{ old('id_document_number', $employee->id_document_number) }}" class="input-hh">
                </div>

                {{-- Upload pièce --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Copie pièce (pdf/jpg/png)</label>
                    @if($employee->id_document_file)
                        <div class="mb-2"><a href="{{ route('employees.document', $employee) }}" class="text-yellow-400 underline">📄 Télécharger la pièce actuelle</a></div>
                    @endif
                    <input type="file" name="id_document_file" accept=".pdf,image/*" class="input-hh">
                </div>

                {{-- Téléphone --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="input-hh">
                </div>

                {{-- Adresse --}}
                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-yellow-400">Adresse</label>
                    <input type="text" name="address" value="{{ old('address', $employee->address) }}" class="input-hh">
                </div>

                {{-- Email personnel --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Email personnel</label>
                    <input type="email" name="personal_email" value="{{ old('personal_email', $employee->personal_email) }}" class="input-hh">
                </div>

                {{-- Contact urgence nom --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Contact urgence (Nom)</label>
                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $employee->emergency_contact_name) }}" class="input-hh">
                </div>

                {{-- Contact urgence téléphone --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Contact urgence (Téléphone)</label>
                    <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone) }}" class="input-hh">
                </div>

                {{-- Matricule --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Matricule interne</label>
                    <input type="text" name="matricule" value="{{ old('matricule', $employee->matricule) }}" class="input-hh">
                </div>

                {{-- INSS --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">INSS</label>
                    <input type="text" name="inss_number" value="{{ old('inss_number', $employee->inss_number) }}" class="input-hh">
                </div>

                {{-- NIF --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">NIF</label>
                    <input type="text" name="nif" value="{{ old('nif', $employee->nif) }}" class="input-hh">
                </div>

                {{-- RIB --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">RIB</label>
                    <input type="text" name="rib" value="{{ old('rib', $employee->rib) }}" class="input-hh">
                </div>

                {{-- Type de contrat --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Type de contrat</label>
                    <input type="text" name="contract_type" value="{{ old('contract_type', $employee->contract_type) }}" class="input-hh" placeholder="CDI, CDD, Stage">
                </div>

                {{-- Lieu de travail --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Lieu de travail</label>
                    <input type="text" name="workplace" value="{{ old('workplace', $employee->workplace) }}" class="input-hh">
                </div>

                {{-- Qualifications --}}
                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-yellow-400">Qualifications / Diplômes</label>
                    <textarea name="qualifications" rows="3" class="input-hh">{{ old('qualifications', $employee->qualifications) }}</textarea>
                </div>

                {{-- Situation matrimoniale --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Situation matrimoniale</label>
                    <input type="text" name="marital_status" value="{{ old('marital_status', $employee->marital_status) }}" class="input-hh" placeholder="Célibataire, Marié(e)">
                </div>

                {{-- Nombre d'enfants --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Nombre d'enfants à charge</label>
                    <input type="number" name="children_count" value="{{ old('children_count', $employee->children_count) }}" min="0" class="input-hh">
                </div>

                {{-- Primes / Allocations --}}
                <div>
                    <label class="block mb-2 font-semibold text-yellow-400">Primes / Allocations</label>
                    <input type="number" step="0.01" name="salary_allowances" value="{{ old('salary_allowances', $employee->salary_allowances) }}" class="input-hh">
                </div>

            </div>

            {{-- Attachment Section --}}
            <div class="mt-6 pt-6 border-t border-neutral-800">
                <h3 class="text-xl font-bold text-yellow-400 mb-4">📎 Documents</h3>
                <x-file-upload :model="$employee" route="employees" />
            </div>

            {{-- Actions --}}
            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-yellow-500 text-black font-bold rounded-lg">✅ Enregistrer</button>
                <a href="{{ route('employees.index') }}" class="px-6 py-3 bg-gray-800 text-white rounded-lg">❌ Annuler</a>
            </div>
        </form>
    </div>
</div>

{{-- JS Filtrage dynamique selon filiale --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filialeSelect = document.getElementById('filiale_id');
    const agencySelect = document.getElementById('agency_id');
    const departmentSelect = document.getElementById('department_id');
    const positionSelect = document.getElementById('position_id');
    const userSelect = document.getElementById('user_id');

    const allAgencies = Array.from(agencySelect.options).slice(1);
    const allDepartments = Array.from(departmentSelect.options).slice(1);
    const allPositions = Array.from(positionSelect.options).slice(1);
    const allUsers = Array.from(userSelect.options).slice(1);

    function filterOptions() {
        const filialeId = filialeSelect.value;

        function filter(select, allOptions) {
            while (select.options.length > 1) select.remove(1);
            if (!filialeId) {
                allOptions.forEach(o => select.appendChild(o.cloneNode(true)));
            } else {
                allOptions.forEach(o => {
                    if (o.getAttribute('data-filiale') === filialeId) select.appendChild(o.cloneNode(true));
                });
            }
        }

        filter(agencySelect, allAgencies);
        filter(departmentSelect, allDepartments);
        filter(positionSelect, allPositions);
        filter(userSelect, allUsers);
    }

    filialeSelect.addEventListener('change', filterOptions);
    if(filialeSelect.value) filterOptions();
});
</script>

{{-- Styles HH --}}
<style>
.input-hh {
    width:100%; padding:10px; background:#000; border:1px solid #d4af37; color:#fff; border-radius:8px;
}
</style>

@endsection
