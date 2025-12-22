<?php

namespace App\Http\Controllers;

use App\Models\VehicleMaintenance;
use App\Models\Vehicle;
use App\Models\Supplier;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class VehicleMaintenanceController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request)
    {
        $query = VehicleMaintenance::with(['vehicle', 'supplier', 'responsable']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $maintenances = $query->latest('date_prevue')->paginate(20);
        
        $stats = [
            'total' => VehicleMaintenance::count(),
            'planifiees' => VehicleMaintenance::planifiee()->count(),
            'terminees' => VehicleMaintenance::terminee()->count(),
            'ce_mois' => VehicleMaintenance::whereMonth('date_prevue', now()->month)->count(),
        ];

        return view('vehicle_maintenances.index', compact('maintenances', 'stats'));
    }

    public function create(Request $request)
    {
        $vehicleId = $request->get('vehicle_id');
        $vehicle = $vehicleId ? Vehicle::find($vehicleId) : null;
        $vehicles = Vehicle::all();
        $suppliers = Supplier::all();
        $users = User::all();

        return view('vehicle_maintenances.create', compact('vehicles', 'vehicle', 'suppliers', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'type' => 'required|in:vidange,revision,reparation,pneus,freins,batterie,visite_technique,autre',
            'priorite' => 'required|in:basse,normale,haute,urgente',
            'titre' => 'required|string',
            'date_prevue' => 'required|date',
            'lieu' => 'required|in:interne,garage,concessionnaire,autre',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'kilometrage_au_moment' => 'nullable|integer',
        ]);

        $validated['numero'] = 'VM-' . date('Ymd') . '-' . str_pad(VehicleMaintenance::count() + 1, 4, '0', STR_PAD_LEFT);
        $validated['statut'] = 'planifiee';
        $validated['created_by'] = auth()->id();

        // Upload attachments
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $this->uploadFiles($request->file('attachments'), 'operations/vehicle-maintenances');
        }

        $maintenance = VehicleMaintenance::create($validated);

        return redirect()->route('vehicle_maintenances.show', $maintenance)->with('success', 'Maintenance planifiée.');
    }

    public function show(VehicleMaintenance $vehicleMaintenance)
    {
        $vehicleMaintenance->load(['vehicle', 'supplier', 'responsable']);
        return view('vehicle_maintenances.show', compact('vehicleMaintenance'));
    }

    public function destroy(VehicleMaintenance $vehicleMaintenance)
    {
        $vehicleMaintenance->delete();
        return redirect()->route('vehicle_maintenances.index')->with('success', 'Maintenance supprimée.');
    }

    public function downloadAttachment(VehicleMaintenance $vehicleMaintenance, $index)
    {
        if (!isset($vehicleMaintenance->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($vehicleMaintenance->attachments[$index]);
    }

    public function deleteAttachment(VehicleMaintenance $vehicleMaintenance, $index)
    {
        if (!isset($vehicleMaintenance->attachments[$index])) {
            abort(404);
        }
        $vehicleMaintenance->attachments = $this->removeAttachment($vehicleMaintenance->attachments, $index);
        $vehicleMaintenance->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}
