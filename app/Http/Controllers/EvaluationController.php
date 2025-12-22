<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Evaluation::with(['evaluable', 'evaluateur', 'evaluatedUser']);

        // Filtres
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('evaluateur_id')) {
            $query->where('evaluateur_id', $request->evaluateur_id);
        }

        $evaluations = $query->latest()->paginate(20);

        $stats = [
            'total' => Evaluation::count(),
            'ce_mois' => Evaluation::recent(30)->count(),
            'projets' => Evaluation::byType('projet')->count(),
            'taches' => Evaluation::byType('tâche')->count(),
        ];

        $evaluateurs = User::all();

        return view('evaluations.index', compact('evaluations', 'stats', 'evaluateurs'));
    }

    public function create(Request $request)
    {
        $type = $request->get('type', 'tâche');
        $evaluableId = $request->get('evaluable_id');
        
        $evaluable = null;
        
        if ($evaluableId) {
            switch ($type) {
                case 'projet':
                    $evaluable = Project::find($evaluableId);
                    break;
                case 'tâche':
                    $evaluable = Task::find($evaluableId);
                    break;
            }
        }

        $projects = Project::all();
        $tasks = Task::all();
        $users = User::all();

        return view('evaluations.create', compact('type', 'evaluable', 'projects', 'tasks', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:projet,tâche,employé,mission',
            'evaluable_type' => 'required|string',
            'evaluable_id' => 'required|integer',
            'note' => 'required|integer|min:0|max:100',
            'commentaires' => 'nullable|string',
            'points_forts' => 'nullable|string',
            'points_amelioration' => 'nullable|string',
            'recommandations' => 'nullable|string',
            'evaluated_user_id' => 'nullable|exists:users,id',
        ]);

        $validated['evaluateur_id'] = auth()->id();

        Evaluation::create($validated);

        return redirect()->route('evaluations.index')
            ->with('success', 'Évaluation créée avec succès.');
    }

    public function show(Evaluation $evaluation)
    {
        $evaluation->load(['evaluable', 'evaluateur', 'evaluatedUser']);
        
        return view('evaluations.show', compact('evaluation'));
    }

    public function edit(Evaluation $evaluation)
    {
        $user = auth()->user();

        // Seul l'évaluateur ou un admin peut modifier
        if ($evaluation->evaluateur_id !== $user->id && !$user->hasRole('superadmin')) {
            abort(403, 'Accès non autorisé.');
        }

        $projects = Project::all();
        $tasks = Task::all();
        $users = User::all();

        return view('evaluations.edit', compact('evaluation', 'projects', 'tasks', 'users'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $user = auth()->user();

        if ($evaluation->evaluateur_id !== $user->id && !$user->hasRole('superadmin')) {
            abort(403, 'Accès non autorisé.');
        }

        $validated = $request->validate([
            'type' => 'required|in:projet,tâche,employé,mission',
            'note' => 'required|integer|min:0|max:100',
            'commentaires' => 'nullable|string',
            'points_forts' => 'nullable|string',
            'points_amelioration' => 'nullable|string',
            'recommandations' => 'nullable|string',
            'evaluated_user_id' => 'nullable|exists:users,id',
        ]);

        $evaluation->update($validated);

        return redirect()->route('evaluations.show', $evaluation)
            ->with('success', 'Évaluation mise à jour avec succès.');
    }

    public function destroy(Evaluation $evaluation)
    {
        $user = auth()->user();

        if ($evaluation->evaluateur_id !== $user->id && !$user->hasRole('superadmin')) {
            abort(403, 'Accès non autorisé.');
        }

        $evaluation->delete();

        return redirect()->route('evaluations.index')
            ->with('success', 'Évaluation supprimée avec succès.');
    }
}
