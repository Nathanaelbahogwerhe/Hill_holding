<?php

namespace App\Http\Controllers;

use App\Models\ItIntervention;
use App\Models\ItEquipment;
use App\Models\Filiale;
use App\Models\Agence;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class ItInterventionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = ItIntervention::with(['demandeur', 'technicien', 'itEquipment', 'filiale']);

        // Filtrage hiérarchique
        if ($user->filiale_id && !$user->agence_id) {
            $query->where('filiale_id', $user->filiale_id);
        } elseif ($user->agence_id) {
            $query->where('agence_id', $user->agence_id);
        }

        $interventions = $query->latest()->paginate(15);

        // Statistiques
        $stats = [
            'total' => ItIntervention::count(),
            'ouverte' => ItIntervention::where('statut', 'ouverte')->count(),
            'en_cours' => ItIntervention::where('statut', 'en_cours')->count(),
            'resolue' => ItIntervention::where('statut', 'resolue')->count(),
        ];

        return view('it_interventions.index', compact('interventions', 'stats'));
    }

    public function create()
    {
        $filiales = Filiale::all();
        $agences = Agence::all();
        $departments = Department::all();
        $techniciens = User::all();
        $itEquipment = ItEquipment::all();

        return view('it_interventions.create', compact('filiales', 'agences', 'departments', 'techniciens', 'itEquipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'filiale_id' => 'required|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
            'department_id' => 'nullable|exists:departments,id',
            'it_equipment_id' => 'nullable|exists:it_equipment,id',
            'type' => 'required|in:installation,configuration,depannage,maintenance,formation,autre',
            'priorite' => 'required|in:basse,normale,haute,urgente',
            'objet' => 'required|string|max:255',
            'description' => 'required|string',
            'technicien_id' => 'nullable|exists:users,id',
            'remarques' => 'nullable|string',
        ]);

        // Générer le numéro
        $date = now()->format('Ymd');
        $lastIntervention = ItIntervention::whereDate('created_at', today())->latest()->first();
        $sequence = $lastIntervention ? intval(substr($lastIntervention->numero, -4)) + 1 : 1;
        $validated['numero'] = 'ITINT-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        $validated['demandeur_id'] = auth()->id();

        ItIntervention::create($validated);

        return redirect()->route('it_interventions.index')->with('success', 'Intervention créée avec succès');
    }

    public function show(ItIntervention $itIntervention)
    {
        $itIntervention->load(['demandeur', 'technicien', 'itEquipment', 'filiale', 'agence', 'department']);

        return view('it_interventions.show', compact('itIntervention'));
    }

    public function edit(ItIntervention $itIntervention)
    {
        $filiales = Filiale::all();
        $agences = Agence::all();
        $departments = Department::all();
        $techniciens = User::all();
        $itEquipment = ItEquipment::all();

        return view('it_interventions.edit', compact('itIntervention', 'filiales', 'agences', 'departments', 'techniciens', 'itEquipment'));
    }

    public function update(Request $request, ItIntervention $itIntervention)
    {
        $validated = $request->validate([
            'technicien_id' => 'nullable|exists:users,id',
            'date_intervention' => 'nullable|date',
            'diagnostic' => 'nullable|string',
            'solution' => 'nullable|string',
            'duree_heures' => 'nullable|numeric|min:0',
            'statut' => 'required|in:ouverte,en_cours,en_attente,resolue,fermee',
            'date_resolution' => 'nullable|date',
            'note_satisfaction' => 'nullable|integer|min:1|max:5',
            'commentaire_satisfaction' => 'nullable|string',
            'remarques' => 'nullable|string',
        ]);

        $itIntervention->update($validated);

        return redirect()->route('it_interventions.show', $itIntervention)->with('success', 'Intervention mise à jour');
    }

    public function destroy(ItIntervention $itIntervention)
    {
        $itIntervention->delete();
        return redirect()->route('it_interventions.index')->with('success', 'Intervention supprimée');
    }
}
