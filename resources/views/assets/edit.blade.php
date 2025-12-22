@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold text-white mb-4">Modifier l’actif</h1>

    <form action="{{ route('assets.update', $asset) }}" method="POST">
        @csrf
        @method('PUT')

        @include('assets.form')

        <div class="mt-4">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Mettre à jour</button>
        </div>
    </form>

</div>
@endsection
