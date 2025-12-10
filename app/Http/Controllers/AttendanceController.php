<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->get();
        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('attendances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date'        => 'required|date',
            'status'      => 'required|in:present,absent,late',
        ]);

        Attendance::create($request->all());

        return redirect()->route('attendances.index')->with('success', 'PrÃ©sence enregistrÃ©e avec succÃ¨s.');
    }

    public function show(Attendance $attendance)
    {
        return view('attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();
        return view('attendances.edit', compact('attendance', 'employees'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date'        => 'required|date',
            'status'      => 'required|in:present,absent,late',
        ]);

        $attendance->update($request->all());

        return redirect()->route('attendances.index')->with('success', 'PrÃ©sence mise Ã  jour avec succÃ¨s.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'PrÃ©sence supprimÃ©e avec succÃ¨s.');
    }
}







