@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Connexion HillHolding</h2>
    <form method="POST" action="{{ route('HillHolding.login') }}">
        @csrf
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div>
            <label>Mot de passe</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Se connecter</button>
    </form>
</div>
@endsection







