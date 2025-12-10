<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // LISTE DES CLIENTS
    public function index()
    {
        $clients = Client::with('invoices')->paginate(10);

        $summary = [
            'total_clients' => Client::count(),
            'total_due'     => Client::sum('total_due'),
            'total_paid'    => Client::sum('total_paid'),
            'total_balance' => Client::sum('balance'),
        ];

        return view('clients.index', compact('clients', 'summary'));
    }

    // FORMULAIRE DE CREATION
    public function create()
    {
        return view('clients.create');
    }

    // ENREGISTRER
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:clients',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Client::create($data);

        return redirect()->route('clients.index')
            ->with('success', 'Client crÃ©Ã© avec succÃ¨s.');
    }

    // AFFICHER UN CLIENT
    public function show(Client $client)
    {
        return view('clients.show', [
            'client' => $client->load('invoices')
        ]);
    }

    // FORMULAIRE EDITION
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    // METTRE Ã€ JOUR
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'    => 'sometimes|string|max:255',
            'email'   => 'sometimes|email|unique:clients,email,' . $client->id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $client->update($data);

        return redirect()->route('clients.index')
            ->with('success', 'Client mis Ã  jour avec succÃ¨s.');
    }

    // SUPPRIMER
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client supprimÃ© avec succÃ¨s.');
    }
}



