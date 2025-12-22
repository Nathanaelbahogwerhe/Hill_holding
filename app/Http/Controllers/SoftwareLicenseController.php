<?php

namespace App\Http\Controllers;

use App\Models\SoftwareLicense;
use App\Models\Filiale;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SoftwareLicenseController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = SoftwareLicense::with(['filiale', 'supplier']);

        if ($user->filiale_id) {
            $query->where('filiale_id', $user->filiale_id);
        }

        $licenses = $query->latest()->paginate(15);

        // Statistiques
        $stats = [
            'total' => SoftwareLicense::count(),
            'active' => SoftwareLicense::where('statut', 'active')->count(),
            'expire_soon' => SoftwareLicense::expireeSoon(30)->count(),
            'expiree' => SoftwareLicense::where('statut', 'expiree')->count(),
        ];

        return view('software_licenses.index', compact('licenses', 'stats'));
    }

    public function create()
    {
        $filiales = Filiale::all();
        $suppliers = Supplier::where('statut', 'actif')->get();

        return view('software_licenses.create', compact('filiales', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'filiale_id' => 'required|exists:filiales,id',
            'nom_logiciel' => 'required|string|max:255',
            'editeur' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:50',
            'type' => 'required|in:os,bureautique,antivirus,developpement,comptabilite,autre',
            'numero_licence' => 'nullable|string|max:255',
            'cle_activation' => 'nullable|string|max:255',
            'type_licence' => 'required|in:perpetuelle,abonnement,volume,oem',
            'nombre_postes' => 'required|integer|min:1',
            'postes_utilises' => 'nullable|integer|min:0',
            'date_achat' => 'nullable|date',
            'date_expiration' => 'nullable|date',
            'cout' => 'nullable|numeric|min:0',
            'periode_facturation' => 'nullable|in:mensuel,annuel,unique',
            'statut' => 'required|in:active,expiree,resiliee',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'remarques' => 'nullable|string',
        ]);

        // Générer le numéro
        $date = now()->format('Ymd');
        $lastLicense = SoftwareLicense::whereDate('created_at', today())->latest()->first();
        $sequence = $lastLicense ? intval(substr($lastLicense->numero, -4)) + 1 : 1;
        $validated['numero'] = 'LIC-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        SoftwareLicense::create($validated);

        return redirect()->route('software_licenses.index')->with('success', 'Licence ajoutée avec succès');
    }

    public function show(SoftwareLicense $softwareLicense)
    {
        $softwareLicense->load(['filiale', 'supplier']);

        return view('software_licenses.show', compact('softwareLicense'));
    }

    public function edit(SoftwareLicense $softwareLicense)
    {
        $filiales = Filiale::all();
        $suppliers = Supplier::where('statut', 'actif')->get();

        return view('software_licenses.edit', compact('softwareLicense', 'filiales', 'suppliers'));
    }

    public function update(Request $request, SoftwareLicense $softwareLicense)
    {
        $validated = $request->validate([
            'filiale_id' => 'required|exists:filiales,id',
            'nom_logiciel' => 'required|string|max:255',
            'editeur' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:50',
            'type' => 'required|in:os,bureautique,antivirus,developpement,comptabilite,autre',
            'numero_licence' => 'nullable|string|max:255',
            'cle_activation' => 'nullable|string|max:255',
            'type_licence' => 'required|in:perpetuelle,abonnement,volume,oem',
            'nombre_postes' => 'required|integer|min:1',
            'postes_utilises' => 'nullable|integer|min:0',
            'date_achat' => 'nullable|date',
            'date_expiration' => 'nullable|date',
            'cout' => 'nullable|numeric|min:0',
            'periode_facturation' => 'nullable|in:mensuel,annuel,unique',
            'statut' => 'required|in:active,expiree,resiliee',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'remarques' => 'nullable|string',
        ]);

        $softwareLicense->update($validated);

        return redirect()->route('software_licenses.index')->with('success', 'Licence mise à jour avec succès');
    }

    public function destroy(SoftwareLicense $softwareLicense)
    {
        $softwareLicense->delete();
        return redirect()->route('software_licenses.index')->with('success', 'Licence supprimée');
    }
}
