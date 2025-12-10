<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $finances = Finance::latest()->paginate(10);
        return view('finance.index', compact('finances'));
    }

    public function create()
    {
        return view('finance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'finance_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Finance::create($validated);

        return redirect()->route('finances.index')->with('success', 'Finance enregistrÃ©e avec succÃ¨s.');
    }

    public function show(Finance $finance)
    {
        return view('finance.show', compact('finance'));
    }

    public function edit(Finance $finance)
    {
        return view('finance.edit', compact('finance'));
    }

    public function update(Request $request, Finance $finance)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'finance_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $finance->update($validated);

        return redirect()->route('finances.index')->with('success', 'Finance mise Ã  jour avec succÃ¨s.');
    }

    public function destroy(Finance $finance)
    {
        $finance->delete();
        return redirect()->route('finances.index')->with('success', 'Finance supprimÃ©e.');
    }
}







