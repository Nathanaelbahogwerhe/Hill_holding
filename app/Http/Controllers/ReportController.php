<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Project;
use App\Models\Department;
use App\Models\Filiale;
use App\Models\Agence;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    use FileUploadTrait;
    /**
     * Liste des rapports
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Report::with(['soumetteur', 'validateur', 'project', 'department', 'filiale', 'agence']);

        // Filtrage hiérarchique
        if ($user->hasRole('superadmin')) {
            // Super Admin voit tout
        } elseif ($user->filiale_id && !$user->agence_id) {
            $query->where('filiale_id', $user->filiale_id);
        } elseif ($user->agence_id) {
            $query->where('agence_id', $user->agence_id);
        } else {
            // Utilisateurs standards voient leurs rapports
            $query->where('soumis_par', $user->id);
        }

        // Filtres
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('date_debut')) {
            $query->where('date_debut', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->where('date_fin', '<=', $request->date_fin);
        }

        $reports = $query->latest()->paginate(20);

        // Statistiques
        $stats = [
            'total' => Report::count(),
            'brouillons' => Report::brouillon()->count(),
            'en_attente' => Report::soumis()->count(),
            'valides' => Report::valide()->count(),
            'rejetes' => Report::rejete()->count(),
        ];

        $departments = Department::all();
        $projects = Project::all();

        return view('reports.index', compact('reports', 'stats', 'departments', 'projects'));
    }

    /**
     * Formulaire de création
     */
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

        return view('reports.create', compact('projects', 'departments', 'filiales', 'agences'));
    }

    /**
     * Enregistrer un nouveau rapport
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required|in:journalier,hebdomadaire,mensuel,projet,mission,département',
            'contenu' => 'required|string',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'statut' => 'required|in:brouillon,soumis',
            'project_id' => 'nullable|exists:projects,id',
            'department_id' => 'nullable|exists:departments,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        $validated['soumis_par'] = auth()->id();

        // Si soumis directement, enregistrer la date
        if ($validated['statut'] === 'soumis') {
            $validated['date_soumission'] = now();
        }

        // Upload attachments
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $this->uploadFiles($request->file('attachments'), 'operations/reports');
        }

        Report::create($validated);

        return redirect()->route('reports.index')
            ->with('success', 'Rapport créé avec succès.');
    }

    /**
     * Afficher un rapport
     */
    public function show(Report $report)
    {
        $this->authorizeAccess($report);
        
        $report->load(['soumetteur', 'validateur', 'project', 'department', 'filiale', 'agence']);
        
        return view('reports.show', compact('report'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Report $report)
    {
        $this->authorizeAccess($report);

        // Ne peut éditer que si brouillon ou rejeté
        if (!in_array($report->statut, ['brouillon', 'rejeté'])) {
            return redirect()->route('reports.show', $report)
                ->with('error', 'Ce rapport ne peut plus être modifié.');
        }

        $user = auth()->user();
        $projects = Project::all();
        $departments = Department::all();
        $filiales = Filiale::all();
        
        if ($user->filiale_id) {
            $agences = Agence::where('filiale_id', $user->filiale_id)->get();
        } else {
            $agences = Agence::all();
        }

        return view('reports.edit', compact('report', 'projects', 'departments', 'filiales', 'agences'));
    }

    /**
     * Mettre à jour un rapport
     */
    public function update(Request $request, Report $report)
    {
        $this->authorizeAccess($report);

        if (!in_array($report->statut, ['brouillon', 'rejeté'])) {
            return redirect()->route('reports.show', $report)
                ->with('error', 'Ce rapport ne peut plus être modifié.');
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required|in:journalier,hebdomadaire,mensuel,projet,mission,département',
            'contenu' => 'required|string',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'statut' => 'required|in:brouillon,soumis',
            'project_id' => 'nullable|exists:projects,id',
            'department_id' => 'nullable|exists:departments,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        // Si soumis maintenant, enregistrer la date
        if ($validated['statut'] === 'soumis' && $report->statut !== 'soumis') {
            $validated['date_soumission'] = now();
        }

        // Upload and merge new attachments
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $this->mergeAttachments(
                $report->attachments, 
                $request->file('attachments'), 
                'operations/reports'
            );
        }

        $report->update($validated);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Rapport mis à jour avec succès.');
    }

    /**
     * Valider un rapport
     */
    public function validateReport(Request $request, Report $report)
    {
        $user = auth()->user();

        // Seuls les responsables peuvent valider
        if (!$user->hasRole(['superadmin', 'Admin Finance', 'RH Manager', 'Chargé des Opérations'])) {
            abort(403, 'Vous n\'avez pas les permissions pour valider ce rapport.');
        }

        $validated = $request->validate([
            'action' => 'required|in:valider,rejeter',
            'commentaires' => 'nullable|string',
        ]);

        $report->valide_par = $user->id;
        $report->date_validation = now();
        $report->statut = $validated['action'] === 'valider' ? 'validé' : 'rejeté';
        $report->commentaires = $validated['commentaires'];
        $report->save();

        return redirect()->route('reports.show', $report)
            ->with('success', 'Rapport ' . ($validated['action'] === 'valider' ? 'validé' : 'rejeté') . ' avec succès.');
    }

    /**
     * Supprimer un rapport
     */
    public function destroy(Report $report)
    {
        $this->authorizeAccess($report);

        // Ne peut supprimer que si brouillon
        if ($report->statut !== 'brouillon') {
            return redirect()->route('reports.index')
                ->with('error', 'Seuls les rapports en brouillon peuvent être supprimés.');
        }

        // Supprimer les fichiers attachés
        if ($report->attachments) {
            $attachments = json_decode($report->attachments, true);
            foreach ($attachments as $attachment) {
                if (Storage::disk('public')->exists($attachment)) {
                    Storage::disk('public')->delete($attachment);
                }
            }
        }

        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Rapport supprimé avec succès.');
    }

    /**
     * Tableau de bord des rapports
     */
    public function dashboard()
    {
        $user = auth()->user();

        $stats = [
            'total' => Report::count(),
            'ce_mois' => Report::whereMonth('created_at', now()->month)->count(),
            'en_attente' => Report::soumis()->count(),
            'valides' => Report::valide()->whereMonth('date_validation', now()->month)->count(),
        ];

        // Rapports récents
        $recentReports = Report::with('soumetteur')
            ->latest()
            ->limit(10)
            ->get();

        // Rapports en attente de validation (pour responsables)
        $pendingReports = [];
        if ($user->hasRole(['superadmin', 'Admin Finance', 'RH Manager', 'Chargé des Opérations'])) {
            $pendingReports = Report::soumis()
                ->with('soumetteur')
                ->latest()
                ->limit(10)
                ->get();
        }

        return view('reports.dashboard', compact('stats', 'recentReports', 'pendingReports'));
    }

    /**
     * Télécharger une pièce jointe
     */
    public function downloadAttachment(Report $report, $index)
    {
        $this->authorizeAccess($report);
        
        if (!isset($report->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($report->attachments[$index]);
    }

    /**
     * Supprimer une pièce jointe
     */
    public function deleteAttachment(Report $report, $index)
    {
        $this->authorizeAccess($report);
        
        if (!isset($report->attachments[$index])) {
            abort(404);
        }
        $report->attachments = $this->removeAttachment($report->attachments, $index);
        $report->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }

    /**
     * Vérifier les permissions d'accès
     */
    protected function authorizeAccess($report)
    {
        $user = auth()->user();

        if ($user->hasRole('superadmin')) {
            return true;
        }

        // L'auteur peut toujours accéder
        if ($report->soumis_par === $user->id) {
            return true;
        }

        // Filtrage hiérarchique pour les managers
        if ($user->filiale_id && $report->filiale_id !== $user->filiale_id) {
            abort(403, 'Accès non autorisé.');
        }

        if ($user->agence_id && $report->agence_id !== $user->agence_id) {
            abort(403, 'Accès non autorisé.');
        }

        return true;
    }
}
