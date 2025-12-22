<?php

namespace App\Http\Controllers;

use App\Models\EmployeeInsurance;
use App\Models\Employee;
use App\Models\InsurancePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeInsuranceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = EmployeeInsurance::with(['employee', 'employee.filiale', 'insurancePlan']);

        if ($request->filled('search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($user->hasRole('Super Admin')) {
            $insurances = $query->paginate(10);
        } elseif ($user->filiale_id) {
            $insurances = $query->whereHas('employee', function ($q) use ($user) {
                $q->where('filiale_id', $user->filiale_id)
                  ->orWhereNull('filiale_id');
            })->paginate(10);
        } else {
            $insurances = $query->whereHas('employee', function ($q) {
                $q->whereNull('filiale_id');
            })->paginate(10);
        }

        return view('employee_insurances.index', compact('insurances'));
    }

    public function create()
    {
        $user = Auth::user();
        
        $employees = $user->filiale_id
            ? Employee::where('filiale_id', $user->filiale_id)->orWhereNull('filiale_id')->get()
            : Employee::whereNull('filiale_id')->get();

        $insurance_plans = InsurancePlan::all();

        return view('employee_insurances.create', compact('employees', 'insurance_plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id'       => 'required|exists:employees,id',
            'insurance_plan_id' => 'required|exists:insurance_plans,id',
            'start_date'        => 'required|date',
            'end_date'          => 'nullable|date|after:start_date',
            'status'            => 'required|in:active,inactive',
        ]);

        EmployeeInsurance::create($validated);

        return redirect()->route('employee_insurances.index')
                         ->with('success', 'Assurance créée.');
    }

    public function show(EmployeeInsurance $employee_insurance)
    {
        return view('employee_insurances.show', ['insurance' => $employee_insurance]);
    }

    public function edit(EmployeeInsurance $employee_insurance)
    {
        $user = Auth::user();
        
        $employees = $user->filiale_id
            ? Employee::where('filiale_id', $user->filiale_id)->orWhereNull('filiale_id')->get()
            : Employee::whereNull('filiale_id')->get();

        $insurance_plans = InsurancePlan::all();

        return view('employee_insurances.edit', [
            'insurance'       => $employee_insurance,
            'employees'       => $employees,
            'insurance_plans' => $insurance_plans,
        ]);
    }

    public function update(Request $request, EmployeeInsurance $employee_insurance)
    {
        $validated = $request->validate([
            'employee_id'       => 'required|exists:employees,id',
            'insurance_plan_id' => 'required|exists:insurance_plans,id',
            'start_date'        => 'required|date',
            'end_date'          => 'nullable|date|after:start_date',
            'status'            => 'required|in:active,inactive',
        ]);

        $employee_insurance->update($validated);

        return redirect()->route('employee_insurances.show', $employee_insurance)
                         ->with('success', 'Assurance mise à jour.');
    }

    public function destroy(EmployeeInsurance $employee_insurance)
    {
        $employee_insurance->delete();
        return redirect()->route('employee_insurances.index')->with('success', 'Assurance supprimée.');
    }
}
