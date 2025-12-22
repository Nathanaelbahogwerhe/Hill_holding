@extends('layouts.app')

@section('title', 'Éditer Fournisseur')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-blue-400">
             Éditer Fournisseur
        </h1>
        <a href="{{ route('suppliers.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">
             Retour
        </a>
    </div>

    <!-- Errors -->
    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-lg mb-6">
            <h3 class="font-bold mb-2"> Erreurs:</h3>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-slate-900 rounded-lg shadow-xl p-8 border border-slate-700">
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ $supplier->name }}" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Description</label>
                    <input type="text" name="description" value="{{ $supplier->description ?? '' }}" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold transition">
                     Mettre à jour
                </button>
                <a href="{{ route('suppliers.index') }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-bold transition">
                     Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection