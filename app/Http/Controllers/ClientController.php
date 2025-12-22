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
        $filiales = \App\Models\Filiale::orderBy('name')->get();
        $agences = \App\Models\Agence::orderBy('name')->get();
        return view('clients.create', compact('filiales', 'agences'));
    }

    // ENREGISTRER
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:clients',
            'phone'          => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'address'        => 'nullable|string|max:255',
            'filiale_id'     => 'nullable|exists:filiales,id',
            'agence_id'      => 'nullable|exists:agences,id',
        ]);

        Client::create($data);

        return redirect()->route('clients.index')
            ->with('success', 'Client créé avec succès.');
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
        $filiales = \App\Models\Filiale::orderBy('name')->get();
        $agences = \App\Models\Agence::orderBy('name')->get();
        return view('clients.edit', compact('client', 'filiales', 'agences'));
    }

    // METTRE À JOUR
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'           => 'sometimes|string|max:255',
            'email'          => 'sometimes|email|unique:clients,email,' . $client->id,
            'phone'          => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'address'        => 'nullable|string|max:255',
            'filiale_id'     => 'nullable|exists:filiales,id',
            'agence_id'      => 'nullable|exists:agences,id',
        ]);

        $client->update($data);

        return redirect()->route('clients.index')
            ->with('success', 'Client mis à jour avec succès.');
    }

    // SUPPRIMER
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client supprimé avec succès.');
    }
}
