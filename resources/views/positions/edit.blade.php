@extends('layouts.app')

@section('title', 'Modifier le poste')

@section('content')
<h1 class="text-xl font-semibold mb-4">Modifier le poste</h1>

@if($errors->any())
    <div class="alert alert-error mb-4">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('positions.update', $position) }}" method="POST" class="space-y-4 bg-hh-card p-4 rounded-lg shadow-sm">
    @csrf
    @method('PUT')
    <div>
        <label class="block mb-1 font-semibold">Nom du poste</label>
        <input type="text" name="name" value="{{ old('name', $position->name) }}" class="input input-bordered w-full" required>
    </div>

    <button type="submit" class="btn btn-primary">Mettre Ã  jour</button>
    <a href="{{ route('positions.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection







