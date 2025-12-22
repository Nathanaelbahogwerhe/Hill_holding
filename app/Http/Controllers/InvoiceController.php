<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return Invoice::with('client')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount'    => 'required|numeric',
            'status'    => 'required|string|in:pending,paid,cancelled',
            'due_date'  => 'required|date',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('invoices/attachments', 'public');
        }

        return Invoice::create($data);
    }

    public function show(Invoice $invoice)
    {
        return $invoice->load('client');
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'client_id' => 'sometimes|exists:clients,id',
            'amount'    => 'sometimes|numeric',
            'status'    => 'sometimes|string|in:pending,paid,cancelled',
            'due_date'  => 'sometimes|date',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            if ($invoice->attachment && \Storage::disk('public')->exists($invoice->attachment)) {
                \Storage::disk('public')->delete($invoice->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('invoices/attachments', 'public');
        }

        $invoice->update($data);

        return $invoice;
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->attachment && \Storage::disk('public')->exists($invoice->attachment)) {
            \Storage::disk('public')->delete($invoice->attachment);
        }
        $invoice->delete();
        return response()->json(['message' => 'Facture supprimée avec succès']);
    }
}




