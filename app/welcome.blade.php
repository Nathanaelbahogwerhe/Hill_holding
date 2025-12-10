@extends('layouts.app')

@section('content')
<div class="container text-center py-5">

    {{-- Logo filiale --}}
    @if(Auth::check() && Auth::user()->filiale)
        <div class="mb-4">
            <img src="{{ asset('storage/' . Auth::user()->filiale->logo) }}" 
                 alt="Logo de {{ Auth::user()->filiale->name }}" 
                 style="max-height: 120px;">
        </div>
        <h1 class="fw-bold text-primary">
            Bienvenue dans la filiale {{ Auth::user()->filiale->name }}
        </h1>
    @else
        {{-- Cas visiteur ou pas encore de filiale liÃ©e --}}
        <div class="mb-4">
            <img src="{{ asset('images/default_logo.png') }}" 
                 alt="Logo HillHolding" 
                 style="max-height: 120px;">
        </div>
        <h1 class="fw-bold text-secondary">Bienvenue sur HillHolding Company</h1>
    @endif

    <p class="mt-4">
        Vous Ãªtes connectÃ© en tant que <strong>{{ Auth::user()->name ?? 'Visiteur' }}</strong>.
    </p>

    @auth
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="btn btn-danger mt-3">
            DÃ©connexion
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary mt-3">
            Connexion
        </a>
    @endauth
</div>
@endsection







