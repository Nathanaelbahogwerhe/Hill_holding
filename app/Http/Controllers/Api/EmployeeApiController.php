<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query()->with(['department','filiale','agence','position']);
        if ($request->filled('search')) {
            $query->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%");
        }
        $employees = $query->paginate(15);
        return response()->json($employees);
    }

    public function store(EmployeeRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('id_document_file')) {
            $file = $request->file('id_document_file');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_.]/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('employee_documents', $filename, ['disk' => 'local']);
            $data['id_document_file'] = $path;
        }
        $employee = Employee::create(array_merge(['basic_salary' => $data['basic_salary'] ?? 0], $data));
        return response()->json($employee->load(['department','filiale','agence','position']), 201);
    }

    public function show(Employee $employee)
    {
        return response()->json($employee->load(['department','filiale','agence','position','contracts','payrolls']));
    }

    public function downloadDocument(Employee $employee)
    {
        $this->authorize('downloadDocument', $employee);

        if (!$employee->id_document_file || !Storage::disk('local')->exists($employee->id_document_file)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return Storage::disk('local')->download($employee->id_document_file);
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();
        if ($request->hasFile('id_document_file')) {
            if ($employee->id_document_file && Storage::disk('local')->exists($employee->id_document_file)) {
                Storage::disk('local')->delete($employee->id_document_file);
            }
            $file = $request->file('id_document_file');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_.]/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('employee_documents', $filename, ['disk' => 'local']);
            $data['id_document_file'] = $path;
        }
        $employee->update($data);
        return response()->json($employee->fresh()->load(['department','filiale','agence','position']));
    }

    public function destroy(Employee $employee)
    {
        if ($employee->id_document_file && Storage::disk('local')->exists($employee->id_document_file)) {
            Storage::disk('local')->delete($employee->id_document_file);
        }
        $employee->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeApiController extends Controller
{
    public function index()
    {
        return response()->json(Employee::with('department')->get(), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:employees,email',
            'phone'         => 'nullable|string|max:30',
            'hire_date'     => 'required|date',
            'position'      => 'required|string|max:255',
            'salary'        => 'required|numeric',
            'department_id' => 'required|exists:departments,id',
        ]);
        $employee = Employee::create($data);
        return response()->json($employee->load('department'), 201);
    }

    public function show(Employee $employee)
    {
        return response()->json($employee->load('department'), 200);
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:employees,email,'.$employee->id,
            'phone'         => 'nullable|string|max:30',
            'hire_date'     => 'required|date',
            'position'      => 'required|string|max:255',
            'salary'        => 'required|numeric',
            'department_id' => 'required|exists:departments,id',
        ]);
        $employee->update($data);
        return response()->json($employee->load('department'), 200);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(['message' => 'Employé supprimé'], 200);
    }
}




