@extends('layouts.app')

@section('title', 'Éditer Message')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-blue-400">
             Éditer Message
        </h1>
        <a href="{{ route('messages.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-xl">
             Retour
        </a>
    </div>

    <!-- Errors -->
    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-xl mb-6">
            <h3 class="font-bold mb-2"> Erreurs:</h3>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-slate-900 rounded-xl shadow-xl p-8 border border-slate-700">
        <form action="{{ route('messages.update', $message->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ $message->name }}" class="w-full px-4 py-2 rounded-xl bg-slate-800 border border-slate-600 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Description</label>
                    <input type="text" name="description" value="{{ $message->description ?? '' }}" class="w-full px-4 py-2 rounded-xl bg-slate-800 border border-slate-600 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold text-white rounded-xl font-bold transition">
                     Mettre à jour
                </button>
                <a href="{{ route('messages.index') }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-bold transition">
                     Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection