@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Nouveau Rapport</h1>

            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Titre -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                        <input type="text" name="titre" value="{{ old('titre') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        @error('titre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                        <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date Début</label>
                            <input type="date" name="date_debut" value="{{ old('date_debut') }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            @error('date_debut')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date Fin</label>
                            <input type="date" name="date_fin" value="{{ old('date_fin') }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            @error('date_fin')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contenu *</label>
                        <textarea name="contenu" rows="8" 
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Projet -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Projet</label>
                        <select name="project_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Département</label>
                        <select name="department_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
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

                    <!-- Fichiers -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pièces Jointes</label>
                        <input type="file" name="attachments[]" multiple
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <p class="text-xs text-gray-500 mt-1">Formats acceptés: PDF, Word, Excel, Images. Max 10Mo par fichier.</p>
                    </div>

                    <!-- Statut -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
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
@endsection
