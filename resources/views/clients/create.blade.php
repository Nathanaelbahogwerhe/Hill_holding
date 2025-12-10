@extends('layouts.app')

@section('title', 'Ajouter un Client')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Ajouter un client</h1>

    <form action="{{ route('clients.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" name="nom" class="w-full border-gray-300 rounded-lg mt-1" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" class="w-full border-gray-300 rounded-lg mt-1" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">TÃ©lÃ©phone</label>
            <input type="text" name="telephone" class="w-full border-gray-300 rounded-lg mt-1">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Adresse</label>
            <textarea name="adresse" rows="3" class="w-full border-gray-300 rounded-lg mt-1"></textarea>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('clients.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mr-3">Annuler</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Enregistrer</button>
        </div>
    </form>
</div>
@endsection







