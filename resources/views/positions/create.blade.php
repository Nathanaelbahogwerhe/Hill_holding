@extends('layouts.app')
@section('title', 'Ajouter Poste')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">💼 Ajouter un Poste</h1>
        <a href="{{ route('positions.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl">← Retour</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-xl mb-6">
            <h3 class="font-bold mb-2">❌ Erreurs:</h3>
            <ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800">
        <form action="{{ route('positions.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Filiale</label>
                    <select name="filiale_id" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">
                        <option value="">-- Maison Mère --</option>
                        @foreach($filiales as $filiale)
                            <option value="{{ $filiale->id }}" {{ old('filiale_id') == $filiale->id ? 'selected' : '' }}>{{ $filiale->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Description</label>
                    <textarea name="description" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37] h-24">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-[#D4AF37] hover:bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 text-black rounded-xl font-bold transition">✅ Créer</button>
                <a href="{{ route('positions.index') }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-bold transition">❌ Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
