@extends('layouts.app')

@section('title', 'DÃ©tails Service')

@section('content')
<div class="bg-white dark:bg-hh-gray-dark shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-semibold mb-4">DÃ©tails du service</h1>

    <div class="space-y-2">
        <p><strong>Nom :</strong> {{ $service->name }}</p>
        <p><strong>Description :</strong> {{ $service->description }}</p>
        <p><strong>Prix :</strong> {{ number_format($service->price, 2) }} {{ config('app.currency', 'USD') }}</p>
    </div>

    <div class="flex justify-end mt-4 space-x-2">
        <a href="{{ route('services.edit', $service) }}" class="bg-hh-green hover:bg-hh-green-dark text-white px-4 py-2 rounded">Modifier</a>
        <a href="{{ route('services.index') }}" class="bg-hh-gray hover:bg-hh-gray-dark text-white px-4 py-2 rounded">Retour</a>
    </div>
</div>
@endsection







