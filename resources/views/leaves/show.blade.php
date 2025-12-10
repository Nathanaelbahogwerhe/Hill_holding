@extends('layouts.app')
@section('title', 'DÃ©tails congÃ©')

@section('content')
<div class="max-w-xl mx-auto bg-hh-card p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">DÃ©tails du congÃ©</h2>

    <div class="space-y-3">
        <p><strong>EmployÃ© :</strong> {{ $leave->employee?->name ?? '-' }}</p>
        <p><strong>Type de congÃ© :</strong> {{ $leave->type?->name ?? '-' }}</p>
        <p><strong>Date dÃ©but :</strong> {{ \Carbon\Carbon::parse($leave->start_date)->translatedFormat('d F Y') }}</p>
        <p><strong>Date fin :</strong> {{ \Carbon\Carbon::parse($leave->end_date)->translatedFormat('d F Y') }}</p>
        <p><strong>Jours :</strong> {{ $leave->days }}</p>
        <p><strong>Statut :</strong> {{ ucfirst($leave->status) }}</p>
    </div>

    <div class="mt-4 space-x-2">
        <a href="{{ route('leaves.edit', $leave) }}" class="btn btn-secondary">Ã‰diter</a>
        <a href="{{ route('leaves.index') }}" class="btn btn-primary">Retour Ã  la liste</a>
    </div>
</div>
@endsection







