@extends('layouts.app')
@section('title', 'DÃ©tails prÃ©sence')

@section('content')
<div class="max-w-xl mx-auto bg-hh-card p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">DÃ©tails du pointage</h2>

    <div class="space-y-3">
        <p><strong>EmployÃ© :</strong> {{ $attendance->employee->name }}</p>
        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d F Y') }}</p>
        <p><strong>Heure arrivÃ©e :</strong> {{ $attendance->check_in }}</p>
        <p><strong>Heure dÃ©part :</strong> {{ $attendance->check_out ?? '-' }}</p>
    </div>

    <div class="mt-4 space-x-2">
        <a href="{{ route('attendances.edit', $attendance) }}" class="btn btn-secondary">Ã‰diter</a>
        <a href="{{ route('attendances.index') }}" class="btn btn-primary">Retour Ã  la liste</a>
    </div>
</div>
@endsection







