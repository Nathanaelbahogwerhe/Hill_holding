@extends('layouts.app')
@section('title', 'DÃ©tails assurance')

@section('content')
<div class="max-w-xl mx-auto bg-hh-card p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">DÃ©tails de lâ€™assurance</h2>

    <div class="space-y-3">
        <p><strong>EmployÃ© :</strong> {{ $insurance->employee->name }}</p>
        <p><strong>Type :</strong> {{ $insurance->type }}</p>
        <p><strong>NumÃ©ro de police :</strong> {{ $insurance->policy_number }}</p>
        <p><strong>Date dÃ©but :</strong> {{ \Carbon\Carbon::parse($insurance->start_date)->translatedFormat('d F Y') }}</p>
        <p><strong>Date fin :</strong> {{ $insurance->end_date ? \Carbon\Carbon::parse($insurance->end_date)->translatedFormat('d F Y') : '-' }}</p>
    </div>

    <div class="mt-4 space-x-2">
        <a href="{{ route('employee_insurances.edit', $insurance) }}" class="btn btn-secondary">Ã‰diter</a>
        <a href="{{ route('employee_insurances.index') }}" class="btn btn-primary">Retour Ã  la liste</a>
    </div>
</div>
@endsection







