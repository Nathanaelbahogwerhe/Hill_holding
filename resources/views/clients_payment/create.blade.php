@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
    <h2 class="text-2xl font-bold mb-4">Ajouter un Paiement Client</h2>

    <form action="{{ route('client_payments.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        <div>
            <label class="block font-semibold">Client</label>
            <select name="client_id" class="w-full border rounded px-3 py-2">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Montant</label>
            <input type="number" name="amount" step="0.01" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-semibold">Montant restant</label>
            <input type="number" name="due_amount" step="0.01" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-semibold">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2" required>
                <option value="pending">En attente</option>
                <option value="partial">Partiel</option>
                <option value="paid">PayÃ©</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">Date de paiement</label>
            <input type="date" name="payment_date" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-semibold">DÃ©tails</label>
            <textarea name="details" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Enregistrer</button>
        </div>
    </form>
</div>
@endsection







