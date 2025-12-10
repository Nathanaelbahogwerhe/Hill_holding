@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ã‰diter SuperAdmin / HillHolding</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('superadmin.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $superadmin->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $superadmin->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo HillHolding</label>
            <input type="file" name="logo" class="form-control">
            @if($superadmin->logo)
                <img src="{{ asset('storage/'.$superadmin->logo) }}" alt="Logo HillHolding" class="mt-2" width="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Mettre Ã  jour</button>
    </form>
</div>
@endsection







