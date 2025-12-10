@extends('layouts.app')
@section('title', 'Ã‰diter assurance')

@section('content')
<div class="max-w-xl mx-auto bg-hh-card p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Ã‰diter l'assurance</h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('insurances.update', $insurance) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-semibold">EmployÃ©</label>
            <select name="employee_id" class="input input-bordered w-full" required>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ $insurance->employee_id==$employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Type dâ€™assurance</label>
            <input type="text" name="type" value="{{ old('type', $insurance->type) }}" class="input input-bordered w-full" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Compagnie</label>
            <input type="text" name="company" value="{{ old('company', $insurance->company) }}" class="input input-bordered w-full" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Date dÃ©but</label>
            <input type="date" name="start_date" value="{{ old('start_date', $insurance->start_date->format('Y-m-d')) }}" class="input input-bordered w-full" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Date fin</label>
            <input type="date" name="end_date" value="{{ old('end_date', $insurance->end_date->format('Y-m-d')) }}" class="input input-bordered w-full" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Prime</label>
            <input type="number" name="premium" value="{{ old('premium', $insurance->premium) }}" class="input input-bordered w-full" required>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Mettre Ã  jour</button>
    </form>
</div>
@endsection







