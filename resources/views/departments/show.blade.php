@extends('layouts.app')

@section('title', 'DÃ©tails du dÃ©partement')

@section('content')
<div class="max-w-5xl mx-auto bg-hh-card p-6 rounded shadow">

    {{-- Titre + retour --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">
            DÃ©partement : {{ $department->name }}
        </h2>
        <a href="{{ route('departments.index') }}" class="btn btn-secondary">
            â† Retour
        </a>
    </div>

    {{-- Informations gÃ©nÃ©rales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <h3 class="text-sm text-gray-500 uppercase">Nom du dÃ©partement</h3>
            <p class="text-lg font-medium text-gray-900">
                {{ $department->name }}
            </p>
        </div>

        <div>
            <h3 class="text-sm text-gray-500 uppercase">Filiale associÃ©e</h3>
            <p class="text-lg font-medium text-gray-900">
                {{ $department->filiale ? $department->filiale->name : 'â€” Aucune â€”' }}
            </p>
        </div>

        <div>
            <h3 class="text-sm text-gray-500 uppercase">CrÃ©Ã© le</h3>
            <p class="text-gray-800">
                {{ $department->created_at->format('d/m/Y H:i') }}
            </p>
        </div>

        <div>
            <h3 class="text-sm text-gray-500 uppercase">DerniÃ¨re modification</h3>
            <p class="text-gray-800">
                {{ $department->updated_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    {{-- Liste des employÃ©s du dÃ©partement --}}
    <div class="border-t border-gray-200 pt-6">
        <h3 class="text-xl font-semibold mb-4">EmployÃ©s du dÃ©partement</h3>

        @if($department->employees && $department->employees->count() > 0)
            <div class="overflow-x-auto">
                <table class="table w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">Nom</th>
                            <th class="px-4 py-2 text-left">Poste</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Date d'embauche</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($department->employees as $index => $employee)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 font-medium text-gray-900">{{ $employee->name }}</td>
                                <td class="px-4 py-2">{{ $employee->position ?? 'â€”' }}</td>
                                <td class="px-4 py-2">{{ $employee->email ?? 'â€”' }}</td>
                                <td class="px-4 py-2">
                                    {{ $employee->hired_at ? $employee->hired_at->format('d/m/Y') : 'â€”' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600 italic">Aucun employÃ© associÃ© Ã  ce dÃ©partement.</p>
        @endif
    </div>

    {{-- Actions --}}
    <div class="mt-8 flex gap-3">
        <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary">
            Modifier
        </a>

        <form action="{{ route('departments.destroy', $department) }}" method="POST" onsubmit="return confirm('Confirmer la suppression de ce dÃ©partement ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-error text-white">
                Supprimer
            </button>
        </form>
    </div>
</div>
@endsection







