@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="container mt-4">
    <h1>Mon Profil</h1>
    <div class="card p-4 shadow-sm">
        <p><strong>Nom :</strong> {{ $user->name }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>RÃ´le :</strong> {{ $user->role }}</p>
    </div>
</div>
@endsection







