<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Revenue;
use App\Models\Filiale;
use App\Models\Agence;

class RevenueController extends Controller
{
    /**
     * Afficher toutes les recettes selon le rôle/hierarchie
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Revenue::with(['filiale', 'agence']);

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        // Super admin : voir toutes les recettes
        if ($user->hasRole('superadmin')) {
            $revenues = $query->latest()->get();
        }
        // Filiale : voir ses recettes et celles de ses agences
        elseif ($user->filiale_id) {
            $revenues = $query->where('filiale_id', $user->filiale_id)
                              ->latest()
                              ->get();
        }
        // Agence : voir seulement ses recettes
        elseif ($user->agence_id) {
            $revenues = $query->where('agence_id', $user->agence_id)
                              ->latest()
                              ->get();
        }
        else {
            $revenues = collect();
        }

        return view('finance.revenues.index', compact('revenues'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $user = Auth::user();

        $filiales = $user->filiale_id 
            ? Filiale::where('id', $user->filiale_id)->get() 
            : Filiale::all();

        $agences = $user->filiale_id
            ? Agence::where('filiale_id', $user->filiale_id)->get()
            : Agence::all();

        return view('finance.revenues.create', compact('filiales', 'agences'));
    }

    /**
     * Stocker une nouvelle recette
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'filiale_id'  => 'nullable|exists:filiales,id',
            'agence_id'   => 'nullable|exists:agences,id',
            'date'        => 'required|date',
            'attachment'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only(['description', 'amount', 'date', 'filiale_id', 'agence_id']);
        
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('revenues/attachments', 'public');
        }

        Revenue::create($data);

        return redirect()->route('revenues.index')
                         ->with('success', 'Revenu créé avec succès.');
    }

    /**
     * Voir une recette
     */
    public function show(Revenue $revenue)
    {
        return view('finance.revenues.show', compact('revenue'));
    }

    /**
     * Formulaire édition
     */
    public function edit(Revenue $revenue)
    {
        $user = Auth::user();

        $filiales = $user->filiale_id 
            ? Filiale::where('id', $user->filiale_id)->get() 
            : Filiale::all();

        $agences = $user->filiale_id
            ? Agence::where('filiale_id', $user->filiale_id)->get()
            : Agence::all();

        return view('finance.revenues.edit', compact('revenue', 'filiales', 'agences'));
    }

    /**
     * Mettre à jour la recette
     */
    public function update(Request $request, Revenue $revenue)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'filiale_id'  => 'nullable|exists:filiales,id',
            'agence_id'   => 'nullable|exists:agences,id',
            'date'        => 'required|date',
            'attachment'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only(['description', 'amount', 'date', 'filiale_id', 'agence_id']);
        
        if ($request->hasFile('attachment')) {
            if ($revenue->attachment && Storage::disk('public')->exists($revenue->attachment)) {
                Storage::disk('public')->delete($revenue->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('revenues/attachments', 'public');
        }

        $revenue->update($data);

        return redirect()->route('revenues.show', $revenue->id)
                         ->with('success', 'Revenu mis à jour avec succès.');
    }

    /**
     * Supprimer une recette
     */
    public function destroy(Revenue $revenue)
    {
        if ($revenue->attachment && Storage::disk('public')->exists($revenue->attachment)) {
            Storage::disk('public')->delete($revenue->attachment);
        }
        $revenue->delete();

        return redirect()->route('revenues.index')
                         ->with('success', 'Revenu supprimé avec succès.');
    }
}
