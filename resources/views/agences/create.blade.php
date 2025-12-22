@extends('layouts.app')
@section('title', 'Ajouter Agence')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">🏢 Ajouter une Agence</h1>
        <a href="{{ route('agences.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg">← Retour</a>
    </div>

    @if($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-lg mb-6">
            <h3 class="font-bold mb-2">❌ Erreurs:</h3>
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-black rounded-lg shadow-xl p-8 border border-neutral-800">
        <form action="{{ route('agences.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Code</label>
                    <input type="text" name="code" value="{{ old('code') }}" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Localisation</label>
                    <input type="text" name="location" value="{{ old('location') }}" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Filiale <span class="text-red-500">*</span></label>
                    <select name="filiale_id" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($filiales as $filiale)
                            <option value="{{ $filiale->id }}" {{ old('filiale_id') == $filiale->id ? 'selected' : '' }}>
                                {{ $filiale->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded-lg font-bold transition">✅ Créer</button>
                <a href="{{ route('agences.index') }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg font-bold transition">❌ Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
