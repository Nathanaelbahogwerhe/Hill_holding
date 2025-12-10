<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Liste tous les assets
     */
    public function index()
    {
        $assets = Asset::latest()->paginate(10);
        return view('assets.index', compact('assets'));
    }

    /**
     * Formulaire de crÃ©ation
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Enregistre un nouvel asset
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category'         => 'required|string|max:255',
            'value'            => 'nullable|numeric|min:0',
            'acquisition_date' => 'nullable|date',
            'status'           => 'required|string|in:active,inactive,maintenance,disposed',
            'description'      => 'nullable|string',
        ]);

        Asset::create($validated);

        return redirect()->route('assets.index')->with('success', 'Actif ajoutÃ© avec succÃ¨s âœ…');
    }

    /**
     * Affiche un asset
     */
    public function show(Asset $asset)
    {
        return view('assets.show', compact('asset'));
    }

    /**
     * Formulaire dâ€™Ã©dition
     */
    public function edit(Asset $asset)
    {
        return view('assets.edit', compact('asset'));
    }

    /**
     * Met Ã  jour un asset
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category'         => 'required|string|max:255',
            'value'            => 'nullable|numeric|min:0',
            'acquisition_date' => 'nullable|date',
            'status'           => 'required|string|in:active,inactive,maintenance,disposed',
            'description'      => 'nullable|string',
        ]);

        $asset->update($validated);

        return redirect()->route('assets.index')->with('success', 'Actif mis Ã  jour avec succÃ¨s âœï¸');
    }

    /**
     * Supprime un asset
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Actif supprimÃ© âŒ');
    }
}







