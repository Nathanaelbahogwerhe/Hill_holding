@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="max-w-5xl mx-auto">
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8">
            <h1 class="text-2xl font-bold mb-6">Modifier le Rapport Journalier</h1>

            <form action="{{ route('daily_operations.update', $dailyOperation) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Date -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Date *</label>
                        <input type="date" name="date" value="{{ old('date', $dailyOperation->date) }}" 
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" required>
                        @error('date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Activités Réalisées -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Activités Réalisées *</label>
                        <textarea name="activites_realisees" rows="4" 
                                  class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" 
                                  placeholder="Décrivez les activités réalisées..." required>{{ old('activites_realisees', $dailyOperation->activites_realisees) }}</textarea>
                        @error('activites_realisees')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Problèmes Rencontrés -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Problèmes Rencontrés</label>
                        <textarea name="problemes_rencontres" rows="3" 
                                  class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:ring-2 focus:ring-yellow-500" 
                                  placeholder="Décrivez les problèmes rencontrés...">{{ old('problemes_rencontres', $dailyOperation->problemes_rencontres) }}</textarea>
                        @error('problemes_rencontres')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Solutions Apportées -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Solutions Apportées</label>
                        <textarea name="solutions_apportees" rows="3" 
                                  class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:ring-2 focus:ring-green-500" 
                                  placeholder="Décrivez les solutions mises en place...">{{ old('solutions_apportees', $dailyOperation->solutions_apportees) }}</textarea>
                        @error('solutions_apportees')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prévisions du Lendemain -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Prévisions du Lendemain</label>
                        <textarea name="previsions_lendemain" rows="3" 
                                  class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" 
                                  placeholder="Activités prévues...">{{ old('previsions_lendemain', $dailyOperation->previsions_lendemain) }}</textarea>
                        @error('previsions_lendemain')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nombre de Personnel & Observations -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#D4AF37] mb-2">Nombre de Personnel</label>
                            <input type="number" name="nombre_personnel" value="{{ old('nombre_personnel', $dailyOperation->nombre_personnel) }}" min="0"
                                   class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                            @error('nombre_personnel')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Observations -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Observations</label>
                        <textarea name="observations" rows="2" 
                                  class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">{{ old('observations', $dailyOperation->observations) }}</textarea>
                    </div>

                    <!-- Associations -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#D4AF37] mb-2">Projet</label>
                            <select name="project_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                                <option value="">Aucun</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $dailyOperation->project_id) == $project->id ? 'selected' : '' }}>
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
                                    <option value="{{ $dept->id }}" {{ old('department_id', $dailyOperation->department_id) == $dept->id ? 'selected' : '' }}>
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
                                    <option value="{{ $filiale->id }}" {{ old('filiale_id', $dailyOperation->filiale_id) == $filiale->id ? 'selected' : '' }}>
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
                                    <option value="{{ $agence->id }}" {{ old('agence_id', $dailyOperation->agence_id) == $agence->id ? 'selected' : '' }}>
                                        {{ $agence->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Pièces jointes existantes -->
                    @if($dailyOperation->attachments)
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Pièces Jointes Actuelles</label>
                        <div class="space-y-2">
                            @foreach(json_decode($dailyOperation->attachments, true) as $attachment)
                                <a href="{{ Storage::url($attachment) }}" target="_blank"
                                   class="flex items-center text-white hover:text-blue-800 text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                    {{ basename($attachment) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Nouveaux fichiers -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Ajouter des Pièces Jointes</label>
                        <input type="file" name="attachments[]" multiple
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <p class="text-xs text-gray-500 mt-1">Formats acceptés: PDF, Word, Excel, Images. Max 10Mo par fichier.</p>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('daily_operations.index') }}" 
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
