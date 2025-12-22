@extends('app')

@php
    $user = auth()->user();
    $niveau = 'agence';
    $agence = $user->agence;
    $filiale = $user->filiale;
    $users = $agence->users;
@endphp

@section('title', 'Dashboard Agence : ' . $agence->name)

@section('content')
<h2 class="mb-4">🏢 Agence : {{ $agence->name }}</h2>

<div class="row">
    <div class="col-md-6">
        <h4>Filiale</h4>
        <p>{{ $filiale->name }} ({{ $filiale->code }})</p>
    </div>

    <div class="col-md-6">
        <h4>Utilisateurs</h4>
        <ul>
            @foreach($users as $u)
                <li>{{ $u->name }} - {{ $u->email }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection




