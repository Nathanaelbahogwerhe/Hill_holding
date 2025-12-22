<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Filiale;
use App\Models\Agence;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    /**
     * Liste toutes les dépenses
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            $expenses = Expense::with(['filiale', 'agence'])->latest()->get();
        } elseif ($user->filiale_id && !$user->agence_id) {
            $expenses = Expense::where('filiale_id', $user->filiale_id)
                ->with(['filiale', 'agence'])
                ->latest()
                ->get();
        } elseif ($user->agence_id) {
            $expenses = Expense::where('agence_id', $user->agence_id)
                ->with(['filiale', 'agence'])
                ->latest()
                ->get();
        } else {
            $expenses = collect(); // pas de droits
        }

        return view('expenses.index', compact('expenses'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $filiales = Filiale::all();
        $agences  = Agence::all();

        return view('expenses.create', compact('filiales', 'agences'));
    }

    /**
     * Enregistrement d'une dépense
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'category'    => 'required|string|max:100',
            'filiale_id'  => 'nullable|exists:filiales,id',
            'agence_id'   => 'nullable|exists:agences,id',
            'attachment'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('expenses/attachments', 'public');
        }

        $expense = Expense::create($validated);

        // Mettre à jour les budgets concernés
        $this->updateRelatedBudgets($expense);

        return redirect()->route('expenses.index')
            ->with('success', 'Dépense enregistrée avec succès.');
    }

    /**
     * Afficher une dépense
     */
    public function show(Expense $expense)
    {
        $this->authorizeAccess($expense);

        return view('expenses.show', compact('expense'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Expense $expense)
    {
        $this->authorizeAccess($expense);

        $filiales = Filiale::all();
        $agences  = Agence::all();

        return view('expenses.edit', compact('expense', 'filiales', 'agences'));
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, Expense $expense)
    {
        $this->authorizeAccess($expense);

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'category'    => 'required|string|max:100',
            'filiale_id'  => 'nullable|exists:filiales,id',
            'agence_id'   => 'nullable|exists:agences,id',
            'attachment'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            if ($expense->attachment && Storage::disk('public')->exists($expense->attachment)) {
                Storage::disk('public')->delete($expense->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('expenses/attachments', 'public');
        }

        // Stocker les anciennes valeurs pour recalculer les budgets
        $oldCategory = $expense->category;
        $oldFilialeId = $expense->filiale_id;
        $oldAgenceId = $expense->agence_id;
        $oldDate = $expense->date;

        $expense->update($validated);

        // Mettre à jour les anciens et nouveaux budgets concernés
        $this->updateRelatedBudgets($expense, [
            'category' => $oldCategory,
            'filiale_id' => $oldFilialeId,
            'agence_id' => $oldAgenceId,
            'date' => $oldDate,
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Dépense mise à jour avec succès.');
    }

    /**
     * Suppression
     */
    public function destroy(Expense $expense)
    {
        $this->authorizeAccess($expense);

        if ($expense->attachment && Storage::disk('public')->exists($expense->attachment)) {
            Storage::disk('public')->delete($expense->attachment);
        }

        // Stocker les données avant suppression pour recalcul des budgets
        $expenseData = [
            'category' => $expense->category,
            'filiale_id' => $expense->filiale_id,
            'agence_id' => $expense->agence_id,
            'date' => $expense->date,
        ];

        $expense->delete();

        // Mettre à jour les budgets concernés après suppression
        $this->updateRelatedBudgets(null, $expenseData);

        return redirect()->route('expenses.index')
            ->with('success', 'Dépense supprimée avec succès.');
    }

    /**
     * Vérifie que l’utilisateur a bien accès à la dépense
     */
    private function authorizeAccess(Expense $expense)
    {
        $user = auth()->user();

        if (!$user->canAccessExpense($expense)) {
            abort(403, 'Accès non autorisé.');
        }
    }
    /**
     * Met à jour les budgets concernés par cette dépense
     */
    private function updateRelatedBudgets(?Expense $expense, ?array $oldData = null)
    {
        $categoriesToUpdate = [];
        $filialeIdsToUpdate = [];
        $agenceIdsToUpdate = [];
        $datesToCheck = [];

        // Collecter les données actuelles (nouvelle ou modifiée)
        if ($expense) {
            $categoriesToUpdate[] = $expense->category;
            $filialeIdsToUpdate[] = $expense->filiale_id;
            $agenceIdsToUpdate[] = $expense->agence_id;
            $datesToCheck[] = $expense->date;
        }

        // Collecter les anciennes données si modification ou suppression
        if ($oldData) {
            $categoriesToUpdate[] = $oldData['category'];
            $filialeIdsToUpdate[] = $oldData['filiale_id'];
            $agenceIdsToUpdate[] = $oldData['agence_id'];
            $datesToCheck[] = $oldData['date'];
        }

        // Supprimer les doublons
        $categoriesToUpdate = array_unique(array_filter($categoriesToUpdate));
        $filialeIdsToUpdate = array_unique(array_filter($filialeIdsToUpdate));
        $agenceIdsToUpdate = array_unique(array_filter($agenceIdsToUpdate));

        // Trouver et mettre à jour tous les budgets concernés
        foreach ($categoriesToUpdate as $category) {
            foreach ($filialeIdsToUpdate as $filialeId) {
                // Budgets au niveau filiale
                $budgets = Budget::where('category', $category)
                    ->where('filiale_id', $filialeId)
                    ->whereNull('agence_id')
                    ->get();

                foreach ($budgets as $budget) {
                    $budget->updateUsage();
                }

                // Budgets au niveau agence
                foreach ($agenceIdsToUpdate as $agenceId) {
                    $budgets = Budget::where('category', $category)
                        ->where('filiale_id', $filialeId)
                        ->where('agence_id', $agenceId)
                        ->get();

                    foreach ($budgets as $budget) {
                        $budget->updateUsage();
                    }
                }
            }
        }
    }}




