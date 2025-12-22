<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Filiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgenceController extends Controller
{
    // Liste des agences
    public function index(Request $request)
    {
        $query = Agence::with('filiale', 'employees');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%");
        }

        if ($request->filled('filiale_id')) {
            $query->where('filiale_id', $request->filiale_id);
        }

        $agences = $query->orderBy('name')->paginate(10);

        $filiales = Filiale::orderBy('name')->get();

        return view('agences.index', compact('agences', 'filiales'));
    }

    // Formulaire de création
    public function create()
    {
        $filiales = Filiale::orderBy('name')->get();
        return view('agences.create', compact('filiales'));
    }

    // Stockage d'une nouvelle agence
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255|unique:agences,name',
            'code'       => 'nullable|string|max:50',
            'location'   => 'nullable|string|max:255',
            'filiale_id' => 'required|exists:filiales,id',
            'logo'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'code', 'location', 'filiale_id');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('agences/logos', 'public');
        }

        Agence::create($data);

        return redirect()->route('agences.index')
                         ->with('success', 'Agence créée avec succès.');
    }

    // Formulaire d'édition
    public function edit(Agence $agence)
    {
        $filiales = Filiale::orderBy('name')->get();
        return view('agences.edit', compact('agence', 'filiales'));
    }

    // Mise à jour de l'agence
    public function update(Request $request, Agence $agence)
    {
        $request->validate([
            'name'       => 'required|string|max:255|unique:agences,name,' . $agence->id,
            'code'       => 'nullable|string|max:50',
            'location'   => 'nullable|string|max:255',
            'filiale_id' => 'required|exists:filiales,id',
            'logo'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'code', 'location', 'filiale_id');

        if ($request->hasFile('logo')) {
            if ($agence->logo && Storage::disk('public')->exists($agence->logo)) {
                Storage::disk('public')->delete($agence->logo);
            }
            $data['logo'] = $request->file('logo')->store('agences/logos', 'public');
        }

        $agence->update($data);

        return redirect()->route('agences.index')
                         ->with('success', 'Agence mise à jour.');
    }

    // Affichage d'une agence
    public function show(Agence $agence)
    {
        $agence->load('filiale', 'employees');
        return view('agences.show', compact('agence'));
    }

    // Suppression d'une agence
    public function destroy(Agence $agence)
    {
        if ($agence->logo && Storage::disk('public')->exists($agence->logo)) {
            Storage::disk('public')->delete($agence->logo);
        }

        $agence->delete();

        return redirect()->route('agences.index')
                         ->with('success', 'Agence supprimée.');
    }
}
