<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionApiController extends Controller
{
    public function index()
    {
        return response()->json(Transaction::with('asset')->get(), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'asset_id'         => 'required|exists:assets,id',
            'amount'           => 'required|numeric',
            'transaction_date' => 'required|date',
            'type'             => 'required|string|max:50', // e.g. Maintenance, Purchase, Sale
            'description'      => 'nullable|string',
        ]);
        $t = Transaction::create($data);
        return response()->json($t->load('asset'), 201);
    }

    public function show(Transaction $transaction)
    {
        return response()->json($transaction->load('asset'), 200);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'asset_id'         => 'required|exists:assets,id',
            'amount'           => 'required|numeric',
            'transaction_date' => 'required|date',
            'type'             => 'required|string|max:50',
            'description'      => 'nullable|string',
        ]);
        $transaction->update($data);
        return response()->json($transaction->load('asset'), 200);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return response()->json(['message' => 'Transaction supprimée'], 200);
    }
}




