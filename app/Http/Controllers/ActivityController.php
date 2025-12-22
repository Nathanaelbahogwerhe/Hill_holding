<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Project;
use App\Models\Department;
use App\Models\User;
use App\Models\Filiale;
use App\Models\Agence;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Activity::with(['project', 'department', 'filiale', 'agence', 'creator']);

        // Filtrage hiérarchique
        if ($user->hasRole('superadmin')) {
            // Voir tout
        } elseif ($user->filiale_id && !$user->agence_id) {
            $query->where('filiale_id', $user->filiale_id);
        } elseif ($user->agence_id) {
            $query->where('agence_id', $user->agence_id);
        }

        // Filtres
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('date_debut')) {
            $query->where('date_prevue', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->where('date_prevue', '<=', $request->date_fin);
        }

        $activities = $query->orderBy('date_prevue', 'desc')->paginate(20);

        $stats = [
            'total' => Activity::count(),
            'aujourd_hui' => Activity::today()->count(),
            'a_venir' => Activity::upcoming(7)->planifiee()->count(),
            'terminees' => Activity::where('statut', 'terminée')->count(),
        ];

        $projects = Project::all();
        $departments = Department::all();

        return view('activities.index', compact('activities', 'stats', 'projects', 'departments'));
    }

    public function create()
    {
        $user = auth()->user();
        
        $projects = Project::all();
        $departments = Department::all();
        $users = User::all();
        $filiales = Filiale::all();
        
        if ($user->filiale_id) {
            $agences = Agence::where('filiale_id', $user->filiale_id)->get();
        } else {
            $agences = Agence::all();
        }

        return view('activities.create', compact('projects', 'departments', 'users', 'filiales', 'agences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:réunion,formation,mission,événement,autre',
            'date_prevue' => 'required|date',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i|after:heure_debut',
            'lieu' => 'nullable|string|max:255',
            'statut' => 'required|in:planifiée,en_cours,terminée,annulée',
            'participants' => 'nullable|array',
            'project_id' => 'nullable|exists:projects,id',
            'department_id' => 'nullable|exists:departments,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['participants'] = json_encode($validated['participants'] ?? []);

        Activity::create($validated);

        return redirect()->route('activities.index')
            ->with('success', 'Activité créée avec succès.');
    }

    public function show(Activity $activity)
    {
        $activity->load(['project', 'department', 'filiale', 'agence', 'creator']);
        
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        $user = auth()->user();
        
        $projects = Project::all();
        $departments = Department::all();
        $users = User::all();
        $filiales = Filiale::all();
        
        if ($user->filiale_id) {
            $agences = Agence::where('filiale_id', $user->filiale_id)->get();
        } else {
            $agences = Agence::all();
        }

        return view('activities.edit', compact('activity', 'projects', 'departments', 'users', 'filiales', 'agences'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:réunion,formation,mission,événement,autre',
            'date_prevue' => 'required|date',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i|after:heure_debut',
            'lieu' => 'nullable|string|max:255',
            'statut' => 'required|in:planifiée,en_cours,terminée,annulée',
            'participants' => 'nullable|array',
            'project_id' => 'nullable|exists:projects,id',
            'department_id' => 'nullable|exists:departments,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
        ]);

        $validated['participants'] = json_encode($validated['participants'] ?? []);

        $activity->update($validated);

        return redirect()->route('activities.show', $activity)
            ->with('success', 'Activité mise à jour avec succès.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('activities.index')
            ->with('success', 'Activité supprimée avec succès.');
    }

    public function planning(Request $request)
    {
        $user = auth()->user();
        
        // Filtre par défaut : mensuel (mois actuel)
        $filter = $request->input('filter', 'mensuel');
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);
        $semester = (int) $request->input('semester', 1);
        
        // Définir la période selon le filtre
        switch ($filter) {
            case 'journalier':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                $periods = [now()->format('d/m/Y')];
                break;
                
            case 'mensuel':
                $startDate = now()->setYear($year)->setMonth($month)->startOfMonth();
                $endDate = $startDate->copy()->endOfMonth();
                $periods = [$startDate->format('F Y')];
                break;
                
            case 'semestriel':
                if ($semester == 1) {
                    $startDate = now()->setYear($year)->setMonth(1)->startOfMonth();
                    $endDate = now()->setYear($year)->setMonth(6)->endOfMonth();
                    $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin'];
                } else {
                    $startDate = now()->setYear($year)->setMonth(7)->startOfMonth();
                    $endDate = now()->setYear($year)->setMonth(12)->endOfMonth();
                    $months = ['Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                }
                $periods = $months;
                break;
                
            case 'annuel':
            default:
                $startDate = now()->setYear($year)->startOfYear();
                $endDate = $startDate->copy()->endOfYear();
                $periods = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
                           'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                break;
        }
        
        // Récupérer tous les départements
        $query = Department::query();
        
        // Filtrage hiérarchique
        if ($user->hasRole('superadmin')) {
            // Voir tout
        } elseif ($user->filiale_id && !$user->agence_id) {
            $query->where('filiale_id', $user->filiale_id);
        } elseif ($user->agence_id) {
            $query->where('agence_id', $user->agence_id);
        }
        
        $departments = $query->with('filiale')->get();
        
        // Récupérer les activités pour la période avec relations RH
        $activitiesQuery = Activity::with([
            'department.filiale', 
            'department.agence',
            'project', 
            'filiale', 
            'agence',
            'creator',
            'responsible.employee',
            'participants.employee'
        ])
            ->whereBetween('date_prevue', [$startDate, $endDate]);
            
        // Filtrage hiérarchique pour les activités
        if ($user->hasRole('superadmin')) {
            // Voir tout
        } elseif ($user->filiale_id && !$user->agence_id) {
            $activitiesQuery->where('filiale_id', $user->filiale_id);
        } elseif ($user->agence_id) {
            $activitiesQuery->where('agence_id', $user->agence_id);
        }
        
        $activities = $activitiesQuery->get();
        
        // Organiser les activités par département et période
        $planning = [];
        foreach ($departments as $department) {
            $planning[$department->id] = [
                'department' => $department,
                'periods' => []
            ];
            
            foreach ($periods as $index => $period) {
                $periodActivities = $activities->filter(function($activity) use ($department, $filter, $year, $month, $semester, $index) {
                    if ($activity->department_id != $department->id) {
                        return false;
                    }
                    
                    $activityDate = \Carbon\Carbon::parse($activity->date_prevue);
                    
                    switch ($filter) {
                        case 'journalier':
                            return $activityDate->isToday();
                            
                        case 'mensuel':
                            return $activityDate->year == $year && $activityDate->month == $month;
                            
                        case 'semestriel':
                            if ($semester == 1) {
                                return $activityDate->year == $year && $activityDate->month == ($index + 1);
                            } else {
                                return $activityDate->year == $year && $activityDate->month == ($index + 7);
                            }
                            
                        case 'annuel':
                        default:
                            return $activityDate->year == $year && $activityDate->month == ($index + 1);
                    }
                });
                
                $planning[$department->id]['periods'][$period] = $periodActivities;
            }
        }
        
        // Calculer les indicateurs de performance
        $performance = [
            'total_activities' => $activities->count(),
            'completed' => $activities->where('statut', 'terminée')->count(),
            'in_progress' => $activities->where('statut', 'en_cours')->count(),
            'planned' => $activities->where('statut', 'planifiée')->count(),
            'cancelled' => $activities->where('statut', 'annulée')->count(),
            'completion_rate' => $activities->count() > 0 
                ? round(($activities->where('statut', 'terminée')->count() / $activities->count()) * 100, 1) 
                : 0,
        ];
        
        // Indicateurs par département
        $departmentPerformance = [];
        foreach ($departments as $department) {
            $deptActivities = $activities->where('department_id', $department->id);
            $departmentPerformance[$department->id] = [
                'total' => $deptActivities->count(),
                'completed' => $deptActivities->where('statut', 'terminée')->count(),
                'rate' => $deptActivities->count() > 0 
                    ? round(($deptActivities->where('statut', 'terminée')->count() / $deptActivities->count()) * 100, 1)
                    : 0,
            ];
        }
        
        return view('activities.planning', compact(
            'planning', 
            'periods', 
            'departments', 
            'performance', 
            'departmentPerformance',
            'filter',
            'year',
            'month',
            'semester'
        ));
    }

    public function planningCreate()
    {
        $user = auth()->user();
        
        $projects = Project::all();
        $departments = Department::all();
        $filiales = Filiale::all();
        $employees = \App\Models\Employee::with('user')->get();
        
        if ($user->filiale_id) {
            $agences = Agence::where('filiale_id', $user->filiale_id)->get();
        } else {
            $agences = Agence::all();
        }

        return view('activities.planning-create', compact('projects', 'departments', 'filiales', 'agences', 'employees'));
    }

    public function planningStore(Request $request)
    {
        $validated = $request->validate([
            'months' => 'required|array',
            'months.*' => 'required|integer|between:1,12',
            'year' => 'required|integer',
            'filiale_id' => 'required|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
            'project_id' => 'nullable|exists:projects,id',
            'departments' => 'required|array',
            'departments.*' => 'required|exists:departments,id',
            'activities' => 'required|array|min:1',
            'activities.*.titre' => 'required|string|max:255',
            'activities.*.type' => 'required|string',
            'activities.*.description' => 'nullable|string',
            'activities.*.heure_debut' => 'nullable',
            'activities.*.lieu' => 'nullable|string|max:255',
            'activities.*.statut' => 'required|string',
            'activities.*.responsible_id' => 'nullable|exists:users,id',
            'activities.*.participants' => 'nullable|array',
            'activities.*.participants.*' => 'nullable|exists:users,id',
        ]);

        $user = auth()->user();
        $createdCount = 0;

        // Pour chaque mois sélectionné
        foreach ($validated['months'] as $month) {
            // Pour chaque département sélectionné
            foreach ($validated['departments'] as $departmentId) {
                $department = Department::find($departmentId);
                
                // Pour chaque activité définie
                foreach ($validated['activities'] as $activityData) {
                    // Créer une date pour ce mois
                    $date = \Carbon\Carbon::create($validated['year'], $month, 1);
                    
                    $activity = Activity::create([
                        'titre' => $activityData['titre'],
                        'description' => $activityData['description'] ?? null,
                        'type' => $activityData['type'],
                        'statut' => $activityData['statut'],
                        'date_prevue' => $date->format('Y-m-d'),
                        'heure_debut' => $activityData['heure_debut'] ?? null,
                        'lieu' => $activityData['lieu'] ?? null,
                        'department_id' => $departmentId,
                        'project_id' => $validated['project_id'] ?? null,
                        'filiale_id' => $validated['filiale_id'],
                        'agence_id' => $validated['agence_id'] ?? $department->agence_id,
                        'created_by' => $user->id,
                        'responsible_id' => $activityData['responsible_id'] ?? null,
                    ]);
                    
                    // Attacher les participants si présents
                    if (!empty($activityData['participants'])) {
                        $activity->participants()->attach($activityData['participants']);
                    }
                    
                    $createdCount++;
                }
            }
        }

        // Rediriger vers la vue planning avec les filtres
        return redirect()->route('activities.planning', [
            'filter' => 'annuel',
            'year' => $validated['year'],
        ])->with('success', "$createdCount activités ont été créées avec succès dans le tableau de planification.");
    }
}

