<?php

namespace App\Http\Controllers;

use App\Models\SupplierContract;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class SupplierContractController extends Controller
{
    public function index()
    {
        $contracts = SupplierContract::with(['supplier', 'responsable'])->latest()->paginate(20);
        
        $stats = [
            'total' => SupplierContract::count(),
            'actifs' => SupplierContract::actif()->count(),
            'expire_soon' => SupplierContract::expireSoon()->count(),
            'renouvelables' => SupplierContract::where('renouvelable', true)->count(),
        ];

        return view('supplier_contracts.index', compact('contracts', 'stats'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $users = User::all();

        return view('supplier_contracts.create', compact('suppliers', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'titre' => 'required|string',
            'type' => 'required|in:fourniture,prestation,maintenance,cadre,autre',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'montant_total' => 'nullable|numeric',
            'responsable_interne_id' => 'nullable|exists:users,id',
            'renouvelable' => 'boolean',
        ]);

        $validated['reference'] = 'CF-' . date('Ymd') . '-' . str_pad(SupplierContract::count() + 1, 4, '0', STR_PAD_LEFT);
        $validated['statut'] = 'brouillon';
        $validated['created_by'] = auth()->id();

        $contract = SupplierContract::create($validated);

        return redirect()->route('supplier_contracts.show', $contract)->with('success', 'Contrat créé.');
    }

    public function show(SupplierContract $supplierContract)
    {
        return view('supplier_contracts.show', compact('supplierContract'));
    }

    public function destroy(SupplierContract $supplierContract)
    {
        $supplierContract->delete();
        return redirect()->route('supplier_contracts.index')->with('success', 'Contrat supprimé.');
    }
}
