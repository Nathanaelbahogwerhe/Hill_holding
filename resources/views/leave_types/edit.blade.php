@extends('layouts.app')
@section('title', 'Éditer Type de Congé')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-blue-400">✏️ Éditer {{ $leaveType->name }}</h1>
        <a href="{{ route('leave_types.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-xl"> Retour</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-xl mb-6">
            <h3 class="font-bold mb-2"> Erreurs:</h3>
            <ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="bg-slate-900 rounded-xl shadow-xl p-8 border border-slate-700">
        <form action="{{ route('leave_types.update', $leaveType->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ $leaveType->name }}" class="w-full px-4 py-2 rounded-xl bg-slate-800 border border-slate-600 text-white" required>
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Code</label>
                    <input type="text" name="code" value="{{ $leaveType->code }}" class="w-full px-4 py-2 rounded-xl bg-slate-800 border border-slate-600 text-white" placeholder="ex: VAC, MAL">
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Durée (jours)</label>
                    <input type="number" name="duration" value="{{ $leaveType->duration }}" class="w-full px-4 py-2 rounded-xl bg-slate-800 border border-slate-600 text-white" min="0">
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Description</label>
                    <textarea name="description" class="w-full px-4 py-2 rounded-xl bg-slate-800 border border-slate-600 text-white h-20">{{ $leaveType->description }}</textarea>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold text-white rounded-xl font-bold transition"> Mettre à jour</button>
                <a href="{{ route('leave_types.index') }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-bold transition"> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection