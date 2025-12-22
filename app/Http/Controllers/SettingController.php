<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Liste tous les paramètres
     */
    public function index()
    {
        $settings = Setting::latest()->paginate(10);
        return view('settings.index', compact('settings'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Enregistre un nouveau paramètre
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key'   => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        Setting::create($validated);

        return redirect()->route('settings.index')->with('success', 'Paramètre ajouté ✅');
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Setting $setting)
    {
        return view('settings.edit', compact('setting'));
    }

    /**
     * Met à jour un paramètre
     */
    public function update(Request $request, Setting $setting)
    {
        $validated = $request->validate([
            'key'   => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $setting->update($validated);

        return redirect()->route('settings.index')->with('success', 'Paramètre mis à jour ✏️');
    }

    /**
     * Supprime un paramètre
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('settings.index')->with('success', 'Paramètre supprimé ❌');
    }
}
