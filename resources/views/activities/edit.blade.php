@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="max-w-5xl mx-auto">
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8">
            <h1 class="text-2xl font-bold mb-6">Modifier l'Activité</h1>

            <form action="{{ route('activities.update', $activity) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Titre -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Titre *</label>
                        <input type="text" name="titre" value="{{ old('titre', $activity->titre) }}" 
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" required>
                        @error('titre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Type *</label>
                        <select name="type" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" required>
                            <option value="">Sélectionner</option>
                            <option value="réunion" {{ old('type', $activity->type) == 'réunion' ? 'selected' : '' }}>Réunion</option>
                            <option value="formation" {{ old('type', $activity->type) == 'formation' ? 'selected' : '' }}>Formation</option>
                            <option value="mission" {{ old('type', $activity->type) == 'mission' ? 'selected' : '' }}>Mission</option>
                            <option value="événement" {{ old('type', $activity->type) == 'événement' ? 'selected' : '' }}>Événement</option>
                            <option value="autre" {{ old('type', $activity->type) == 'autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Description</label>
                        <textarea name="description" rows="4" 
                                  class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">{{ old('description', $activity->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date et Heures -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#D4AF37] mb-2">Date Prévue *</label>
                            <input type="date" name="date_prevue" value="{{ old('date_prevue', $activity->date_prevue) }}" 
                                   class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" required>
                            @error('date_prevue')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#D4AF37] mb-2">Heure Début</label>
                            <input type="time" name="heure_debut" value="{{ old('heure_debut', $activity->heure_debut) }}" 
                                   class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                            @error('heure_debut')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#D4AF37] mb-2">Heure Fin</label>
                            <input type="time" name="heure_fin" value="{{ old('heure_fin', $activity->heure_fin) }}" 
                                   class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                            @error('heure_fin')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Lieu -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Lieu</label>
                        <input type="text" name="lieu" value="{{ old('lieu', $activity->lieu) }}" 
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                        @error('lieu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Statut *</label>
                        <select name="statut" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" required>
                            <option value="planifiée" {{ old('statut', $activity->statut) == 'planifiée' ? 'selected' : '' }}>Planifiée</option>
                            <option value="en_cours" {{ old('statut', $activity->statut) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="terminée" {{ old('statut', $activity->statut) == 'terminée' ? 'selected' : '' }}>Terminée</option>
                            <option value="annulée" {{ old('statut', $activity->statut) == 'annulée' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>

                    <!-- Participants -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Participants</label>
                        <select name="participants[]" multiple class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" size="5">
                            @php
                                $selectedParticipants = json_decode($activity->participants, true) ?? [];
                            @endphp
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ in_array($user->id, $selectedParticipants) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs personnes</p>
                    </div>

                    <!-- Associations -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#D4AF37] mb-2">Projet</label>
                            <select name="project_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                                <option value="">Aucun</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $activity->project_id) == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#D4AF37] mb-2">Département</label>
                            <select name="department_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                                <option value="">Aucun</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id', $activity->department_id) == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Filiale & Agence -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#D4AF37] mb-2">Filiale</label>
                            <select name="filiale_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                                <option value="">Maison Mère</option>
                                @foreach($filiales as $filiale)
                                    <option value="{{ $filiale->id }}" {{ old('filiale_id', $activity->filiale_id) == $filiale->id ? 'selected' : '' }}>
                                        {{ $filiale->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#D4AF37] mb-2">Agence</label>
                            <select name="agence_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                                <option value="">Aucune</option>
                                @foreach($agences as $agence)
                                    <option value="{{ $agence->id }}" {{ old('agence_id', $activity->agence_id) == $agence->id ? 'selected' : '' }}>
                                        {{ $agence->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('activities.index') }}" 
                       class="px-4 py-2 border border-neutral-700 rounded-xl hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
