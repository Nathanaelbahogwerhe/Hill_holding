<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Contract::with(['employee', 'employee.filiale', 'employee.department']);

        if ($request->filled('search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($user->hasRole('Super Admin')) {
            $contracts = $query->paginate(10);
        } elseif ($user->filiale_id) {
            $contracts = $query->whereHas('employee', function ($q) use ($user) {
                $q->where('filiale_id', $user->filiale_id)
                  ->orWhereNull('filiale_id');
            })->paginate(10);
        } else {
            $contracts = $query->whereHas('employee', function ($q) {
                $q->whereNull('filiale_id');
            })->paginate(10);
        }

        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
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

        return view('contracts.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'contract_type' => 'required|in:CDI,CDD,Stage',
            'start_date'    => 'required|date',
            'end_date'      => 'nullable|date|after:start_date',
            'salary'        => 'required|numeric|min:0',
            'description'   => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachments')) {
            $data['attachments'] = $this->uploadFiles($request->file('attachments'), 'hr/contracts');
        }

        Contract::create($data);

        return redirect()->route('contracts.index')->with('success', 'Contrat créé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        $user = Auth::user();
        
        if ($user->filiale_id) {
            $employees = Employee::where('filiale_id', $user->filiale_id)
                                ->orWhereNull('filiale_id')
                                ->get();
        } else {
            $employees = Employee::whereNull('filiale_id')->get();
        }

        return view('contracts.edit', compact('contract', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'contract_type' => 'required|in:CDI,CDD,Stage',
            'start_date'    => 'required|date',
            'end_date'      => 'nullable|date|after:start_date',
            'salary'        => 'required|numeric|min:0',
            'description'   => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachments')) {
            $data['attachments'] = $this->mergeAttachments(
                $contract->attachments,
                $request->file('attachments'),
                'hr/contracts'
            );
        }

        $contract->update($data);

        return redirect()->route('contracts.show', $contract->id)
                         ->with('success', 'Contrat mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        if ($contract->attachments) {
            $this->deleteFiles(array_column($contract->attachments, 'path'));
        }
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Contrat supprimé.');
    }

    public function downloadAttachment(Contract $contract, $index)
    {
        if (!isset($contract->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($contract->attachments[$index]);
    }

    public function deleteAttachment(Contract $contract, $index)
    {
        if (!isset($contract->attachments[$index])) {
            abort(404);
        }
        $contract->attachments = $this->removeAttachment($contract->attachments, $index);
        $contract->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}




