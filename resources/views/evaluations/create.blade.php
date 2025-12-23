@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="max-w-5xl mx-auto">
        <div class="bg-gradient-to-br from-neutral-900 to-black border border-neutral-800 rounded-2xl shadow-2xl p-8">
            <h1 class="text-2xl font-bold mb-6">Nouvelle Évaluation</h1>

            <form action="{{ route('evaluations.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Type d'évaluation -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Type d'Évaluation *</label>
                        <select name="type" id="evaluation_type" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" required>
                            <option value="">Sélectionner</option>
                            <option value="projet" {{ old('type', $type) == 'projet' ? 'selected' : '' }}>Projet</option>
                            <option value="tâche" {{ old('type', $type) == 'tâche' ? 'selected' : '' }}>Tâche</option>
                            <option value="employé" {{ old('type', $type) == 'employé' ? 'selected' : '' }}>Employé</option>
                            <option value="mission" {{ old('type', $type) == 'mission' ? 'selected' : '' }}>Mission</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sélection Projet -->
                    <div id="projet_select" style="display: {{ old('type', $type) == 'projet' ? 'block' : 'none' }}">
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Projet *</label>
                        <select name="project_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                            <option value="">Sélectionner un projet</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('evaluable_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="evaluable_type_projet" value="App\Models\Project">
                    </div>

                    <!-- Sélection Tâche -->
                    <div id="tache_select" style="display: {{ old('type', $type) == 'tâche' ? 'block' : 'none' }}">
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Tâche *</label>
                        <select name="task_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                            <option value="">Sélectionner une tâche</option>
                            @foreach($tasks as $task)
                                <option value="{{ $task->id }}" {{ old('evaluable_id') == $task->id ? 'selected' : '' }}>
                                    {{ $task->title }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="evaluable_type_tache" value="App\Models\Task">
                    </div>

                    <!-- Sélection Employé -->
                    <div id="employe_select" style="display: {{ old('type', $type) == 'employé' ? 'block' : 'none' }}">
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Employé *</label>
                        <select name="evaluated_user_id" class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
                            <option value="">Sélectionner un employé</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('evaluated_user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="evaluable_type_employe" value="App\Models\User">
                    </div>

                    <!-- Note -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Note (0-100) *</label>
                        <input type="number" name="note" value="{{ old('note') }}" min="0" max="100" 
                               class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" required>
                        <p class="text-xs text-gray-500 mt-1">0 = Très faible, 100 = Excellent</p>
                        @error('note')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Commentaires -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Commentaires</label>
                        <textarea name="commentaires" rows="4" 
                                  class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" 
                                  placeholder="Vos commentaires généraux...">{{ old('commentaires') }}</textarea>
                        @error('commentaires')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Points Forts -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Points Forts</label>
                        <textarea name="points_forts" rows="3" 
                                  class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:ring-2 focus:ring-green-500" 
                                  placeholder="Les aspects positifs...">{{ old('points_forts') }}</textarea>
                        @error('points_forts')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Points d'Amélioration -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Points d'Amélioration</label>
                        <textarea name="points_amelioration" rows="3" 
                                  class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:ring-2 focus:ring-orange-500" 
                                  placeholder="Les aspects à améliorer...">{{ old('points_amelioration') }}</textarea>
                        @error('points_amelioration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Recommandations -->
                    <div>
                        <label class="block text-sm font-medium text-[#D4AF37] mb-2">Recommandations</label>
                        <textarea name="recommandations" rows="3" 
                                  class="w-full bg-neutral-800 border border-neutral-700 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" 
                                  placeholder="Vos recommandations...">{{ old('recommandations') }}</textarea>
                        @error('recommandations')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('evaluations.index') }}" 
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('evaluation_type');
    const projetDiv = document.getElementById('projet_select');
    const tacheDiv = document.getElementById('tache_select');
    const employeDiv = document.getElementById('employe_select');

    typeSelect.addEventListener('change', function() {
        projetDiv.style.display = 'none';
        tacheDiv.style.display = 'none';
        employeDiv.style.display = 'none';

        if (this.value === 'projet') {
            projetDiv.style.display = 'block';
        } else if (this.value === 'tâche') {
            tacheDiv.style.display = 'block';
        } else if (this.value === 'employé') {
            employeDiv.style.display = 'block';
        }
    });

    // Gérer la soumission pour définir evaluable_type et evaluable_id
    document.querySelector('form').addEventListener('submit', function(e) {
        const type = typeSelect.value;
        
        if (type === 'projet') {
            const projectId = document.querySelector('select[name="project_id"]').value;
            if (projectId) {
                const input1 = document.createElement('input');
                input1.type = 'hidden';
                input1.name = 'evaluable_type';
                input1.value = 'App\\Models\\Project';
                this.appendChild(input1);
                
                const input2 = document.createElement('input');
                input2.type = 'hidden';
                input2.name = 'evaluable_id';
                input2.value = projectId;
                this.appendChild(input2);
            }
        } else if (type === 'tâche') {
            const taskId = document.querySelector('select[name="task_id"]').value;
            if (taskId) {
                const input1 = document.createElement('input');
                input1.type = 'hidden';
                input1.name = 'evaluable_type';
                input1.value = 'App\\Models\\Task';
                this.appendChild(input1);
                
                const input2 = document.createElement('input');
                input2.type = 'hidden';
                input2.name = 'evaluable_id';
                input2.value = taskId;
                this.appendChild(input2);
            }
        } else if (type === 'employé') {
            const userId = document.querySelector('select[name="evaluated_user_id"]').value;
            if (userId) {
                const input1 = document.createElement('input');
                input1.type = 'hidden';
                input1.name = 'evaluable_type';
                input1.value = 'App\\Models\\User';
                this.appendChild(input1);
                
                const input2 = document.createElement('input');
                input2.type = 'hidden';
                input2.name = 'evaluable_id';
                input2.value = userId;
                this.appendChild(input2);
            }
        }
    });
});
</script>
@endsection
