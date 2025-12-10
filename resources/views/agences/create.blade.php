@extends('layouts.app')

@section('title', 'CrÃ©er une agence')

@section('content')
<div class="max-w-xl mx-auto bg-hh-card p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">CrÃ©er une agence</h2>

    @if($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('agences.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nom</label>
            <input type="text" name="name" value="{{ old('name') }}" class="input input-bordered w-full" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Filiale</label>
            <select name="filiale_id" class="input input-bordered w-full" required>
                <option value="">-- SÃ©lectionner --</option>
                @foreach($filiales as $filiale)
                    <option value="{{ $filiale->id }}" {{ old('filiale_id') == $filiale->id ? 'selected' : '' }}>
                        {{ $filiale->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Adresse</label>
            <input type="text" name="address" value="{{ old('address') }}" class="input input-bordered w-full">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">TÃ©lÃ©phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="input input-bordered w-full">
        </div>

        <button type="submit" class="btn btn-primary mt-2">Ajouter</button>
    </form>
</div>
@endsection







