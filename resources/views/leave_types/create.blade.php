@extends('layouts.app')
@section('title', 'Nouveau type de congÃ©')

@section('content')
<div class="max-w-xl mx-auto bg-hh-card p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">CrÃ©er un type de congÃ©</h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('leave_types.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nom</label>
            <input type="text" name="name" value="{{ old('name') }}" class="input input-bordered w-full" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nombre de jours</label>
            <input type="number" name="days" value="{{ old('days') }}" class="input input-bordered w-full" required>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Ajouter</button>
    </form>
</div>
@endsection







