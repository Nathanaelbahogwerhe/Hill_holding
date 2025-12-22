<?php

namespace App\Http\Controllers;

use App\Models\Filiale;
use App\Models\HillHolding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilialeController extends Controller
{
    public function index(Request $request)
    {
        $query = Filiale::with(['hillHolding', 'departments', 'agences', 'employees']);

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $filiales = $query->orderBy('name')->paginate(10);

        return view('filiales.index', compact('filiales'));
    }

    public function create()
    {
        $hillHoldings = HillHolding::all(); // il n'y a qu'une seule HH
        return view('filiales.create', compact('hillHoldings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255|unique:filiales,name',
            'code'            => 'nullable|string|max:50',
            'location'        => 'nullable|string|max:255',
            'logo'            => 'nullable|image|max:2048',
            'hill_holding_id' => 'required|exists:hill_holdings,id',
        ]);

        $data = $request->only('name', 'code', 'location', 'hill_holding_id');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('filiales/logos', 'public');
        }

        Filiale::create($data);

        return redirect()->route('filiales.index')
                         ->with('success', 'Filiale créée avec succès.');
    }

    public function show(Filiale $filiale)
    {
        $filiale->load('hillHolding', 'departments.employees', 'agences.employees', 'employees');
        return view('filiales.show', compact('filiale'));
    }

    public function edit(Filiale $filiale)
    {
        $hillHoldings = HillHolding::all();
        return view('filiales.edit', compact('filiale', 'hillHoldings'));
    }

    public function update(Request $request, Filiale $filiale)
    {
        $request->validate([
            'name'            => 'required|string|max:255|unique:filiales,name,' . $filiale->id,
            'code'            => 'nullable|string|max:50',
            'location'        => 'nullable|string|max:255',
            'logo'            => 'nullable|image|max:2048',
            'hill_holding_id' => 'required|exists:hill_holdings,id',
        ]);

        $data = $request->only('name', 'code', 'location', 'hill_holding_id');

        if ($request->hasFile('logo')) {
            if ($filiale->logo && Storage::disk('public')->exists($filiale->logo)) {
                Storage::disk('public')->delete($filiale->logo);
            }
            $data['logo'] = $request->file('logo')->store('filiales/logos', 'public');
        }

        $filiale->update($data);

        return redirect()->route('filiales.index')
                         ->with('success', 'Filiale mise à jour.');
    }

    public function destroy(Filiale $filiale)
    {
        if ($filiale->logo && Storage::disk('public')->exists($filiale->logo)) {
            Storage::disk('public')->delete($filiale->logo);
        }

        $filiale->delete();

        return redirect()->route('filiales.index')
                         ->with('success', 'Filiale supprimée.');
    }
}
