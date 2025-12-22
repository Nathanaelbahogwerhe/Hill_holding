<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Filiale;
use App\Models\Agence;
use App\Models\Position;
use App\Models\User;
use App\Helpers\Notify;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\DashboardUpdated;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    use FileUploadTrait;
    /**
     * 🧾 Liste des employés avec recherche et filtre
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Employee::query()->with(['department', 'filiale', 'agence', 'position']);

        // 🔍 Recherche
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // 🏛 Filtrage par filiale
        if ($request->filled('filiale')) {
            $query->where('filiale_id', $request->filiale);
        }

        // 🏪 Filtrage par agence
        if ($request->filled('agency')) {
            $query->where('agency_id', $request->agency);
        }

        // 🔐 Permissions selon le rôle
        if ($user->hasRole('Super Admin')) {
            $employees = $query->orderBy('first_name')->paginate(10);
        } elseif ($user->filiale_id) {
            $employees = $query->where('filiale_id', $user->filiale_id)
                               ->orderBy('first_name')
                               ->paginate(10);
        } elseif ($user->agency_id) {
            $employees = $query->where('agency_id', $user->agency_id)
                               ->orderBy('first_name')
                               ->paginate(10);
        } else {
            $employees = collect(); // Aucun accès
        }

        $filiales = Filiale::orderBy('name')->get();
        $agences = Agence::orderBy('name')->get();

        return view('employees.index', compact('employees', 'filiales', 'agences'));
    }

    /**
     * ➕ Formulaire de création d'un employé
     */
    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        $filiales = Filiale::all();
        $agences = Agence::all();
        $users = User::all();

        return view('employees.create', compact('departments', 'positions', 'filiales', 'agences', 'users'));
    }

    /**
     * 💾 Enregistrement d'un nouvel employé
     */
    public function store(EmployeeRequest $request)
    {
        $data = $request->validated();

        // Handle id_document_file securely on the 'local' (private) disk
        if ($request->hasFile('id_document_file')) {
            $file = $request->file('id_document_file');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_.]/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('employee_documents', $filename, ['disk' => 'local']);
            $data['id_document_file'] = $path;
        }

        // Handle public attachment (CV, certificates, etc.)
        if ($request->hasFile('attachments')) {
            $data['attachments'] = $this->uploadFiles($request->file('attachments'), 'hr/employees');
        }

        $employee = Employee::create(array_merge([
            'basic_salary' => $request->basic_salary ?? 0,
        ], $data));

        // Notification aux admins
        Notify::admins(
            'Nouvel employé ajouté',
            'Un nouvel employé a été ajouté : ' . $employee->first_name . ' ' . $employee->last_name,
            route('employees.show', $employee)
        );

        event(new DashboardUpdated('employee_created', [
            'id' => $employee->id,
            'name' => $employee->first_name . ' ' . $employee->last_name,
            'department' => optional($employee->department)->name,
        ]));

        return redirect()->route('employees.index')->with('success', 'Employé créé avec succès.');
    }

    /**
     * 👁️ Affichage d'un employé
     */
    public function show(Employee $employee)
    {
        $employee->load([
            'department',
            'filiale',
            'agence',
            'position',
            'user',
            'contracts',
            'payrolls',
            'leaves.leaveType',
            'attendances',
            'insurances.insurancePlan',
            'tasks.project',
            'projects',
            'messagesSent',
            'messagesReceived'
        ]);

        return view('employees.show', compact('employee'));
    }

    /**
     * Download private id document (protected)
     */
    public function downloadDocument(Employee $employee)
    {
        $this->authorize('downloadDocument', $employee);

        if (!$employee->id_document_file || !Storage::disk('local')->exists($employee->id_document_file)) {
            abort(404);
        }

        return Storage::disk('local')->download($employee->id_document_file);
    }

    /**
     * ✏️ Formulaire d'édition
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $positions = Position::all();
        $filiales = Filiale::all();
        $agences = Agence::all();
        $users = User::all();

        return view('employees.edit', compact('employee', 'departments', 'positions', 'filiales', 'agences', 'users'));
    }

    /**
     * 🔁 Mise à jour
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();

        if ($request->hasFile('id_document_file')) {
            // delete previous file if exists
            if ($employee->id_document_file && Storage::disk('local')->exists($employee->id_document_file)) {
                Storage::disk('local')->delete($employee->id_document_file);
            }

            $file = $request->file('id_document_file');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_.]/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('employee_documents', $filename, ['disk' => 'local']);
            $data['id_document_file'] = $path;
        }

        // Handle public attachment
        if ($request->hasFile('attachments')) {
            $data['attachments'] = $this->mergeAttachments(
                $employee->attachments,
                $request->file('attachments'),
                'hr/employees'
            );
        }

        $employee->update($data);

        event(new DashboardUpdated('employee_updated', [
            'id' => $employee->id,
            'name' => $employee->first_name . ' ' . $employee->last_name,
        ]));

        return redirect()->route('employees.show', $employee->id)->with('success', 'Employé mis à jour avec succès.');
    }

    /**
     * 🗑️ Suppression
     */
    public function destroy(Employee $employee)
    {
        // Delete attachments if exist
        if ($employee->attachments) {
            $this->deleteFiles(array_column($employee->attachments, 'path'));
        }

        $employee->delete();

        event(new DashboardUpdated('employee_deleted', [
            'id' => $employee->id,
            'name' => $employee->first_name . ' ' . $employee->last_name,
        ]));

        return redirect()->route('employees.index')->with('success', 'Employé supprimé avec succès.');
    }

    /**
     * Download attachment
     */
    public function downloadAttachment(Employee $employee, $index)
    {
        if (!isset($employee->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($employee->attachments[$index]);
    }

    /**
     * Delete attachment
     */
    public function deleteAttachment(Employee $employee, $index)
    {
        if (!isset($employee->attachments[$index])) {
            abort(404);
        }
        $employee->attachments = $this->removeAttachment($employee->attachments, $index);
        $employee->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}
