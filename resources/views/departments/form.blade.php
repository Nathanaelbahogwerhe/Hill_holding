@extends('layouts.app')

@section('content')
<div class="p-6 max-w-lg mx-auto bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-4">{{ isset($department) ? 'Modifier le dÃ©partement' : 'Ajouter un dÃ©partement' }}</h1>

    <form action="{{ isset($department) ? route('departments.update', $department) : route('departments.store') }}" method="POST">
        @csrf
        @if(isset($department)) @method('PUT') @endif

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nom</label>
            <input type="text" name="name" value="{{ old('name', $department->name ?? '') }}" class="w-full border px-3 py-2 rounded" required>
            @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Filiale</label>
            <select name="filiale_id" class="w-full border px-3 py-2 rounded" required>
                <option value="">SÃ©lectionner</option>
                @foreach($filiales as $filiale)
                    <option value="{{ $filiale->id }}" {{ (old('filiale_id', $department->filiale_id ?? '') == $filiale->id) ? 'selected' : '' }}>
                        {{ $filiale->name }}
                    </option>
                @endforeach
            </select>
            @error('filiale_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ isset($department) ? 'Mettre Ã  jour' : 'Ajouter' }}
        </button>
    </form>
</div>
@endsection







