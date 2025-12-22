<?php

namespace App\Http\Controllers;

use App\Models\ItEquipment;
use App\Models\Filiale;
use App\Models\Agence;
use App\Models\Department;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ItEquipmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = ItEquipment::with(['filiale', 'utilisateur', 'department']);

        // Filtrage hiérarchique
        if ($user->filiale_id && !$user->agence_id) {
            $query->where('filiale_id', $user->filiale_id);
        } elseif ($user->agence_id) {
            $query->where('agence_id', $user->agence_id);
        }

        $itEquipment = $query->latest()->paginate(15);

        // Statistiques
        $stats = [
            'total' => ItEquipment::count(),
            'disponible' => ItEquipment::where('statut', 'disponible')->count(),
            'en_service' => ItEquipment::where('statut', 'en_service')->count(),
            'en_reparation' => ItEquipment::where('statut', 'en_reparation')->count(),
        ];

        return view('it_equipment.index', compact('itEquipment', 'stats'));
    }

    public function create()
    {
        $filiales = Filiale::all();
        $agences = Agence::all();
        $departments = Department::all();
        $users = User::all();
        $suppliers = Supplier::where('statut', 'actif')->get();

        return view('it_equipment.create', compact('filiales', 'agences', 'departments', 'users', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'filiale_id' => 'required|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
            'department_id' => 'nullable|exists:departments,id',
            'type' => 'required|in:ordinateur,portable,serveur,imprimante,scanner,switch,routeur,autre',
            'marque' => 'nullable|string|max:255',
            'modele' => 'nullable|string|max:255',
            'numero_serie' => 'nullable|string|max:255|unique:it_equipment',
            'processeur' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:50',
            'disque_dur' => 'nullable|string|max:50',
            'systeme_exploitation' => 'nullable|string|max:255',
            'utilisateur_id' => 'nullable|exists:users,id',
            'date_attribution' => 'nullable|date',
            'localisation' => 'nullable|string|max:255',
            'date_acquisition' => 'nullable|date',
            'prix_acquisition' => 'nullable|numeric|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'date_fin_garantie' => 'nullable|date',
            'statut' => 'required|in:disponible,en_service,en_reparation,hors_service,reforme',
            'etat' => 'nullable|in:excellent,bon,moyen,mauvais',
            'configuration_details' => 'nullable|string',
            'remarques' => 'nullable|string',
        ]);

        // Générer le numéro
        $date = now()->format('Ymd');
        $lastEquipment = ItEquipment::whereDate('created_at', today())->latest()->first();
        $sequence = $lastEquipment ? intval(substr($lastEquipment->numero, -4)) + 1 : 1;
        $validated['numero'] = 'IT-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        ItEquipment::create($validated);

        return redirect()->route('it_equipment.index')->with('success', 'Équipement IT ajouté avec succès');
    }

    public function show(ItEquipment $itEquipment)
    {
        $itEquipment->load(['filiale', 'agence', 'department', 'utilisateur', 'supplier', 'interventions.technicien']);

        return view('it_equipment.show', compact('itEquipment'));
    }

    public function edit(ItEquipment $itEquipment)
    {
        $filiales = Filiale::all();
        $agences = Agence::all();
        $departments = Department::all();
        $users = User::all();
        $suppliers = Supplier::where('statut', 'actif')->get();

        return view('it_equipment.edit', compact('itEquipment', 'filiales', 'agences', 'departments', 'users', 'suppliers'));
    }

    public function update(Request $request, ItEquipment $itEquipment)
    {
        $validated = $request->validate([
            'filiale_id' => 'required|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
            'department_id' => 'nullable|exists:departments,id',
            'type' => 'required|in:ordinateur,portable,serveur,imprimante,scanner,switch,routeur,autre',
            'marque' => 'nullable|string|max:255',
            'modele' => 'nullable|string|max:255',
            'numero_serie' => 'nullable|string|max:255|unique:it_equipment,numero_serie,' . $itEquipment->id,
            'processeur' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:50',
            'disque_dur' => 'nullable|string|max:50',
            'systeme_exploitation' => 'nullable|string|max:255',
            'utilisateur_id' => 'nullable|exists:users,id',
            'date_attribution' => 'nullable|date',
            'localisation' => 'nullable|string|max:255',
            'date_acquisition' => 'nullable|date',
            'prix_acquisition' => 'nullable|numeric|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'date_fin_garantie' => 'nullable|date',
            'statut' => 'required|in:disponible,en_service,en_reparation,hors_service,reforme',
            'etat' => 'nullable|in:excellent,bon,moyen,mauvais',
            'configuration_details' => 'nullable|string',
            'remarques' => 'nullable|string',
        ]);

        $itEquipment->update($validated);

        return redirect()->route('it_equipment.index')->with('success', 'Équipement IT mis à jour avec succès');
    }

    public function destroy(ItEquipment $itEquipment)
    {
        $itEquipment->delete();
        return redirect()->route('it_equipment.index')->with('success', 'Équipement IT supprimé');
    }
}
