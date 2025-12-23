@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="max-w-5xl mx-auto">
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8">
            <h1 class="text-2xl font-bold mb-6">Nouveau Rapport</h1>

            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Titre -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Titre *</label>
                        <input type="text" name="titre" value="{{ old('titre') }}" 
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" required>
                        @error('titre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Type *</label>
                        <select name="type" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" required>
                            <option value="">Sélectionner un type</option>
                            <option value="journalier" {{ old('type') == 'journalier' ? 'selected' : '' }}>Journalier</option>
                            <option value="hebdomadaire" {{ old('type') == 'hebdomadaire' ? 'selected' : '' }}>Hebdomadaire</option>
                            <option value="mensuel" {{ old('type') == 'mensuel' ? 'selected' : '' }}>Mensuel</option>
                            <option value="projet" {{ old('type') == 'projet' ? 'selected' : '' }}>Projet</option>
                            <option value="mission" {{ old('type') == 'mission' ? 'selected' : '' }}>Mission</option>
                            <option value="département" {{ old('type') == 'département' ? 'selected' : '' }}>Département</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#D4AF37] mb-2">Date Début</label>
                            <input type="date" name="date_debut" value="{{ old('date_debut') }}" 
                                   class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                            @error('date_debut')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#D4AF37] mb-2">Date Fin</label>
                            <input type="date" name="date_fin" value="{{ old('date_fin') }}" 
                                   class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                            @error('date_fin')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Contenu *</label>
                        <textarea name="contenu" rows="8" 
                                  class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" required>{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Projet -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Projet</label>
                        <select name="project_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                            <option value="">Aucun</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Département -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Département</label>
                        <select name="department_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                            <option value="">Aucun</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filiale & Agence -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#D4AF37] mb-2">Filiale</label>
                            <select name="filiale_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                                <option value="">Maison Mère</option>
                                @foreach($filiales as $filiale)
                                    <option value="{{ $filiale->id }}" {{ old('filiale_id') == $filiale->id ? 'selected' : '' }}>
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
                                    <option value="{{ $agence->id }}" {{ old('agence_id') == $agence->id ? 'selected' : '' }}>
                                        {{ $agence->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Fichiers -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Pièces Jointes</label>
                        <input type="file" name="attachments[]" multiple
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <p class="text-xs text-gray-500 mt-1">Formats acceptés: PDF, Word, Excel, Images. Max 10Mo par fichier.</p>
                    </div>

                    <!-- Statut -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Action</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="statut" value="brouillon" checked class="mr-2">
                                <span>Enregistrer en brouillon</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="statut" value="soumis" class="mr-2">
                                <span>Soumettre pour validation</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('reports.index') }}" 
                       class="px-4 py-2 border border-neutral-700 rounded-xl hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-[#D4AF37]/50">
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
