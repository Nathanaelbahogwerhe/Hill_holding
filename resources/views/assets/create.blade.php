@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold text-white mb-4">Créer un actif</h1>

    <form action="{{ route('assets.store') }}" method="POST">
        @csrf

        @include('assets.form')

        <div class="mt-4">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
        </div>
    </form>

</div>
@endsection
