@extends('layouts.app')
@section('title', 'DÃ©tails utilisateur')

@section('content')
<div class="max-w-xl mx-auto bg-hh-card p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">DÃ©tails de lâ€™utilisateur</h2>

    <div class="space-y-3">
        <p><strong>Nom :</strong> {{ $user->name }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>RÃ´le :</strong> {{ $user->roles->pluck('name')->join(', ') }}</p>
        <p><strong>Filiale :</strong> {{ $user->filiale?->name ?? '-' }}</p>
        <p><strong>CrÃ©Ã© le :</strong> {{ $user->created_at->translatedFormat('d F Y H:i') }}</p>
        <p><strong>DerniÃ¨re mise Ã  jour :</strong> {{ $user->updated_at->translatedFormat('d F Y H:i') }}</p>
    </div>

    <div class="mt-4 space-x-2">
        <a href="{{ route('users.edit', $user) }}" class="btn btn-secondary">Ã‰diter</a>
        <a href="{{ route('users.index') }}" class="btn btn-primary">Retour Ã  la liste</a>
    </div>
</div>
@endsection







