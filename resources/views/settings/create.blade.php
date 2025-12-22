@extends('layouts.app')

@section('title', 'Ajouter un paramètre')

@section('content')
<div class="p-6 bg-[#0D1117] min-h-screen text-white">
    <h1 class="text-3xl font-bold mb-6 text-blue-400">➕ Ajouter un paramètre</h1>

    <form action="{{ route('settings.store') }}" method="POST">
        @include('settings.form')
    </form>

    <a href="{{ route('settings.index') }}"
       class="inline-block mt-4 text-blue-400 hover:underline">⬅️ Retour</a>
</div>
@endsection
