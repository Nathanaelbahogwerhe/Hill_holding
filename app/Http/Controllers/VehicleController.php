<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Department;
use App\Models\User;
use App\Models\Filiale;
use App\Models\Agence;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Vehicle::with(['chauffeur', 'service', 'filiale', 'agence']);

        // Filtrage hiérarchique
        if (!$user->hasRole('superadmin')) {
            if ($user->filiale_id && !$user->agence_id) {
                $query->where('filiale_id', $user->filiale_id);
            } elseif ($user->agence_id) {
                $query->where('agence_id', $user->agence_id);
            }
        }

        // Filtres
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $vehicles = $query->latest()->paginate(20);

        $stats = [
            'total' => Vehicle::count(),
            'disponible' => Vehicle::disponible()->count(),
            'en_mission' => Vehicle::enMission()->count(),
            'assurance_expire' => Vehicle::assuranceExpireeSoon()->count(),
        ];

        return view('vehicles.index', compact('vehicles', 'stats'));
    }

    public function create()
    {
        $chauffeurs = User::all();
        $departments = Department::all();
        $filiales = Filiale::all();
        $agences = Agence::all();

        return view('vehicles.create', compact('chauffeurs', 'departments', 'filiales', 'agences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'immatriculation' => 'required|string|unique:vehicles,immatriculation',
            'marque' => 'required|string',
            'modele' => 'required|string',
            'annee' => 'nullable|integer',
            'type' => 'required|in:voiture,camion,moto,bus,utilitaire,autre',
            'kilometrage' => 'nullable|integer',
            'proprietaire' => 'required|in:entreprise,location,personnel',
            'date_acquisition' => 'nullable|date',
            'etat' => 'required|in:excellent,bon,moyen,mauvais',
            'statut' => 'required|in:disponible,en_mission,en_maintenance,en_panne,reforme',
            'chauffeur_attitule_id' => 'nullable|exists:users,id',
            'affecte_a_service' => 'nullable|exists:departments,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
        ]);

        // Upload attachments
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $this->uploadFiles($request->file('attachments'), 'operations/vehicles');
        }

        $vehicle = Vehicle::create($validated);

        return redirect()->route('vehicles.show', $vehicle)
            ->with('success', 'Véhicule créé avec succès.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['missions', 'fuelRecords', 'maintenances']);
        return view('vehicles.show', compact('vehicle'));
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Véhicule supprimé.');
    }

    public function downloadAttachment(Vehicle $vehicle, $index)
    {
        if (!isset($vehicle->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($vehicle->attachments[$index]);
    }

    public function deleteAttachment(Vehicle $vehicle, $index)
    {
        if (!isset($vehicle->attachments[$index])) {
            abort(404);
        }
        $vehicle->attachments = $this->removeAttachment($vehicle->attachments, $index);
        $vehicle->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}
