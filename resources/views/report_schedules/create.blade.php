@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Nouveau Calendrier de Rapport</h1>

            <form action="{{ route('report_schedules.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Nom -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom du Calendrier *</label>
                        <input type="text" name="nom" value="{{ old('nom') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" 
                               placeholder="Ex: Rapport journalier RH" required>
                        @error('nom')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type de rapport -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type de Rapport *</label>
                        <select name="type_rapport" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="">Sélectionner</option>
                            <option value="journalier" {{ old('type_rapport') == 'journalier' ? 'selected' : '' }}>Journalier</option>
                            <option value="hebdomadaire" {{ old('type_rapport') == 'hebdomadaire' ? 'selected' : '' }}>Hebdomadaire</option>
                            <option value="mensuel" {{ old('type_rapport') == 'mensuel' ? 'selected' : '' }}>Mensuel</option>
                        </select>
                        @error('type_rapport')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fréquence -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fréquence *</label>
                        <select name="frequence" id="frequence" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="">Sélectionner</option>
                            <option value="daily" {{ old('frequence') == 'daily' ? 'selected' : '' }}>Quotidienne</option>
                            <option value="weekly" {{ old('frequence') == 'weekly' ? 'selected' : '' }}>Hebdomadaire</option>
                            <option value="monthly" {{ old('frequence') == 'monthly' ? 'selected' : '' }}>Mensuelle</option>
                        </select>
                        @error('frequence')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jour de la semaine (pour hebdomadaire) -->
                    <div id="jour_semaine_div" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jour de la Semaine</label>
                        <select name="jour_semaine" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="">Sélectionner</option>
                            <option value="1" {{ old('jour_semaine') == '1' ? 'selected' : '' }}>Lundi</option>
                            <option value="2" {{ old('jour_semaine') == '2' ? 'selected' : '' }}>Mardi</option>
                            <option value="3" {{ old('jour_semaine') == '3' ? 'selected' : '' }}>Mercredi</option>
                            <option value="4" {{ old('jour_semaine') == '4' ? 'selected' : '' }}>Jeudi</option>
                            <option value="5" {{ old('jour_semaine') == '5' ? 'selected' : '' }}>Vendredi</option>
                            <option value="6" {{ old('jour_semaine') == '6' ? 'selected' : '' }}>Samedi</option>
                            <option value="7" {{ old('jour_semaine') == '7' ? 'selected' : '' }}>Dimanche</option>
                        </select>
                    </div>

                    <!-- Jour du mois (pour mensuel) -->
                    <div id="jour_mois_div" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jour du Mois (1-31)</label>
                        <input type="number" name="jour_mois" value="{{ old('jour_mois') }}" min="1" max="31"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <p class="text-xs text-gray-500 mt-1">Pour les mois ayant moins de jours, ce sera le dernier jour du mois</p>
                    </div>

                    <!-- Heure d'échéance -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Heure d'Échéance</label>
                        <input type="time" name="heure_echeance" value="{{ old('heure_echeance', '17:00') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        @error('heure_echeance')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Département -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Département *</label>
                        <select name="department_id" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="">Sélectionner</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Responsable -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Responsable</label>
                        <select name="responsable_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="">Sélectionner</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('responsable_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filiale & Agence -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filiale</label>
                            <select name="filiale_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                <option value="">Maison Mère</option>
                                @foreach($filiales as $filiale)
                                    <option value="{{ $filiale->id }}" {{ old('filiale_id') == $filiale->id ? 'selected' : '' }}>
                                        {{ $filiale->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Agence</label>
                            <select name="agence_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                <option value="">Aucune</option>
                                @foreach($agences as $agence)
                                    <option value="{{ $agence->id }}" {{ old('agence_id') == $agence->id ? 'selected' : '' }}>
                                        {{ $agence->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Actif -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm font-medium text-gray-700">Calendrier actif</span>
                        </label>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('report_schedules.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const frequenceSelect = document.getElementById('frequence');
    const jourSemaineDiv = document.getElementById('jour_semaine_div');
    const jourMoisDiv = document.getElementById('jour_mois_div');

    function updateVisibility() {
        const frequence = frequenceSelect.value;
        
        jourSemaineDiv.style.display = 'none';
        jourMoisDiv.style.display = 'none';

        if (frequence === 'weekly') {
            jourSemaineDiv.style.display = 'block';
        } else if (frequence === 'monthly') {
            jourMoisDiv.style.display = 'block';
        }
    }

    frequenceSelect.addEventListener('change', updateVisibility);
    updateVisibility(); // Initial call
});
</script>
@endsection
