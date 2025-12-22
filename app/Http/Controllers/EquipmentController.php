<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Supplier;
use App\Models\Department;
use App\Models\User;
use App\Models\Filiale;
use App\Models\Agence;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Equipment::with(['supplier', 'affectation', 'department', 'filiale', 'agence']);

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

        $equipment = $query->latest()->paginate(20);

        $stats = [
            'total' => Equipment::count(),
            'disponible' => Equipment::disponible()->count(),
            'en_service' => Equipment::enService()->count(),
            'maintenance_due' => Equipment::maintenanceDue()->count(),
        ];

        return view('equipment.index', compact('equipment', 'stats'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $departments = Department::all();
        $users = User::all();
        $filiales = Filiale::all();
        $agences = Agence::all();

        return view('equipment.create', compact('suppliers', 'departments', 'users', 'filiales', 'agences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:informatique,vehicule,machine,mobilier,electronique,autre',
            'categorie' => 'required|in:immobilisation,consommable,location',
            'description' => 'nullable|string',
            'marque' => 'nullable|string',
            'modele' => 'nullable|string',
            'numero_serie' => 'nullable|string',
            'date_acquisition' => 'required|date',
            'prix_acquisition' => 'required|numeric',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'etat' => 'required|in:neuf,bon,moyen,mauvais,hors_service',
            'statut' => 'required|in:disponible,en_service,en_maintenance,en_panne,reforme',
            'affecte_a' => 'nullable|exists:users,id',
            'department_id' => 'nullable|exists:departments,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
        ]);

        $validated['code'] = 'EQ-' . date('Ymd') . '-' . str_pad(Equipment::count() + 1, 4, '0', STR_PAD_LEFT);

        // Upload attachments
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $this->uploadFiles($request->file('attachments'), 'operations/equipment');
        }

        $equipment = Equipment::create($validated);

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Équipement créé avec succès.');
    }

    public function show(Equipment $equipment)
    {
        $equipment->load(['maintenances', 'breakdowns', 'interventions']);
        return view('equipment.show', compact('equipment'));
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('equipment.index')->with('success', 'Équipement supprimé.');
    }

    public function downloadAttachment(Equipment $equipment, $index)
    {
        if (!isset($equipment->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($equipment->attachments[$index]);
    }

    public function deleteAttachment(Equipment $equipment, $index)
    {
        if (!isset($equipment->attachments[$index])) {
            abort(404);
        }
        $equipment->attachments = $this->removeAttachment($equipment->attachments, $index);
        $equipment->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}
