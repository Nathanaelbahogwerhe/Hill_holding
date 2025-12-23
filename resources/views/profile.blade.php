@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">👤 Mon Profil</h2>

    {{-- Messages de succès/erreurs --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </<|fim_middle|><|fim_middle|><|fim_middle|>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl- <1>5">
    @endif

    {{-- Formulaire infos personnelles --}}
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-[#D4AF37]">Nom</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-[#D4AF37]">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full border rounded p-2">
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            💾 Mettre Àjour
        </button>
    </form>

    <hr class="my-6">

    {{-- Formulaire mot de passe --}}
    <h3 class="text-xl font-semibold mb-4">🔐 Changer le mot de passe</h3>
    <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-[#D4AF37]">Mot de passe actuel</label>
            <input type="password" name="current_password" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-[#D4AF37]">Nouveau mot de passe</label>
            <input type="password" name="password" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-[#D4AF37]">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
        </div>

        <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
             Modifier mot de passe
        </button>
    </form>
</div>
@endsection







