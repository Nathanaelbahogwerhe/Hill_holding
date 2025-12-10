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
        ]);

        Transaction::create($data);
        return redirect()->route('transactions.index')->with('success', 'Transaction enregistrÃ©e.');
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
        ]);

        $transaction->update($data);
        return redirect()->route('transactions.index')->with('success', 'Transaction mise Ã  jour.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction supprimÃ©e.');
    }
}







