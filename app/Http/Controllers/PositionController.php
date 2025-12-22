<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class PositionController extends Controller
{
    /**
     * Afficher la liste des postes avec pagination
     */
    public function index()
    {
        $positions = Position::orderBy('name')->paginate(10);
        return view('positions.index', compact('positions'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $filiales = \App\Models\Filiale::orderBy('name')->get();
        return view('positions.create', compact('filiales'));
    }

    /**
     * Enregistrer un nouveau poste
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:positions,name',
            'description' => 'nullable|string',
            'filiale_id' => 'nullable|exists:filiales,id',
        ]);

        $position = Position::create([
            'name' => $request->name,
            'description' => $request->description,
            'filiale_id' => $request->filiale_id,
        ]);

        ActivityLogger::log('positions', 'create', 'Ajout d\'un nouveau poste : ' . $position->name);

        return redirect()->route('positions.index')->with('success', 'Poste ajouté avec succès.');
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Position $position)
    {
        $filiales = \App\Models\Filiale::orderBy('name')->get();
        return view('positions.edit', compact('position', 'filiales'));
    }

    /**
     * Mettre à jour un poste
     */
    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:positions,name,' . $position->id,
            'description' => 'nullable|string',
            'filiale_id' => 'nullable|exists:filiales,id',
        ]);

        $position->update([
            'name' => $request->name,
            'description' => $request->description,
            'filiale_id' => $request->filiale_id,
        ]);

        ActivityLogger::log('positions', 'update', 'Mise à jour du poste : ' . $position->name);

        return redirect()->route('positions.index')->with('success', 'Poste mis à jour avec succès.');
    }

    /**
     * Supprimer un poste
     */
    public function destroy(Position $position)
    {
        ActivityLogger::log('positions', 'delete', 'Suppression du poste : ' . $position->name);
        $position->delete();

        return redirect()->route('positions.index')->with('success', 'Poste supprimé avec succès.');
    }
}




