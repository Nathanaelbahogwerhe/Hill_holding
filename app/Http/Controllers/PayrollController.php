<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    use FileUploadTrait;

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Payroll::with(['employee', 'employee.department', 'employee.filiale']);

        if ($request->filled('search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }

        // Filtrer par filiale
        if ($user->hasRole('Super Admin')) {
            $payrolls = $query->paginate(10);
        } elseif ($user->filiale_id) {
            $payrolls = $query->whereHas('employee', function ($q) use ($user) {
                $q->where('filiale_id', $user->filiale_id)
                  ->orWhereNull('filiale_id');
            })->paginate(10);
        } else {
            $payrolls = $query->whereHas('employee', function ($q) {
                $q->whereNull('filiale_id');
            })->paginate(10);
        }

        return view('payrolls.index', compact('payrolls'));
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

        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'month'         => 'required|date',
            'base_salary'   => 'required|numeric|min:0',
            'bonuses'       => 'nullable|numeric|min:0',
            'allowances'    => 'nullable|numeric|min:0',
            'deductions'    => 'nullable|numeric|min:0',
            'net_salary'    => 'nullable|numeric|min:0',
            'payment_date'  => 'nullable|date',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachments')) {
            $data['attachments'] = $this->uploadFiles($request->file('attachments'), 'hr/payrolls');
        }

        Payroll::create($data);

        return redirect()->route('payrolls.index')->with('success', 'Fiche de paie créée.');
    }

    public function show(Payroll $payroll)
    {
        return view('payrolls.show', compact('payroll'));
    }

    public function edit(Payroll $payroll)
    {
        $user = Auth::user();
        
        if ($user->filiale_id) {
            $employees = Employee::where('filiale_id', $user->filiale_id)
                                ->orWhereNull('filiale_id')
                                ->get();
        } else {
            $employees = Employee::whereNull('filiale_id')->get();
        }

        return view('payrolls.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'month'         => 'required|date',
            'base_salary'   => 'required|numeric|min:0',
            'bonuses'       => 'nullable|numeric|min:0',
            'allowances'    => 'nullable|numeric|min:0',
            'deductions'    => 'nullable|numeric|min:0',
            'net_salary'    => 'nullable|numeric|min:0',
            'payment_date'  => 'nullable|date',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachments')) {
            $data['attachments'] = $this->mergeAttachments(
                $payroll->attachments ?? [],
                $request->file('attachments'),
                'hr/payrolls'
            );
        }

        $payroll->update($data);

        return redirect()->route('payrolls.show', $payroll->id)
                         ->with('success', 'Fiche de paie mise à jour.');
    }

    public function destroy(Payroll $payroll)
    {
        // Supprimer les fichiers attachés
        if (!empty($payroll->attachments)) {
            $this->deleteFiles(array_column($payroll->attachments, 'path'));
        }
        
        $payroll->delete();
        return redirect()->route('payrolls.index')->with('success', 'Fiche de paie supprimée.');
    }

    public function downloadAttachment(Payroll $payroll, $index)
    {
        if (!isset($payroll->attachments[$index])) {
            abort(404, 'Fichier non trouvé.');
        }

        return $this->downloadFile($payroll->attachments[$index]);
    }

    public function deleteAttachment(Payroll $payroll, $index)
    {
        if (!isset($payroll->attachments[$index])) {
            abort(404, 'Fichier non trouvé.');
        }

        $attachments = $payroll->attachments;
        $fileToDelete = $attachments[$index];
        
        // Supprimer le fichier du stockage
        $this->deleteFiles([$fileToDelete['path']]);
        
        // Retirer du tableau et réindexer
        array_splice($attachments, $index, 1);
        $payroll->attachments = array_values($attachments);
        $payroll->save();

        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}




