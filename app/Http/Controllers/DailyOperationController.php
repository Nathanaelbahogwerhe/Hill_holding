<?php

namespace App\Http\Controllers;

use App\Models\DailyOperation;
use App\Models\Project;
use App\Models\Department;
use App\Models\Filiale;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DailyOperationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = DailyOperation::with(['project', 'department', 'filiale', 'agence', 'soumetteur']);

        // Filtrage hiérarchique
        if ($user->hasRole('superadmin')) {
            // Voir tout
        } elseif ($user->filiale_id && !$user->agence_id) {
            $query->where('filiale_id', $user->filiale_id);
        } elseif ($user->agence_id) {
            $query->where('agence_id', $user->agence_id);
        } else {
            $query->where('soumis_par', $user->id);
        }

        // Filtres
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('date_debut')) {
            $query->where('date', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->where('date', '<=', $request->date_fin);
        }

        $operations = $query->latest('date')->paginate(20);

        $stats = [
            'total' => DailyOperation::count(),
            'aujourd_hui' => DailyOperation::today()->count(),
            'cette_semaine' => DailyOperation::thisWeek()->count(),
            'ce_mois' => DailyOperation::thisMonth()->count(),
        ];

        $projects = Project::all();
        $departments = Department::all();

        return view('daily_operations.index', compact('operations', 'stats', 'projects', 'departments'));
    }

    public function create()
    {
        $user = auth()->user();
        
        $projects = Project::all();
        $departments = Department::all();
        $filiales = Filiale::all();
        
        if ($user->filiale_id) {
            $agences = Agence::where('filiale_id', $user->filiale_id)->get();
        } else {
            $agences = Agence::all();
        }

        return view('daily_operations.create', compact('projects', 'departments', 'filiales', 'agences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'activites_realisees' => 'required|string',
            'problemes_rencontres' => 'nullable|string',
            'solutions_apportees' => 'nullable|string',
            'previsions_lendemain' => 'nullable|string',
            'nombre_personnel' => 'nullable|integer|min:0',
            'observations' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'department_id' => 'nullable|exists:departments,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        $validated['soumis_par'] = auth()->id();

        // Gérer les fichiers
        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $attachments[] = $file->store('daily_operations/attachments', 'public');
            }
            $validated['attachments'] = json_encode($attachments);
        }

        DailyOperation::create($validated);

        return redirect()->route('daily_operations.index')
            ->with('success', 'Opération journalière enregistrée avec succès.');
    }

    public function show(DailyOperation $dailyOperation)
    {
        $dailyOperation->load(['project', 'department', 'filiale', 'agence', 'soumetteur']);
        
        return view('daily_operations.show', compact('dailyOperation'));
    }

    public function edit(DailyOperation $dailyOperation)
    {
        $user = auth()->user();

        // Seul l'auteur ou un admin peut modifier
        if ($dailyOperation->soumis_par !== $user->id && !$user->hasRole('superadmin')) {
            abort(403, 'Accès non autorisé.');
        }
        
        $projects = Project::all();
        $departments = Department::all();
        $filiales = Filiale::all();
        
        if ($user->filiale_id) {
            $agences = Agence::where('filiale_id', $user->filiale_id)->get();
        } else {
            $agences = Agence::all();
        }

        return view('daily_operations.edit', compact('dailyOperation', 'projects', 'departments', 'filiales', 'agences'));
    }

    public function update(Request $request, DailyOperation $dailyOperation)
    {
        $user = auth()->user();

        if ($dailyOperation->soumis_par !== $user->id && !$user->hasRole('superadmin')) {
            abort(403, 'Accès non autorisé.');
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'activites_realisees' => 'required|string',
            'problemes_rencontres' => 'nullable|string',
            'solutions_apportees' => 'nullable|string',
            'previsions_lendemain' => 'nullable|string',
            'nombre_personnel' => 'nullable|integer|min:0',
            'observations' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'department_id' => 'nullable|exists:departments,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        // Gérer les nouveaux fichiers
        if ($request->hasFile('attachments')) {
            $existingAttachments = json_decode($dailyOperation->attachments, true) ?? [];
            
            foreach ($request->file('attachments') as $file) {
                $existingAttachments[] = $file->store('daily_operations/attachments', 'public');
            }
            
            $validated['attachments'] = json_encode($existingAttachments);
        }

        $dailyOperation->update($validated);

        return redirect()->route('daily_operations.show', $dailyOperation)
            ->with('success', 'Opération mise à jour avec succès.');
    }

    public function destroy(DailyOperation $dailyOperation)
    {
        $user = auth()->user();

        if ($dailyOperation->soumis_par !== $user->id && !$user->hasRole('superadmin')) {
            abort(403, 'Accès non autorisé.');
        }

        // Supprimer les fichiers
        if ($dailyOperation->attachments) {
            $attachments = json_decode($dailyOperation->attachments, true);
            foreach ($attachments as $attachment) {
                if (Storage::disk('public')->exists($attachment)) {
                    Storage::disk('public')->delete($attachment);
                }
            }
        }

        $dailyOperation->delete();

        return redirect()->route('daily_operations.index')
            ->with('success', 'Opération supprimée avec succès.');
    }
}
