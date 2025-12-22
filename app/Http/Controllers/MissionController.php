<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Project;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request)
    {
        $query = Mission::with(['vehicle', 'chauffeur']);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $missions = $query->latest('date_heure_depart')->paginate(20);
        
        $stats = [
            'total' => Mission::count(),
            'en_cours' => Mission::enCours()->count(),
            'terminees' => Mission::terminee()->count(),
            'ce_mois' => Mission::whereMonth('date_heure_depart', now()->month)->count(),
        ];

        return view('missions.index', compact('missions', 'stats'));
    }

    public function create()
    {
        $vehicles = Vehicle::disponible()->get();
        $chauffeurs = User::all();
        $projects = Project::all();

        return view('missions.create', compact('vehicles', 'chauffeurs', 'projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'chauffeur_id' => 'required|exists:users,id',
            'objet' => 'required|string',
            'date_heure_depart' => 'required|date',
            'date_heure_retour_prevue' => 'required|date|after:date_heure_depart',
            'lieu_depart' => 'required|string',
            'lieu_destination' => 'required|string',
            'type' => 'required|in:administrative,commerciale,technique,livraison,autre',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $validated['numero'] = 'MISS-' . date('Ymd') . '-' . str_pad(Mission::count() + 1, 4, '0', STR_PAD_LEFT);
        $validated['statut'] = 'planifiee';
        $validated['created_by'] = auth()->id();

        // Upload attachments
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $this->uploadFiles($request->file('attachments'), 'operations/missions');
        }

        $mission = Mission::create($validated);

        return redirect()->route('missions.show', $mission)->with('success', 'Mission créée.');
    }

    public function show(Mission $mission)
    {
        $mission->load(['vehicle', 'chauffeur', 'fuelRecords']);
        return view('missions.show', compact('mission'));
    }

    public function destroy(Mission $mission)
    {
        $mission->delete();
        return redirect()->route('missions.index')->with('success', 'Mission supprimée.');
    }

    public function downloadAttachment(Mission $mission, $index)
    {
        if (!isset($mission->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($mission->attachments[$index]);
    }

    public function deleteAttachment(Mission $mission, $index)
    {
        if (!isset($mission->attachments[$index])) {
            abort(404);
        }
        $mission->attachments = $this->removeAttachment($mission->attachments, $index);
        $mission->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}
