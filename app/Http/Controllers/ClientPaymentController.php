<?php

namespace App\Http\Controllers;

use App\Models\ClientPayment;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientPaymentController extends Controller
{
    // Liste des paiements
    public function index()
    {
        $payments = ClientPayment::with('client')->orderBy('payment_date', 'desc')->get();
        return view('client_payments.index', compact('payments'));
    }

    // Formulaire création paiement
    public function create()
    {
        $clients = Client::all();
        return view('client_payments.create', compact('clients'));
    }

    // Stocker paiement
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',
            'status' => 'required|string',
            'payment_date' => 'nullable|date',
            'details' => 'nullable|string',
        ]);

        ClientPayment::create($request->all());

        return redirect()->route('client_payments.index')->with('success', 'Paiement enregistré avec succès.');
    }

    // Formulaire édition paiement
    public function edit(ClientPayment $clientPayment)
    {
        $clients = Client::all();
        return view('client_payments.edit', compact('clientPayment', 'clients'));
    }

    // Mise à jour paiement
    public function update(Request $request, ClientPayment $clientPayment)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',
            'status' => 'required|string',
            'payment_date' => 'nullable|date',
            'details' => 'nullable|string',
        ]);

        $clientPayment->update($request->all());

        return redirect()->route('client_payments.index')->with('success', 'Paiement mis à jour avec succès.');
    }

    // Supprimer paiement
    public function destroy(ClientPayment $clientPayment)
    {
        $clientPayment->delete();
        return redirect()->route('client_payments.index')->with('success', 'Paiement supprimé avec succès.');
    }
}




