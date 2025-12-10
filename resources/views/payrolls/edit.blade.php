@extends('layouts.app')
@section('title', 'Modifier une fiche de paie')

@section('content')
<div class="max-w-xl mx-auto bg-hh-card p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Modifier la fiche de paie</h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('payrolls.update', $payroll) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-semibold">EmployÃ©</label>
            <select name="employee_id" class="input input-bordered w-full" required>
                <option value="">-- SÃ©lectionner --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ old('employee_id', $payroll->employee_id) == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Mois</label>
            <input type="month" name="month" value="{{ old('month', $payroll->month) }}" class="input input-bordered w-full" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Salaire de base</label>
            <input type="number" step="0.01" name="base_salary" value="{{ old('base_salary', $payroll->base_salary) }}" class="input input-bordered w-full" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Primes</label>
            <input type="number" step="0.01" name="bonuses" value="{{ old('bonuses', $payroll->bonuses) }}" class="input input-bordered w-full">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">IndemnitÃ©s</label>
            <input type="number" step="0.01" name="allowances" value="{{ old('allowances', $payroll->allowances) }}" class="input input-bordered w-full">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">IndemnitÃ© kilomÃ©trique</label>
            <input type="number" step="0.01" name="km_allowance" value="{{ old('km_allowance', $payroll->km_allowance) }}" class="input input-bordered w-full">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Frais de communication</label>
            <input type="number" step="0.01" name="comm_allowance" value="{{ old('comm_allowance', $payroll->comm_allowance) }}" class="input input-bordered w-full">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">DÃ©ductions</label>
            <input type="number" step="0.01" name="deductions" value="{{ old('deductions', $payroll->deductions) }}" class="input input-bordered w-full">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Statut</label>
            <select name="paid" class="input input-bordered w-full">
                <option value="0" {{ old('paid', $payroll->paid) == 0 ? 'selected' : '' }}>En attente</option>
                <option value="1" {{ old('paid', $payroll->paid) == 1 ? 'selected' : '' }}>PayÃ©</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Enregistrer</button>
    </form>
</div>
@endsection







