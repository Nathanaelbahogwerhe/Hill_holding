<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\Department;
use App\Models\Project;
use App\Models\Filiale;
use App\Models\Agence;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = PurchaseRequest::with(['demandeur', 'approbateur', 'department', 'filiale', 'agence']);

        // Filtrage hiérarchique
        if (!$user->hasRole('superadmin')) {
            if ($user->filiale_id && !$user->agence_id) {
                $query->where('filiale_id', $user->filiale_id);
            } elseif ($user->agence_id) {
                $query->where('agence_id', $user->agence_id);
            }
        }

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        $purchaseRequests = $query->latest()->paginate(20);

        $stats = [
            'total' => PurchaseRequest::count(),
            'soumises' => PurchaseRequest::soumise()->count(),
            'approuvees' => PurchaseRequest::approuvee()->count(),
            'en_attente' => PurchaseRequest::enAttente()->count(),
        ];

        return view('purchase_requests.index', compact('purchaseRequests', 'stats'));
    }

    public function create()
    {
        $departments = Department::all();
        $projects = Project::all();
        $filiales = Filiale::all();
        $agences = Agence::all();

        return view('purchase_requests.create', compact('departments', 'projects', 'filiales', 'agences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:equipement,fourniture,service,materiaux,autre',
            'priorite' => 'required|in:basse,normale,haute,urgente',
            'montant_estime' => 'nullable|numeric',
            'date_besoin' => 'required|date',
            'justification' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'department_id' => 'nullable|exists:departments,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
        ]);

        $validated['numero'] = 'DA-' . date('Ymd') . '-' . str_pad(PurchaseRequest::count() + 1, 4, '0', STR_PAD_LEFT);
        $validated['demandeur_id'] = auth()->id();
        $validated['statut'] = 'brouillon';

        $purchaseRequest = PurchaseRequest::create($validated);

        return redirect()->route('purchase_requests.show', $purchaseRequest)
            ->with('success', 'Demande d\'achat créée avec succès.');
    }

    public function show(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->load(['demandeur', 'approbateur', 'purchaseOrders']);
        return view('purchase_requests.show', compact('purchaseRequest'));
    }

    public function approve(Request $request, PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->approuver(auth()->user(), $request->commentaire);
        return redirect()->back()->with('success', 'Demande approuvée.');
    }

    public function reject(Request $request, PurchaseRequest $purchaseRequest)
    {
        $request->validate(['commentaire' => 'required|string']);
        $purchaseRequest->rejeter(auth()->user(), $request->commentaire);
        return redirect()->back()->with('success', 'Demande rejetée.');
    }

    public function destroy(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->delete();
        return redirect()->route('purchase_requests.index')->with('success', 'Demande supprimée.');
    }
}
