<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\Equipment;
use App\Models\Maintenance;
use App\Models\Breakdown;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    use FileUploadTrait;
    public function index()
    {
        $interventions = Intervention::with(['equipment', 'technicienPrincipal'])->latest('date_heure_debut')->paginate(20);
        
        $stats = [
            'total' => Intervention::count(),
            'en_cours' => Intervention::enCours()->count(),
            'terminees' => Intervention::where('statut', 'terminee')->count(),
            'ce_mois' => Intervention::whereMonth('date_heure_debut', now()->month)->count(),
        ];

        return view('interventions.index', compact('interventions', 'stats'));
    }

    public function create(Request $request)
    {
        $equipment = Equipment::all();
        $techniciens = User::all();
        $maintenanceId = $request->get('maintenance_id');
        $breakdownId = $request->get('breakdown_id');

        return view('interventions.create', compact('equipment', 'techniciens', 'maintenanceId', 'breakdownId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'maintenance_id' => 'nullable|exists:maintenances,id',
            'breakdown_id' => 'nullable|exists:breakdowns,id',
            'type' => 'required|in:installation,reparation,diagnostic,configuration,formation,autre',
            'titre' => 'required|string',
            'date_heure_debut' => 'required|date',
            'technicien_principal_id' => 'required|exists:users,id',
        ]);

        $validated['numero'] = 'INT-' . date('Ymd') . '-' . str_pad(Intervention::count() + 1, 4, '0', STR_PAD_LEFT);
        $validated['statut'] = 'planifiee';
        $validated['created_by'] = auth()->id();

        // Upload attachments
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $this->uploadFiles($request->file('attachments'), 'operations/interventions');
        }

        $intervention = Intervention::create($validated);

        return redirect()->route('interventions.show', $intervention)->with('success', 'Intervention planifiée.');
    }

    public function show(Intervention $intervention)
    {
        $intervention->load(['equipment', 'maintenance', 'breakdown', 'technicienPrincipal']);
        return view('interventions.show', compact('intervention'));
    }

    public function destroy(Intervention $intervention)
    {
        $intervention->delete();
        return redirect()->route('interventions.index')->with('success', 'Intervention supprimée.');
    }

    public function downloadAttachment(Intervention $intervention, $index)
    {
        if (!isset($intervention->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($intervention->attachments[$index]);
    }

    public function deleteAttachment(Intervention $intervention, $index)
    {
        if (!isset($intervention->attachments[$index])) {
            abort(404);
        }
        $intervention->attachments = $this->removeAttachment($intervention->attachments, $index);
        $intervention->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}
