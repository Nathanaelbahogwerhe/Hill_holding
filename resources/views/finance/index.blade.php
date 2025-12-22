{{-- filepath: resources/views/finance/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des finances</h1>
    <a href="{{ route('finances.create') }}" class="btn btn-primary mb-3">Ajouter une finance</a>
    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($finances as $finance)
                <tr>
                    <td>{{ $finance->title }}</td>
                    <td>{{ $finance->type }}</td>
                    <td>{{ $finance->amount }}</td>
                    <td>{{ $finance->finance_date }}</td>
                    <td>{{ $finance->description }}</td>
                    <td>
                        <a href="{{ route('finances.show', $finance) }}" class="btn btn-sm btn-info">Voir</a>
                        <a href="{{ route('finances.edit', $finance) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('finances.destroy', $finance) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $finances->links() }}
</div>
@endsection




