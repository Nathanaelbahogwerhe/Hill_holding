@extends('layouts.app')
@section('title', 'Détails Employé')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">👤 {{ $employee->first_name }} {{ $employee->last_name }}</h1>
        <div class="space-x-2">
            <a href="{{ route('employees.edit', $employee->id) }}" class="px-4 py-2 bg-[#D4AF37] hover:bg-yellow-400 text-black rounded-xl font-bold">✏️ Éditer</a>
            <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-black border border-[#D4AF37] text-[#D4AF37] hover:bg-[#D4AF37] hover:text-black rounded-xl transition">← Retour</a>
        </div>
    </div>

    <!-- Informations Personnelles -->
    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6 border-b border-neutral-700 pb-3">👤 Informations Personnelles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-neutral-400 text-sm uppercase">Prénom</p>
                <p class="text-lg font-semibold text-[#D4AF37]">{{ $employee->first_name }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Nom</p>
                <p class="text-lg font-semibold text-[#D4AF37]">{{ $employee->last_name }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Email</p>
                <p class="text-lg font-semibold text-white">{{ $employee->email ?? $employee->generated_email }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Salaire de base</p>
                <p class="text-lg font-semibold text-green-400">{{ number_format($employee->basic_salary ?? 0, 0, ',', ' ') }} FBu</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Date d'embauche</p>
                <p class="text-lg font-semibold text-white">{{ $employee->hire_date?->format('d/m/Y') ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Date de naissance</p>
                <p class="text-lg font-semibold text-white">{{ $employee->date_of_birth?->format('d/m/Y') ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Lieu de naissance</p>
                <p class="text-lg font-semibold text-white">{{ $employee->place_of_birth ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Nationalité</p>
                <p class="text-lg font-semibold text-white">{{ $employee->nationality ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Téléphone</p>
                <p class="text-lg font-semibold text-white">{{ $employee->phone ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Email personnel</p>
                <p class="text-lg font-semibold text-white">{{ $employee->personal_email ?? 'N/A' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-neutral-400 text-sm uppercase">Adresse</p>
                <p class="text-lg font-semibold text-white">{{ $employee->address ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Documents d'identité -->
    @if($employee->id_document_type || $employee->id_document_number || $employee->id_document_file)
    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6 border-b border-neutral-700 pb-3">📄 Documents d'Identité</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-neutral-400 text-sm uppercase">Type de pièce</p>
                <p class="text-lg font-semibold text-white">{{ $employee->id_document_type ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Numéro</p>
                <p class="text-lg font-semibold text-white">{{ $employee->id_document_number ?? 'N/A' }}</p>
            </div>
            @if($employee->id_document_file)
            <div class="md:col-span-2">
                <p class="text-neutral-400 text-sm uppercase mb-2">Document scanné</p>
                <a href="{{ route('employees.document', $employee) }}" class="inline-block px-4 py-2 bg-[#D4AF37] hover:bg-yellow-400 text-black rounded-xl font-bold">📥 Télécharger</a>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Informations Administratives -->
    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6 border-b border-neutral-700 pb-3">🏛️ Informations Administratives & Bancaires</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-neutral-400 text-sm uppercase">Matricule</p>
                <p class="text-lg font-semibold text-white">{{ $employee->matricule ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">INSS</p>
                <p class="text-lg font-semibold text-white">{{ $employee->inss_number ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">NIF</p>
                <p class="text-lg font-semibold text-white">{{ $employee->nif ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">RIB</p>
                <p class="text-lg font-semibold text-white">{{ $employee->rib ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Informations Contractuelles -->
    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6 border-b border-neutral-700 pb-3">📋 Informations Contractuelles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-neutral-400 text-sm uppercase">Type de contrat</p>
                <p class="text-lg font-semibold text-white">{{ $employee->contract_type ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Lieu de travail</p>
                <p class="text-lg font-semibold text-white">{{ $employee->workplace ?? 'N/A' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-neutral-400 text-sm uppercase">Qualifications / Diplômes</p>
                <p class="text-lg font-semibold text-white">{{ $employee->qualifications ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Famille & Allocations -->
    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6 border-b border-neutral-700 pb-3">👨‍👩‍👧‍👦 Famille & Allocations</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-neutral-400 text-sm uppercase">Situation matrimoniale</p>
                <p class="text-lg font-semibold text-white">{{ $employee->marital_status ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Enfants à charge</p>
                <p class="text-lg font-semibold text-white">{{ $employee->children_count ?? 0 }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Primes / Allocations</p>
                <p class="text-lg font-semibold text-green-400">{{ number_format($employee->salary_allowances ?? 0, 0, ',', ' ') }} FBu</p>
            </div>
        </div>
    </div>

    <!-- Contact d'urgence -->
    @if($employee->emergency_contact_name || $employee->emergency_contact_phone)
    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6 border-b border-neutral-700 pb-3">🚨 Contact d'Urgence</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-neutral-400 text-sm uppercase">Nom</p>
                <p class="text-lg font-semibold text-white">{{ $employee->emergency_contact_name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Téléphone</p>
                <p class="text-lg font-semibold text-white">{{ $employee->emergency_contact_phone ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Relations Organisationnelles -->
    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6 border-b border-neutral-700 pb-3">🏢 Relations Organisationnelles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-neutral-400 text-sm uppercase">Département</p>
                <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full text-sm font-semibold">{{ $employee->department?->name ?? 'N/A' }}</span>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Poste</p>
                <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full text-sm font-semibold">{{ $employee->position?->name ?? 'N/A' }}</span>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Filiale</p>
                <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full text-sm font-semibold">{{ $employee->filiale?->name ?? 'N/A' }}</span>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Agence</p>
                <span class="inline-block bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full text-sm font-semibold">{{ $employee->agence?->name ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <!-- Documents attachés -->
    @if($employee->attachment)
    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6 border-b border-neutral-700 pb-3">📎 Documents</h2>
        <div>
            <p class="text-neutral-400 text-sm uppercase mb-3">CV, Certificats, Diplômes</p>
            <a href="{{ Storage::url($employee->attachment) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-[#D4AF37] hover:bg-yellow-400 text-black rounded-xl font-bold transition">
                📎 Télécharger le document
            </a>
        </div>
    </div>
    @endif

    <!-- Contrats -->
    @if($employee->contracts->count() > 0)
    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6">📄 Contrats ({{ $employee->contracts->count() }})</h2>
        <div class="space-y-3">
            @foreach($employee->contracts as $contract)
            <div class="bg-neutral-900 p-4 rounded-xl border border-neutral-700">
                <p class="text-sm text-neutral-300">Type: <span class="text-[#D4AF37] font-semibold">{{ $contract->type }}</span></p>
                <p class="text-sm text-neutral-300">Salaire: <span class="text-green-400 font-semibold">{{ number_format($contract->salary, 0, ',', ' ') }} FBu</span></p>
                <p class="text-sm text-neutral-300">Période: {{ $contract->start_date?->format('d/m/Y') }} - {{ $contract->end_date?->format('d/m/Y') }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Paies -->
    @if($employee->payrolls->count() > 0)
    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6">💰 Paies Récentes ({{ $employee->payrolls->count() }})</h2>
        <div class="space-y-3">
            @foreach($employee->payrolls->take(5) as $payroll)
            <div class="bg-neutral-900 p-4 rounded-xl border border-neutral-700 flex justify-between items-center">
                <p class="text-sm text-neutral-300">{{ $payroll->payment_date?->format('d/m/Y') }}</p>
                <p class="text-green-400 font-semibold">{{ number_format($payroll->net_salary, 0, ',', ' ') }} FBu</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Congés -->
    @if($employee->leaves->count() > 0)
    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800 mb-6">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6">🏖️ Congés ({{ $employee->leaves->count() }})</h2>
        <div class="space-y-3">
            @foreach($employee->leaves->take(5) as $leave)
            <div class="bg-neutral-900 p-4 rounded-xl border border-neutral-700">
                <p class="text-sm text-neutral-300">{{ $leave->leaveType?->name }} - {{ $leave->start_date?->format('d/m/Y') }} à {{ $leave->end_date?->format('d/m/Y') }}</p>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold @if($leave->status === 'pending') bg-yellow-900 text-yellow-200 @elseif($leave->status === 'approved') bg-green-900 text-green-200 @else bg-red-900 text-red-200 @endif">{{ ucfirst($leave->status) }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Delete Button -->
    <div class="mt-8 pt-6 border-t border-neutral-700">
        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold transition"> Supprimer</button>
        </form>
    </div>
</div>
@endsection