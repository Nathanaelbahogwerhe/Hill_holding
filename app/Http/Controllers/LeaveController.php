<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    use FileUploadTrait;

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Leave::with(['employee', 'employee.filiale', 'leaveType']);

        if ($request->filled('search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($user->hasRole('Super Admin')) {
            $leaves = $query->paginate(10);
        } elseif ($user->filiale_id) {
            $leaves = $query->whereHas('employee', function ($q) use ($user) {
                $q->where('filiale_id', $user->filiale_id)
                  ->orWhereNull('filiale_id');
            })->paginate(10);
        } else {
            $leaves = $query->whereHas('employee', function ($q) {
                $q->whereNull('filiale_id');
            })->paginate(10);
        }

        return view('leaves.index', compact('leaves'));
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

        $leave_types = LeaveType::all();

        return view('leaves.create', compact('employees', 'leave_types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after:start_date',
            'status'        => 'required|in:pending,approved,rejected',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachments')) {
            $data['attachments'] = $this->uploadFiles($request->file('attachments'), 'hr/leaves');
        }

        Leave::create($data);

        return redirect()->route('leaves.index')->with('success', 'Congé créé.');
    }

    public function show(Leave $leave)
    {
        return view('leaves.show', compact('leave'));
    }

    public function edit(Leave $leave)
    {
        $user = Auth::user();
        
        if ($user->filiale_id) {
            $employees = Employee::where('filiale_id', $user->filiale_id)
                                ->orWhereNull('filiale_id')
                                ->get();
        } else {
            $employees = Employee::whereNull('filiale_id')->get();
        }

        $leave_types = LeaveType::all();

        return view('leaves.edit', compact('leave', 'employees', 'leave_types'));
    }

    public function update(Request $request, Leave $leave)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after:start_date',
            'status'        => 'required|in:pending,approved,rejected',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachments')) {
            $data['attachments'] = $this->mergeAttachments(
                $leave->attachments ?? [],
                $request->file('attachments'),
                'hr/leaves'
            );
        }

        $leave->update($data);

        return redirect()->route('leaves.show', $leave->id)
                         ->with('success', 'Congé mis à jour.');
    }

    public function destroy(Leave $leave)
    {
        // Supprimer les fichiers attachés
        if (!empty($leave->attachments)) {
            $this->deleteFiles(array_column($leave->attachments, 'path'));
        }
        
        $leave->delete();
        return redirect()->route('leaves.index')->with('success', 'Congé supprimé.');
    }

    public function downloadAttachment(Leave $leave, $index)
    {
        if (!isset($leave->attachments[$index])) {
            abort(404, 'Fichier non trouvé.');
        }

        return $this->downloadFile($leave->attachments[$index]);
    }

    public function deleteAttachment(Leave $leave, $index)
    {
        if (!isset($leave->attachments[$index])) {
            abort(404, 'Fichier non trouvé.');
        }

        $attachments = $leave->attachments;
        $fileToDelete = $attachments[$index];
        
        // Supprimer le fichier du stockage
        $this->deleteFiles([$fileToDelete['path']]);
        
        // Retirer du tableau et réindexer
        array_splice($attachments, $index, 1);
        $leave->attachments = array_values($attachments);
        $leave->save();

        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}




