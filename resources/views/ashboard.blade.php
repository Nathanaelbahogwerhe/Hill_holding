@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tableau de Bord</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h3>Employés</h3>
                <p>Total : <strong>{{ $employeesCount }}</strong></p>
                <a href="{{ route('employees.index') }}" class="btn btn-primary">Gérer les employés</a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h3>Départements</h3>
                <p>Total : <strong>{{ $departmentsCount }}</strong></p>
                <a href="{{ route('departments.index') }}" class="btn btn-primary">Gérer les départements</a>
            </div>
        </div>
    </div>
</div>
@endsection







