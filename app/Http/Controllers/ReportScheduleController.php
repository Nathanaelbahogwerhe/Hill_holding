<?php

namespace App\Http\Controllers;

use App\Models\ReportSchedule;
use App\Models\Department;
use App\Models\User;
use App\Models\Filiale;
use App\Models\Agence;
use Illuminate\Http\Request;

class ReportScheduleController extends Controller
{
    /**
     * Liste des calendriers de rapports
     */
    public function index()
    {
        $user = auth()->user();
        
        $query = ReportSchedule::with(['department', 'responsable', 'filiale', 'agence']);

        // Filtrage hiérarchique
        if ($user->hasRole('superadmin')) {
            // Voir tout
        } elseif ($user->filiale_id && !$user->agence_id) {
            $query->where('filiale_id', $user->filiale_id);
        } elseif ($user->agence_id) {
            $query->where('agence_id', $user->agence_id);
        }

        $schedules = $query->paginate(15);

        // Statistiques (using separate queries since $schedules is a paginator)
        $statsQuery = ReportSchedule::query();
        if ($user->hasRole('superadmin')) {
            // Voir tout
        } elseif ($user->filiale_id && !$user->agence_id) {
            $statsQuery->where('filiale_id', $user->filiale_id);
        } elseif ($user->agence_id) {
            $statsQuery->where('agence_id', $user->agence_id);
        }
        
        $stats = [
            'total' => $statsQuery->count(),
            'actifs' => (clone $statsQuery)->where('active', true)->count(),
            'en_retard' => (clone $statsQuery)->whereNotNull('prochaine_echeance')->where('prochaine_echeance', '<', now())->count(),
            'a_venir' => (clone $statsQuery)->whereNotNull('prochaine_echeance')->where('prochaine_echeance', '>', now())->count(),
        ];

        return view('report_schedules.index', compact('schedules', 'stats'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $departments = Department::all();
        $users = User::all();
        $filiales = Filiale::all();
        $agences = Agence::all();

        return view('report_schedules.create', compact('departments', 'users', 'filiales', 'agences'));
    }

    /**
     * Enregistrer un calendrier
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type_rapport' => 'required|in:journalier,hebdomadaire,mensuel',
            'frequence' => 'required|in:daily,weekly,monthly',
            'jour_semaine' => 'nullable|integer|min:1|max:7',
            'jour_mois' => 'nullable|integer|min:1|max:31',
            'heure_echeance' => 'required|date_format:H:i',
            'department_id' => 'nullable|exists:departments,id',
            'responsable_id' => 'required|exists:users,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
            'active' => 'boolean',
        ]);

        $schedule = ReportSchedule::create($validated);
        $schedule->calculateNextDeadline();

        return redirect()->route('report_schedules.index')
            ->with('success', 'Calendrier créé avec succès.');
    }

    /**
     * Afficher un calendrier
     */
    public function show(ReportSchedule $reportSchedule)
    {
        $reportSchedule->load(['department', 'responsable', 'filiale', 'agence']);
        
        return view('report_schedules.show', compact('reportSchedule'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit(ReportSchedule $reportSchedule)
    {
        $departments = Department::all();
        $users = User::all();
        $filiales = Filiale::all();
        $agences = Agence::all();

        return view('report_schedules.edit', compact('reportSchedule', 'departments', 'users', 'filiales', 'agences'));
    }

    /**
     * Mettre à jour un calendrier
     */
    public function update(Request $request, ReportSchedule $reportSchedule)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type_rapport' => 'required|in:journalier,hebdomadaire,mensuel',
            'frequence' => 'required|in:daily,weekly,monthly',
            'jour_semaine' => 'nullable|integer|min:1|max:7',
            'jour_mois' => 'nullable|integer|min:1|max:31',
            'heure_echeance' => 'required|date_format:H:i',
            'department_id' => 'nullable|exists:departments,id',
            'responsable_id' => 'required|exists:users,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
            'active' => 'boolean',
        ]);

        $reportSchedule->update($validated);
        $reportSchedule->calculateNextDeadline();

        return redirect()->route('report_schedules.show', $reportSchedule)
            ->with('success', 'Calendrier mis à jour avec succès.');
    }

    /**
     * Supprimer un calendrier
     */
    public function destroy(ReportSchedule $reportSchedule)
    {
        $reportSchedule->delete();

        return redirect()->route('report_schedules.index')
            ->with('success', 'Calendrier supprimé avec succès.');
    }

    /**
     * Afficher les échéances
     */
    public function deadlines()
    {
        $user = auth()->user();
        
        $query = ReportSchedule::active()->with(['department', 'responsable']);

        if (!$user->hasRole('superadmin')) {
            if ($user->filiale_id) {
                $query->where('filiale_id', $user->filiale_id);
            }
            if ($user->agence_id) {
                $query->where('agence_id', $user->agence_id);
            }
        }

        $overdue = $query->get()->filter->isOverdue();
        $upcoming = ReportSchedule::active()->dueSoon(48)->get();

        return view('report_schedules.deadlines', compact('overdue', 'upcoming'));
    }
}
