@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Modifier l'Évaluation</h1>

            <form action="{{ route('evaluations.update', $evaluation) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type d'Évaluation *</label>
                        <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2" required disabled>
                            <option value="projet" {{ $evaluation->type == 'projet' ? 'selected' : '' }}>Projet</option>
                            <option value="tâche" {{ $evaluation->type == 'tâche' ? 'selected' : '' }}>Tâche</option>
                            <option value="employé" {{ $evaluation->type == 'employé' ? 'selected' : '' }}>Employé</option>
                            <option value="mission" {{ $evaluation->type == 'mission' ? 'selected' : '' }}>Mission</option>
                        </select>
                        <input type="hidden" name="type" value="{{ $evaluation->type }}">
                        <p class="text-xs text-gray-500 mt-1">Le type ne peut pas être modifié</p>
                    </div>

                    <!-- Entité évaluée -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Entité Évaluée</label>
                        <p class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-gray-700">
                            @if($evaluation->evaluable)
                                {{ $evaluation->evaluable->name ?? $evaluation->evaluable->titre ?? $evaluation->evaluable->title ?? 'N/A' }}
                            @else
                                N/A
                            @endif
                        </p>
                        <p class="text-xs text-gray-500 mt-1">L'entité ne peut pas être modifiée</p>
                    </div>

                    <!-- Note -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Note (0-100) *</label>
                        <input type="number" name="note" value="{{ old('note', $evaluation->note) }}" min="0" max="100" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        <p class="text-xs text-gray-500 mt-1">0 = Très faible, 100 = Excellent</p>
                        @error('note')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Commentaires -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Commentaires</label>
                        <textarea name="commentaires" rows="4" 
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" 
                                  placeholder="Vos commentaires généraux...">{{ old('commentaires', $evaluation->commentaires) }}</textarea>
                        @error('commentaires')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Points Forts -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Points Forts</label>
                        <textarea name="points_forts" rows="3" 
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" 
                                  placeholder="Les aspects positifs...">{{ old('points_forts', $evaluation->points_forts) }}</textarea>
                        @error('points_forts')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Points d'Amélioration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Points d'Amélioration</label>
                        <textarea name="points_amelioration" rows="3" 
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500" 
                                  placeholder="Les aspects à améliorer...">{{ old('points_amelioration', $evaluation->points_amelioration) }}</textarea>
                        @error('points_amelioration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Recommandations -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recommandations</label>
                        <textarea name="recommandations" rows="3" 
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" 
                                  placeholder="Vos recommandations...">{{ old('recommandations', $evaluation->recommandations) }}</textarea>
                        @error('recommandations')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($evaluation->type == 'employé')
                    <!-- Employé évalué -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Employé Évalué</label>
                        <select name="evaluated_user_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="">Sélectionner un employé</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('evaluated_user_id', $evaluation->evaluated_user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('evaluations.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
