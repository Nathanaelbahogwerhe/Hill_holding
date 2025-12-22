@extends('layouts.app')

@section('title', 'Détails Utilisateur')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-blue-400">
            👨‍💼 Détails Utilisateur
        </h1>
        <div class="space-x-2">
            <a href="{{ route('users.edit', $user->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold">
                 Éditer
            </a>
            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">
                 Retour
            </a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="bg-slate-900 rounded-lg shadow-xl p-8 border border-slate-700 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-blue-400 text-sm uppercase font-semibold mb-1">ID</p>
                <p class="text-lg text-gray-100">{{ $user->id }}</p>
            </div>
            
            <div>
                <p class="text-blue-400 text-sm uppercase font-semibold mb-1">Nom</p>
                <p class="text-lg text-gray-100">{{ $user->name ?? $user->first_name ?? 'N/A' }}</p>
            </div>
            
            <div>
                <p class="text-blue-400 text-sm uppercase font-semibold mb-1">Créé le</p>
                <p class="text-lg text-gray-100">{{ $user->created_at?->format('d/m/Y H:i') ?? 'N/A' }}</p>
            </div>
            
            <div>
                <p class="text-blue-400 text-sm uppercase font-semibold mb-1">Mis à jour le</p>
                <p class="text-lg text-gray-100">{{ $user->updated_at?->format('d/m/Y H:i') ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Delete Button -->
    <div class="bg-slate-900 rounded-lg shadow-xl p-6 border border-slate-700">
        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression définitive?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold transition">
                 Supprimer
            </button>
        </form>
    </div>
</div>
@endsection