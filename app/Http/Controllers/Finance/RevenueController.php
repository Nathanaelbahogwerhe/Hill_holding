<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Revenue;
use Illuminate\Support\Facades\Auth;

class RevenueController extends Controller
{
    /**
     * Afficher toutes les recettes selon le rÃ´le/hierarchie
     */
    public function index()
    {
        $user = Auth::user();
        $query = Revenue::query();

        // HillHolding â†’ voir toutes les recettes
        if ($user->hasRole('superadmin')) {
            $revenues = $query->with('project', 'filiale', 'agency')->get();
        }
        // Filiale â†’ voir ses recettes et celles de ses agences
        elseif ($user->filiale_id) {
            $revenues = $query->where('filiale_id', $user->filiale_id)
                              ->orWhereHas('agency', function($q) use ($user) {
                                  $q->where('filiale_id', $user->filiale_id);
                              })
                              ->with('project', 'filiale', 'agency')
                              ->get();
        }
        // Agence â†’ voir seulement ses recettes
        elseif ($user->agency_id) {
            $revenues = $query->where('agency_id', $user->agency_id)
                              ->with('project', 'filiale', 'agency')
                              ->get();
        } else {
            $revenues = collect();
        }

        return view('finance.revenues.index', compact('revenues'));
    }

    /**
     * Formulaire de crÃ©ation
     */
    public function create()
    {
        return view('finance.revenues.create');
    }

    /**
     * Stocker une nouvelle recette
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'source' => 'required|string',
            'project_id' => 'nullable|exists:projects,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agency_id' => 'nullable|exists:agencies,id',
            'description' => 'nullable|string',
        ]);

        Revenue::create($request->all());

        return redirect()->route('revenues.index')
                         ->with('success', 'Recette ajoutÃ©e avec succÃ¨s.');
    }

    /**
     * Voir une recette
     */
    public function show(Revenue $revenue)
    {
        return view('finance.revenues.show', compact('revenue'));
    }

    /**
     * Formulaire Ã©dition
     */
    public function edit(Revenue $revenue)
    {
        return view('finance.revenues.edit', compact('revenue'));
    }

    /**
     * Mettre Ã  jour la recette
     */
    public function update(Request $request, Revenue $revenue)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'source' => 'required|string',
            'project_id' => 'nullable|exists:projects,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agency_id' => 'nullable|exists:agencies,id',
            'description' => 'nullable|string',
        ]);

        $revenue->update($request->all());

        return redirect()->route('revenues.index')
                         ->with('success', 'Recette mise Ã  jour avec succÃ¨s.');
    }

    /**
     * Supprimer une recette
     */
    public function destroy(Revenue $revenue)
    {
        $revenue->delete();
        return redirect()->route('revenues.index')
                         ->with('success', 'Recette supprimÃ©e avec succÃ¨s.');
    }
}







