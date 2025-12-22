@extends('layouts.app')
@section('title', 'Détails assurance')

@section('content')
<div class="max-w-xl mx-auto bg-hh-card p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Détails de l'assurance</h2>

    <div class="space-y-3">
        <p><strong>Employé :</strong> {{ $insurance->employee->name }}</p>
        <p><strong>Type :</strong> {{ $insurance->type }}</p>
        <p><strong>Compagnie :</strong> {{ $insurance->company }}</p>
        <p><strong>Date début :</strong> {{ \Carbon\Carbon::parse($insurance->start_date)->translatedFormat('d F Y') }}</p>
        <p><strong>Date fin :</strong> {{ \Carbon\Carbon::parse($insurance->end_date)->translatedFormat('d F Y') }}</p>
        <p><strong>Prime :</strong> {{ number_format($insurance->premium,0,',',' ') }} FBU</p>
    </div>

    <div class="mt-4 space-x-2">
        <a href="{{ route('insurances.edit', $insurance) }}" class="btn btn-secondary">Éditer</a>
        <a href="{{ route('insurances.index') }}" class="btn btn-primary">Retour à la liste</a>
    </div>
</div>
@endsection




