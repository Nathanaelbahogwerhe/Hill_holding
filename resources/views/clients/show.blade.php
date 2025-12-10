@extends('layouts.app')

@section('title', 'DÃ©tails du Client')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">DÃ©tails du Client</h1>
        <a href="{{ route('clients.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Retour</a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 space-y-4">
        <div>
            <h2 class="font-semibold text-gray-700">Nom :</h2>
            <p class="text-gray-800">{{ $client->nom }}</p>
        </div>
        <div>
            <h2 class="font-semibold text-gray-700">Email :</h2>
            <p class="text-gray-800">{{ $client->email }}</p>
        </div>
        <div>
            <h2 class="font-semibold text-gray-700">TÃ©lÃ©phone :</h2>
            <p class="text-gray-800">{{ $client->telephone }}</p>
        </div>
        <div>
            <h2 class="font-semibold text-gray-700">Adresse :</h2>
            <p class="text-gray-800">{{ $client->adresse }}</p>
        </div>
    </div>
</div>
@endsection







