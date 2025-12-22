<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->get();
        return view('finance.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $users = User::all();
        return view('finance.transactions.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reference' => 'required|string|max:50',
            'type' => 'required|in:expense,revenue',
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('transactions/attachments', 'public');
        }

        Transaction::create($data);
        return redirect()->route('transactions.index')->with('success', 'Transaction enregistrée.');
    }

    public function show(Transaction $transaction)
    {
        return view('finance.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $users = User::all();
        return view('finance.transactions.edit', compact('transaction', 'users'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'reference' => 'required|string|max:50',
            'type' => 'required|in:expense,revenue',
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            if ($transaction->attachment && \Storage::disk('public')->exists($transaction->attachment)) {
                \Storage::disk('public')->delete($transaction->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('transactions/attachments', 'public');
        }

        $transaction->update($data);
        return redirect()->route('transactions.index')->with('success', 'Transaction mise à jour.');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->attachment && \Storage::disk('public')->exists($transaction->attachment)) {
            \Storage::disk('public')->delete($transaction->attachment);
        }
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction supprimée.');
    }
}




