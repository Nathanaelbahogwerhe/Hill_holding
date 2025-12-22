<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::orderBy('category')->orderBy('key')->get();
        
        // Grouper les paramètres par catégorie
        $settingsByCategory = $settings->groupBy('category');
        
        // Liste des catégories pour le filtre
        $categories = $settingsByCategory->keys();
        
        $totalCount = $settings->count();

        return view('admin.system-settings.index', compact('settingsByCategory', 'categories', 'totalCount'));
    }

    public function create()
    {
        return view('admin.system-settings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:system_settings',
            'value' => 'nullable',
            'type' => 'required|in:text,boolean,number,json',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        SystemSetting::create($validated);

        return redirect()->route('admin.system-settings.index')->with('success', 'Paramètre créé');
    }

    public function edit(SystemSetting $systemSetting)
    {
        return view('admin.system-settings.edit', compact('systemSetting'));
    }

    public function update(Request $request, SystemSetting $systemSetting)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:system_settings,key,' . $systemSetting->id,
            'value' => 'nullable',
            'type' => 'required|in:text,boolean,number,json',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        $systemSetting->update($validated);

        return redirect()->route('admin.system-settings.index')->with('success', 'Paramètre mis à jour');
    }

    public function destroy(SystemSetting $systemSetting)
    {
        $systemSetting->delete();
        return redirect()->route('admin.system-settings.index')->with('success', 'Paramètre supprimé');
    }

    // Toggle maintenance mode
    public function toggleMaintenance()
    {
        $current = SystemSetting::getValue('maintenance_mode', false);
        SystemSetting::setValue('maintenance_mode', !$current, 'system', 'boolean');
        
        $status = !$current ? 'activé' : 'désactivé';
        
        return redirect()->back()->with('success', "Mode maintenance $status");
    }
}
