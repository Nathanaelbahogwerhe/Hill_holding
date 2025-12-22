@extends('layouts.app')

@section('title', 'Créer un Tableau de Planification')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-neutral-50 to-neutral-100 py-8 animate-fadeIn">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-[length:200%_100%] animate-gradient rounded-2xl shadow-2xl p-8 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-black text-white mb-2 drop-shadow-lg">
                        📊 Créer un Tableau de Planification
                    </h1>
                    <p class="text-yellow-50 text-lg">Planifiez des activités pour plusieurs départements et mois</p>
                </div>
                <a href="{{ route('activities.planning') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour
                </a>
            </div>
        </div>

        <!-- Formulaire -->
        <form action="{{ route('activities.planning.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Section 1: Période & Localisation -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-neutral-900 mb-6 flex items-center gap-3">
                    <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <span>1. Période & Localisation</span>
                        <p class="text-sm text-neutral-500 font-normal">Définissez la période et la localisation des activités</p>
                    </div>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mois sélection multiple -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-neutral-700 mb-3">Mois à planifier *</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                            @foreach(['Janvier' => 1, 'Février' => 2, 'Mars' => 3, 'Avril' => 4, 'Mai' => 5, 'Juin' => 6, 'Juillet' => 7, 'Août' => 8, 'Septembre' => 9, 'Octobre' => 10, 'Novembre' => 11, 'Décembre' => 12] as $name => $num)
                            <label class="flex items-center gap-2 p-3 bg-neutral-50 rounded-lg hover:bg-blue-50 cursor-pointer transition-all border-2 border-transparent hover:border-blue-500">
                                <input type="checkbox" name="months[]" value="{{ $num }}" class="month-checkbox w-4 h-4 text-blue-600 border-neutral-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-neutral-700">{{ $name }}</span>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-neutral-500 mt-2">Sélectionnez un ou plusieurs mois</p>
                    </div>

                    <!-- Année -->
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 mb-2">Année *</label>
                        <select name="year" class="w-full border-neutral-300 rounded-xl shadow-sm focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37] focus:ring-opacity-50 transition-all" required>
                            @for($y = now()->year; $y <= now()->year + 3; $y++)
                                <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Filiale -->
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 mb-2">Filiale *</label>
                        <select name="filiale_id" id="filialeSelect" class="w-full border-neutral-300 rounded-xl shadow-sm focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37] focus:ring-opacity-50 transition-all" required>
                            <option value="">Sélectionner une filiale</option>
                            @foreach($filiales as $filiale)
                                <option value="{{ $filiale->id }}" {{ auth()->user()->filiale_id == $filiale->id ? 'selected' : '' }}>
                                    {{ $filiale->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Agence -->
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 mb-2">Agence</label>
                        <select name="agence_id" id="agenceSelect" class="w-full border-neutral-300 rounded-xl shadow-sm focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37] focus:ring-opacity-50 transition-all">
                            <option value="">Toutes les agences</option>
                            @foreach($agences as $agence)
                                <option value="{{ $agence->id }}" data-filiale="{{ $agence->filiale_id }}">
                                    {{ $agence->nom }}
                                </option>
                            @endforeach
                        </select>concernés</p>
                    </div>
                </h2>

                <div class="space-y-4">
                    <div class="flex items-center justify-between bg-neutral-50 p-4 rounded-xl">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="selectAllDepts" class="w-5 h-5 text-[#D4AF37] border-neutral-300 rounded focus:ring-[#D4AF37]">
                            <span class="font-semibold text-neutral-900">Sélectionner tous les départements</span>
                        </label>
                        <span id="deptCount" class="text-sm font-bold text-[#D4AF37] bg-white px-3 py-1 rounded-full">0 sélectionné(s)</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-96 overflow-y-auto custom-scrollbar p-2">
                        @foreach($departments as $department)
                        <label class="flex items-center gap-3 p-4 bg-white border-2 border-neutral-200 rounded-xl hover:border-purple-500 hover:bg-purple-50 transition-all cursor-pointer"
                               data-filiale="{{ $department->filiale_id }}" data-agence="{{ $department->agence_id }}">
                            <input type="checkbox" name="departments[]" value="{{ $department->id }}" class="department-checkbox w-5 h-5 text-purple-600 border-neutral-300 rounded focus:ring-purple-500">
                            <div class="flex items-center gap-2 flex-1 min-w-0">
                                <div class="h-10 w-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-neutral-900 truncate">{{ $department->nom }}</p>
                                    <p class="text-xs text-neutral-500 truncate">{{ $department->filiale->nom ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Section 3: Activités à planifier -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-neutral-900 mb-6 flex items-center gap-3">
                    <div class="h-12 w-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <span>3. Activités à planifier</span>
                                <p class="text-sm text-neutral-500 font-normal">Définissez les activités types</p>
                            </div>
                            <button type="button" onclick="addActivity()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Ajouter une activité
                            </button>
                        </div>
                    </div>
                </h2>

                <div id="activitiesContainer" class="space-y-4">
                    <!-- Template d'activité (sera cloné par JS) -->
                    <div class="activity-template hidden">
                        <div class="bg-neutral-50 rounded-xl p-6 border-2 border-neutral-200 relative">
                            <button type="button" onclick="removeActivity(this)" class="absolute top-4 right-4 text-red-500 hover:text-red-700 transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Titre de l'activité *</label>
                                    <input type="text" name="activities[INDEX][titre]" class="w-full border-neutral-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" placeholder="Ex: Réunion d'équipe mensuelle" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Type *</label>
                                    <select name="activities[INDEX][type]" class="w-full border-neutral-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" required>
                                        <option value="réunion">📋 Réunion</option>
                                        <option value="formation">🎓 Formation</option>
                                        <option value="mission">🚀 Mission</option>
                                        <option value="événement">🎉 Événement</option>
                                        <option value="autre">📌 Autre</option>
                                    </select>
                                </div>

                                <div class="md:col-span-3">
                                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Description</label>
                                    <textarea name="activities[INDEX][description]" rows="2" class="w-full border-neutral-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" placeholder="Description de l'activité..."></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Heure</label>
                                    <input type="time" name="activities[INDEX][heure_debut]" class="w-full border-neutral-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Lieu</label>
                                    <input type="text" name="activities[INDEX][lieu]" class="w-full border-neutral-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" placeholder="Ex: Salle de réunion A">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Statut</label>
                                    <select name="activities[INDEX][statut]" class="w-full border-neutral-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                        <option value="planifiée" selected>📅 Planifiée</option>
                                        <option value="en_cours">⏳ En cours</option>
                                        <option value="terminée">✅ Terminée</option>
                                    </select>
                                </div>

                                <div class="md:col-span-3 pt-4 border-t border-neutral-300">
                                    <label class="block text-sm font-semibold text-neutral-700 mb-3">👤 Responsable RH (Optionnel)</label>
                                    <select name="activities[INDEX][responsible_id]" class="w-full border-neutral-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                        <option value="">Aucun responsable assigné</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->user_id }}">
                                                {{ $employee->nom }} {{ $employee->prenom }} - {{ $employee->poste ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="md:col-span-3">
                                    <label class="block text-sm font-semibold text-neutral-700 mb-3">👥 Participants RH (Optionnel)</label>
                                    <div class="max-h-32 overflow-y-auto custom-scrollbar border border-neutral-300 rounded-lg p-3 bg-neutral-50">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            @foreach($employees as $employee)
                                            <label class="flex items-center gap-2 p-2 bg-white rounded hover:bg-green-50 cursor-pointer transition-all">
                                                <input type="checkbox" name="activities[INDEX][participants][]" value="{{ $employee->user_id }}" class="w-4 h-4 text-green-600 border-neutral-300 rounded focus:ring-green-500">
                                                <span class="text-sm text-neutral-700">{{ $employee->nom }} {{ $employee->prenom }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <p class="text-xs text-neutral-500 mt-2">Sélectionnez les employés qui participeront à cette activité</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="noActivities" class="text-center py-12 bg-neutral-50 rounded-xl border-2 border-dashed border-neutral-300">
                    <svg class="w-16 h-16 mx-auto text-neutral-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-neutral-500 font-semibold mb-2">Aucune activité définie</p>
                    <p class="text-sm text-neutral-400">Cliquez sur "Ajouter une activité" pour commencer</plabel class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="selectAll" class="w-5 h-5 text-[#D4AF37] border-neutral-300 rounded focus:ring-[#D4AF37]">
                            <span class="font-semibold text-neutral-900">Sélectionner tous les départements</span>
                        </label>
                        <span id="selectedCount" class="text-sm font-bold text-[#D4AF37] bg-white px-3 py-1 rounded-full">0 sélectionné(s)</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-96 overflow-y-auto custom-scrollbar p-2">
                        @foreach($departments as $department)
                        <label class="flex items-center gap-3 p-4 bg-white border-2 border-neutral-200 rounded-xl hover:border-purple-500 hover:bg-purple-50 transition-all cursor-pointer">
                            <input type="checkbox" name="departments[]" value="{{ $department->id }}" class="department-checkbox w-5 h-5 text-purple-600 border-neutral-300 rounded focus:ring-purple-500">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="h-10 w-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-neutral-900">{{ $department->nom }}</p>
                                    @if($department->filiale)
                                    <p class="text-xs text-neutral-500">{{ $department->filiale->nom }}</p>
                                    @endif
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Section 4: Résumé et Actions -->
            <div class="bg-gradient-to-br from-[#D4AF37] to-yellow-600 rounded-2xl shadow-xl p-8 text-white">
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Résumé de la Planification
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                        <p class="text-yellow-100 text-sm mb-1">Mois</p>
                        <p id="summaryMonths" class="text-2xl font-black">0</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                        <p class="text-yellow-100 text-sm mb-1">Départements</p>
                        <p id="summaryDepts" class="text-2xl font-black">0</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                        <p class="text-yellow-100 text-sm mb-1">Activités</p>
                        <p id="summaryActivities" class="text-2xl font-black">0</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                        <p class="text-yellow-100 text-sm mb-1">Total à créer</p>
                        <p id="summaryTotal" class="text-2xl font-black">0</p>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 mb-6">
                    <p class="text-sm text-yellow-50">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <strong>Comment ça marche ?</strong> Chaque activité sera créée pour chaque département sélectionné, dans chaque mois sélectionné. 
                        <span id="exampleCalc"></span>
                    </p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 bg-white text-[#D4AF37] px-8 py-4 rounded-xl font-black text-lg transition-all duration-300 hover:scale-105 shadow-lg flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Créer le Tableau de Planification
                    </button>
                    <a href="{{ route('activities.planning') }}" 
                       class="px-8 py-4 bg-white/20 backdrop-blur-sm text-white rounded-xl font-semibold hover:bg-white/30 transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Annuler
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let activityIndex = 0;

// Add activity
function addActivity() {
    const template = document.querySelector('.activity-template');
    const container = document.getElementById('activitiesContainer');
    const noActivities = document.getElementById('noActivities');
    
    const clone = template.cloneNode(true);
    clone.classList.remove('activity-template', 'hidden');
    clone.classList.add('activity-item');
    
    // Replace INDEX with actual index
    const inputs = clone.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        if (input.name) {
            input.name = input.name.replace('INDEX', activityIndex);
        }
    });
    
    container.appendChild(clone);
    noActivities.style.display = 'none';
    activityIndex++;
    updateSummary();
}

// Remove activity
function removeActivity(button) {
    const activity = button.closest('.activity-item');
    activity.remove();
    
    const container = document.getElementById('activitiesContainer');
    const noActivities = document.getElementById('noActivities');
    const remaining = container.querySelectorAll('.activity-item').length;
    
    if (remaining === 0) {
        noActivities.style.display = 'block';
    }
    updateSummary();
}

// Filter departments by filiale/agence
function filterDepartments() {
    const filialeId = document.getElementById('filialeSelect').value;
    const agenceId = document.getElementById('agenceSelect').value;
    const deptLabels = document.querySelectorAll('label[data-filiale]');
    
    deptLabels.forEach(label => {
        const deptFiliale = label.getAttribute('data-filiale');
        const deptAgence = label.getAttribute('data-agence');
        let show = true;
        
        if (filialeId && deptFiliale !== filialeId) {
            show = false;
        }
        
        if (agenceId && deptAgence !== agenceId) {
            show = false;
        }
        
        label.style.display = show ? 'flex' : 'none';
        if (!show) {
            label.querySelector('.department-checkbox').checked = false;
        }
    });
    
    updateDeptCount();
}

// Filter agences by filiale
function filterAgences() {
    const filialeId = document.getElementById('filialeSelect').value;
    const agenceSelect = document.getElementById('agenceSelect');
    const options = agenceSelect.querySelectorAll('option[data-filiale]');
    
    agenceSelect.value = '';
    
    options.forEach(option => {
        const optFiliale = option.getAttribute('data-filiale');
        if (!filialeId || optFiliale === filialeId) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });
    
    filterDepartments();
}

// Update department count
function updateDeptCount() {
    const checked = document.querySelectorAll('.department-checkbox:checked').length;
    document.getElementById('deptCount').textContent = `${checked} sélectionné(s)`;
    updateSummary();
}

// Update summary
function updateSummary() {
    const months = document.querySelectorAll('.month-checkbox:checked').length;
    const depts = document.querySelectorAll('.department-checkbox:checked').length;
    const activities = document.querySelectorAll('.activity-item').length;
    const total = months * depts * activities;
    
    document.getElementById('summaryMonths').textContent = months;
    document.getElementById('summaryDepts').textContent = depts;
    document.getElementById('summaryActivities').textContent = activities;
    document.getElementById('summaryTotal').textContent = total;
    
    const exampleCalc = document.getElementById('exampleCalc');
    if (total > 0) {
        exampleCalc.textContent = `Exemple : ${months} mois × ${depts} départements × ${activities} activités = ${total} activités à créer.`;
    } else {
        exampleCalc.textContent = '';
    }
}

// Init
document.addEventListener('DOMContentLoaded', function() {
    // Filiale change
    document.getElementById('filialeSelect').addEventListener('change', filterAgences);
    
    // Agence change
    document.getElementById('agenceSelect').addEventListener('change', filterDepartments);
    
    // Select all departments
    document.getElementById('selectAllDepts').addEventListener('change', function() {
        const visible = document.querySelectorAll('label[data-filiale]:not([style*="display: none"]) .department-checkbox');
        visible.forEach(cb => cb.checked = this.checked);
        updateDeptCount();
    });
    
    // Individual department checkbox
    document.querySelectorAll('.department-checkbox').forEach(cb => {
        cb.addEventListener('change', updateDeptCount);
    });
    
    // Month checkboxes
    document.querySelectorAll('.month-checkbox').forEach(cb => {
        cb.addEventListener('change', updateSummary);
    });
    
    // Initialize
    filterAgences();
    updateSummary();
});
</script>

<style>
@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-gradient {
    animation: gradient 3s ease infinite;
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #D4AF37;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #B8941F;
}
</style>
@endsection
