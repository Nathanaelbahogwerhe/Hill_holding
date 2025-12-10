<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\Employee;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index()
    {
        $performances = Performance::with('employee')->get();
        return view('performances.index', compact('performances'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('performances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'score'       => 'required|integer|min:0|max:100',
            'review'      => 'nullable|string',
        ]);

        Performance::create($request->all());

        return redirect()->route('performances.index')->with('success', 'Ã‰valuation enregistrÃ©e avec succÃ¨s.');
    }

    public function show(Performance $performance)
    {
        return view('performances.show', compact('performance'));
    }

    public function edit(Performance $performance)
    {
        $employees = Employee::all();
        return view('performances.edit', compact('performance', 'employees'));
    }

    public function update(Request $request, Performance $performance)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'score'       => 'required|integer|min:0|max:100',
            'review'      => 'nullable|string',
        ]);

        $performance->update($request->all());

        return redirect()->route('performances.index')->with('success', 'Ã‰valuation mise Ã  jour avec succÃ¨s.');
    }

    public function destroy(Performance $performance)
    {
        $performance->delete();
        return redirect()->route('performances.index')->with('success', 'Ã‰valuation supprimÃ©e avec succÃ¨s.');
    }
}







