@extends('layouts.app')
@section('title', 'DÃ©tails type de congÃ©')

@section('content')
<div class="max-w-xl mx-auto bg-hh-card p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">DÃ©tails du type de congÃ©</h2>

    <div class="space-y-3">
        <p><strong>Nom :</strong> {{ $leaveType->name }}</p>
        <p><strong>Nombre de jours :</strong> {{ $leaveType->days }}</p>
    </div>

    <div class="mt-4 space-x-2">
        <a href="{{ route('leave_types.edit', $leaveType) }}" class="btn btn-secondary">Ã‰diter</a>
        <a href="{{ route('leave_types.index') }}" class="btn btn-primary">Retour Ã  la liste</a>
    </div>
</div>
@endsection







