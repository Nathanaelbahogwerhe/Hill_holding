<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Equipment;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request)
    {
        $query = Maintenance::with(['equipment', 'technicien']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $maintenances = $query->latest('date_prevue')->paginate(20);
        
        $stats = [
            'total' => Maintenance::count(),
            'planifiees' => Maintenance::planifiee()->count(),
            'preventives' => Maintenance::preventive()->count(),
            'correctives' => Maintenance::corrective()->count(),
        ];

        return view('maintenances.index', compact('maintenances', 'stats'));
    }

    public function create(Request $request)
    {
        $equipmentId = $request->get('equipment_id');
        $equipment = $equipmentId ? Equipment::find($equipmentId) : null;
        $allEquipment = Equipment::all();
        $techniciens = User::all();

        return view('maintenances.create', compact('allEquipment', 'equipment', 'techniciens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'type' => 'required|in:preventive,corrective,ameliorative',
            'priorite' => 'required|in:basse,normale,haute,urgente',
            'titre' => 'required|string',
            'description' => 'nullable|string',
            'date_prevue' => 'required|date',
            'technicien_id' => 'nullable|exists:users,id',
        ]);

        $validated['numero'] = 'MAINT-' . date('Ymd') . '-' . str_pad(Maintenance::count() + 1, 4, '0', STR_PAD_LEFT);
        $validated['statut'] = 'planifiee';
        $validated['created_by'] = auth()->id();

        // Upload attachments
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $this->uploadFiles($request->file('attachments'), 'operations/maintenances');
        }

        $maintenance = Maintenance::create($validated);

        return redirect()->route('maintenances.show', $maintenance)->with('success', 'Maintenance planifiée.');
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance->load(['equipment', 'technicien']);
        return view('maintenances.show', compact('maintenance'));
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('maintenances.index')->with('success', 'Maintenance supprimée.');
    }

    public function downloadAttachment(Maintenance $maintenance, $index)
    {
        if (!isset($maintenance->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($maintenance->attachments[$index]);
    }

    public function deleteAttachment(Maintenance $maintenance, $index)
    {
        if (!isset($maintenance->attachments[$index])) {
            abort(404);
        }
        $maintenance->attachments = $this->removeAttachment($maintenance->attachments, $index);
        $maintenance->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}
