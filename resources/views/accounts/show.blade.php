@extends('layouts.app')

@section('title', 'Détails du compte')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold text-hh-blue mb-4">{{ $account->name }}</h1>

        <ul class="space-y-2 text-[#D4AF37]">
            <li><strong>Type :</strong> {{ ucfirst($account->type) }}</li>
            <li><strong>Solde :</strong> {{ number_format($account->balance, 0, ',', ' ') }} FBU</li>
            <li><strong>Date de création :</strong> {{ $account->created_at->format('d/m/Y') }}</li>
        </ul>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('accounts.index') }}" class="text-hh-blue hover:underline">
                 Retour
            </a>
            <a href="{{ route('accounts.edit', $account) }}" class="bg-hh-green text-white px-4 py-2 rounded-xl hover:bg-green-600">
                 Modifier
            </a>
        </div>
    </div>
</div>
@endsection




