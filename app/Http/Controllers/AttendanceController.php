<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Filiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Attendance::with(['employee', 'employee.department', 'employee.filiale']);

        if ($request->filled('search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }

        // Filtrer par filiale
        if ($user->hasRole('Super Admin')) {
            $attendances = $query->paginate(10);
        } elseif ($user->filiale_id) {
            $attendances = $query->whereHas('employee', function ($q) use ($user) {
                $q->where('filiale_id', $user->filiale_id)
                  ->orWhereNull('filiale_id'); // Maison mère visible à tous
            })->paginate(10);
        } else {
            $attendances = $query->whereHas('employee', function ($q) {
                $q->whereNull('filiale_id');
            })->paginate(10);
        }

        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if ($user->filiale_id) {
            $employees = Employee::where('filiale_id', $user->filiale_id)
                                ->orWhereNull('filiale_id')
                                ->get();
        } else {
            $employees = Employee::whereNull('filiale_id')->get();
        }

        return view('attendances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'attendance_date' => 'required|date',
            'check_in'      => 'nullable|date_format:H:i',
            'check_out'     => 'nullable|date_format:H:i',
            'status'        => 'required|in:present,absent,late',
            'attachment'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attendances/attachments', 'public');
        }

        Attendance::create($data);

        return redirect()->route('attendances.index')->with('success', 'Présence enregistrée.');
    }

    public function show(Attendance $attendance)
    {
        return view('attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $user = Auth::user();
        
        if ($user->filiale_id) {
            $employees = Employee::where('filiale_id', $user->filiale_id)
                                ->orWhereNull('filiale_id')
                                ->get();
        } else {
            $employees = Employee::whereNull('filiale_id')->get();
        }

        return view('attendances.edit', compact('attendance', 'employees'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'attendance_date' => 'required|date',
            'check_in'      => 'nullable|date_format:H:i',
            'check_out'     => 'nullable|date_format:H:i',
            'status'        => 'required|in:present,absent,late',
            'attachment'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachment')) {
            if ($attendance->attachment && \Storage::disk('public')->exists($attendance->attachment)) {
                \Storage::disk('public')->delete($attendance->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('attendances/attachments', 'public');
        }

        $attendance->update($data);

        return redirect()->route('attendances.show', $attendance->id)
                         ->with('success', 'Présence mise à jour.');
    }

    public function destroy(Attendance $attendance)
    {
        if ($attendance->attachment && \Storage::disk('public')->exists($attendance->attachment)) {
            \Storage::disk('public')->delete($attendance->attachment);
        }
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Présence supprimée.');
    }
}




