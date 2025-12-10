@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tableau de Bord</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h3>EmployÃ©s</h3>
                <p>Total : <strong>{{ $employeesCount }}</strong></p>
                <a href="{{ route('employees.index') }}" class="btn btn-primary">GÃ©rer les employÃ©s</a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h3>DÃ©partements</h3>
                <p>Total : <strong>{{ $departmentsCount }}</strong></p>
                <a href="{{ route('departments.index') }}" class="btn btn-primary">GÃ©rer les dÃ©partements</a>
            </div>
        </div>
    </div>
</div>
@endsection







