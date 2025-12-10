<?php

namespace App\Http\Controllers;

use App\Models\EmployeeInsurance;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeInsuranceController extends Controller
{
    public function index()
    {
        $insurances = EmployeeInsurance::with('employee')->latest()->paginate(10);
        return view('employee_insurances.index', compact('insurances'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('employee_insurances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id'       => 'required|exists:employees,id',
            'insurance_provider'=> 'required|string|max:255',
            'policy_number'     => 'required|string|max:255|unique:employee_insurances,policy_number',
            'coverage_start'    => 'required|date',
            'coverage_end'      => 'nullable|date|after_or_equal:coverage_start',
            'premium_amount'    => 'required|numeric|min:0',
        ]);

        EmployeeInsurance::create($validated);

        return redirect()->route('employee-insurances.index')
            ->with('success', 'Assurance employÃ© crÃ©Ã©e avec succÃ¨s.');
    }

    public function show(EmployeeInsurance $employeeInsurance)
    {
        return view('employee_insurances.show', compact('employeeInsurance'));
    }

    public function edit(EmployeeInsurance $employeeInsurance)
    {
        $employees = Employee::all();
        return view('employee_insurances.edit', compact('employeeInsurance', 'employees'));
    }

    public function update(Request $request, EmployeeInsurance $employeeInsurance)
    {
        $validated = $request->validate([
            'employee_id'       => 'required|exists:employees,id',
            'insurance_provider'=> 'required|string|max:255',
            'policy_number'     => 'required|string|max:255|unique:employee_insurances,policy_number,' . $employeeInsurance->id,
            'coverage_start'    => 'required|date',
            'coverage_end'      => 'nullable|date|after_or_equal:coverage_start',
            'premium_amount'    => 'required|numeric|min:0',
        ]);

        $employeeInsurance->update($validated);

        return redirect()->route('employee-insurances.index')
            ->with('success', 'Assurance employÃ© mise Ã  jour avec succÃ¨s.');
    }

    public function destroy(EmployeeInsurance $employeeInsurance)
    {
        $employeeInsurance->delete();

        return redirect()->route('employee-insurances.index')
            ->with('success', 'Assurance employÃ© supprimÃ©e avec succÃ¨s.');
    }
}







