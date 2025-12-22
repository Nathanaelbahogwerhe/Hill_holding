<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Project;
use App\Models\Filiale;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BudgetController extends Controller
{
    /**
     * 📋 Liste des budgets selon le périmètre
     */
    public function index()
    {
        $user = Auth::user();

        $query = Budget::with(['project', 'filiale', 'agence']);

        // 🏢 Maison mère
        if ($user->hasRole('superadmin')) {
            $budgets = $query->latest()->get();
        }
        // 🏬 Filiale
        elseif ($user->filiale_id) {
            $budgets = $query
                ->where('filiale_id', $user->filiale_id)
                ->latest()
                ->get();
        }
        // 🏪 Agence → pas de budgets
        else {
            $budgets = collect();
        }

        return view('budgets.index', compact('budgets'));
    }

    /**
     * ➕ Formulaire de création
     */
    public function create()
    {
        $user = Auth::user();

        // ❌ Agence ne crée pas de budget
        // ❌ Agence ne crée pas de budget
        if ($user->agence_id && !$user->hasRole('superadmin')) {
            abort(403, 'Une agence ne peut pas créer de budget.');
        }

        $isMaisonMere = $user->hasRole('superadmin');

        // 🏢 Maison mère → toutes les filiales
        if ($isMaisonMere) {
            $filiales = Filiale::orderBy('name')->get();
            $agences  = Agence::orderBy('name')->get();
        }
        // 🏬 Filiale → sa filiale + ses agences
        else {
            $filiales = Filiale::where('id', $user->filiale_id)->get();
            $agences  = Agence::where('filiale_id', $user->filiale_id)->get();
        }

        return view('budgets.create', compact(
            'filiales',
            'agences',
            'isMaisonMere'
        ));
    }

    /**
     * 💾 Enregistrer le budget
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'required|string|max:100',
            'filiale_id' => 'required|exists:filiales,id',
            'agence_id'  => 'nullable|exists:agences,id',
            'amount'     => 'required|numeric|min:0',
            'description'=> 'nullable|string|max:500',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'status'     => 'nullable|in:active,inactive',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        // 🔐 Sécurité : une filiale ne peut créer que pour elle-même
        if (!$user->hasRole('superadmin') && $request->filiale_id != $user->filiale_id) {
            abort(403, 'Action non autorisée.');
        }

        $data = [
            'title'      => $request->title,
            'category'   => $request->category,
            'filiale_id' => $request->filiale_id,
            'agence_id'  => $request->agence_id,
            'amount'     => $request->amount,
            'amount_used'=> 0,
            'percentage_used' => 0,
            'description'=> $request->description,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'status'     => $request->status ?? 'active',
        ];

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('budgets/attachments', 'public');
        }

        $budget = Budget::create($data);
        
        // Calculer l'utilisation initiale basée sur les dépenses existantes
        $budget->updateUsage();

        return redirect()
            ->route('budgets.index')
            ->with('success', '✅ Budget créé avec succès.');
    }

    /**
     * 👁️ Détail d’un budget
     */
    public function show(Budget $budget)
    {
        $user = Auth::user();

        if (
            !$user->hasRole('superadmin') &&
            $budget->filiale_id !== $user->filiale_id
        ) {
            abort(403);
        }

        return view('budgets.show', compact('budget'));
    }

    /**
     * ✏️ Formulaire d'édition
     */
    public function edit(Budget $budget)
    {
        $user = Auth::user();

        if (
            !$user->hasRole('superadmin') &&
            $budget->filiale_id !== $user->filiale_id
        ) {
            abort(403);
        }

        $isMaisonMere = $user->hasRole('superadmin');

        // 🏢 Maison mère → toutes les filiales
        if ($isMaisonMere) {
            $filiales = Filiale::orderBy('name')->get();
            $agences  = Agence::orderBy('name')->get();
        }
        // 🏬 Filiale → sa filiale + ses agences
        else {
            $filiales = Filiale::where('id', $user->filiale_id)->get();
            $agences  = Agence::where('filiale_id', $user->filiale_id)->get();
        }

        return view('budgets.edit', compact('budget', 'filiales', 'agences', 'isMaisonMere'));
    }

    /**
     * 🔄 Mise à jour
     */
    public function update(Request $request, Budget $budget)
    {
        $user = Auth::user();

        if (
            !$user->hasRole('superadmin') &&
            $budget->filiale_id !== $user->filiale_id
        ) {
            abort(403);
        }

        $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'required|string|max:100',
            'filiale_id' => 'required|exists:filiales,id',
            'agence_id'  => 'nullable|exists:agences,id',
            'amount'     => 'required|numeric|min:0',
            'description'=> 'nullable|string|max:500',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'status'     => 'nullable|in:active,inactive',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        // 🔐 Sécurité : une filiale ne peut modifier que ses budgets
        if (!$user->hasRole('superadmin') && $request->filiale_id != $user->filiale_id) {
            abort(403, 'Action non autorisée.');
        }

        $data = [
            'title'      => $request->title,
            'category'   => $request->category,
            'filiale_id' => $request->filiale_id,
            'agence_id'  => $request->agence_id,
            'amount'     => $request->amount,
            'description'=> $request->description,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'status'     => $request->status ?? 'active',
        ];

        if ($request->hasFile('attachment')) {
            // Supprimer l'ancien fichier
            if ($budget->attachment && Storage::disk('public')->exists($budget->attachment)) {
                Storage::disk('public')->delete($budget->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('budgets/attachments', 'public');
        }

        $budget->update($data);
        
        // Recalculer l'utilisation après modification
        $budget->updateUsage();

        return redirect()
            ->route('budgets.show', $budget)
            ->with('success', '✅ Budget mis à jour avec succès.');
    }

    /**
     * ❌ Suppression
     */
    public function destroy(Budget $budget)
    {
        $user = Auth::user();

        if (
            !$user->hasRole('superadmin') &&
            $budget->filiale_id !== $user->filiale_id
        ) {
            abort(403);
        }

        if ($budget->attachment && Storage::disk('public')->exists($budget->attachment)) {
            Storage::disk('public')->delete($budget->attachment);
        }

        $budget->delete();

        return redirect()
            ->route('budgets.index')
            ->with('success', '🗑 Budget supprimé.');
    }
}
