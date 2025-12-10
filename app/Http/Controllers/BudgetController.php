<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Budget::query()->with('project', 'filiale');

        // HillHolding voit tous les budgets
        if ($user->hasRole('superadmin')) {
            $budgets = $query->get();
        }
        // Filiale voit uniquement ses budgets
        elseif ($user->filiale_id) {
            $budgets = $query->where('filiale_id', $user->filiale_id)->get();
        } else {
            $budgets = collect();
        }

        return view('budgets.index', compact('budgets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $budget = Budget::create($request->all());

        return redirect()->route('budgets.index')->with('success', 'Budget crÃ©Ã© avec succÃ¨s.');
    }

    public function show(Budget $budget)
    {
        return view('budgets.show', compact('budget'));
    }

    public function update(Request $request, Budget $budget)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $budget->update($request->all());

        return redirect()->route('budgets.index')->with('success', 'Budget mis Ã  jour.');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Budget supprimÃ©.');
    }
}







