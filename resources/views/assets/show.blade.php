@extends('layouts.app')

@section('title', 'Détails Asset')

@section('content')
<div class="px-6 py-6 text-white">

    <h2 class="text-3xl font-bold mb-6 text-blue-500">Détails de l'Asset</h2>

    <div class="bg-[#0F0F0F] p-6 rounded shadow border border-gray-800">

        <p class="mb-3"><strong class="text-blue-400">Nom :</strong> {{ $asset->name }}</p>
        <p class="mb-3"><strong class="text-blue-400">Catégorie :</strong> {{ $asset->category }}</p>
        <p class="mb-3"><strong class="text-blue-400">Valeur :</strong> {{ $asset->value }}</p>
        <p class="mb-3"><strong class="text-blue-400">Statut :</strong> {{ $asset->status }}</p>
        <p class="mb-3"><strong class="text-blue-400">Description :</strong> {{ $asset->description }}</p>
        <p class="mb-3"><strong class="text-blue-400">Acquisition :</strong> {{ $asset->acquisition_date }}</p>

    </div>

    <a href="{{ route('assets.index') }}"
       class="mt-4 inline-block px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded">
        Retour
    </a>

</div>
@endsection
