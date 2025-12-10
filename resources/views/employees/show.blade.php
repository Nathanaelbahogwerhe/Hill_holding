@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-kc-card text-white shadow-lg rounded-2xl p-8 mt-10 border border-kc-border">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-kc-primary">
            ðŸ‘¤ DÃ©tails de lâ€™EmployÃ©
        </h1>
        <a href="{{ route('employees.index') }}" class="text-kc-light hover:text-white font-semibold">
            â¬… Retour Ã  la liste
        </a>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <p class="text-gray-400 text-sm uppercase">PrÃ©nom</p>
            <p class="text-xl font-semibold">{{ $employee->first_name }}</p>
        </div>

        <div>
            <p class="text-gray-400 text-sm uppercase">Nom</p>
            <p class="text-xl font-semibold">{{ $employee->last_name }}</p>
        </div>

        <div>
            <p class="text-gray-400 text-sm uppercase">Email</p>
            <p class="text-xl font-semibold">{{ $employee->email ?? $employee->generated_email }}</p>
        </div>

        <div>
            <p class="text-gray-400 text-sm uppercase">Salaire de base</p>
            <p class="text-xl font-semibold">{{ number_format($employee->basic_salary, 0, ',', ' ') }} FBu</p>
        </div>

        <div>
            <p class="text-gray-400 text-sm uppercase">DÃ©partement</p>
            <p class="text-xl font-semibold">{{ $employee->department->name ?? 'â€”' }}</p>
        </div>

        <div>
            <p class="text-gray-400 text-sm uppercase">Filiale</p>
            <p class="text-xl font-semibold">{{ $employee->filiale->name ?? 'â€”' }}</p>
        </div>

        <div>
            <p class="text-gray-400 text-sm uppercase">Agence</p>
            <p class="text-xl font-semibold">{{ $employee->agence->name ?? 'â€”' }}</p>
        </div>

        <div>
            <p class="text-gray-400 text-sm uppercase">Compte utilisateur liÃ©</p>
            <p class="text-xl font-semibold">{{ $employee->user->name ?? 'Non liÃ©' }}</p>
        </div>

        <div>
            <p class="text-gray-400 text-sm uppercase">Date dâ€™ajout</p>
            <p class="text-xl font-semibold">{{ $employee->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div>
            <p class="text-gray-400 text-sm uppercase">DerniÃ¨re mise Ã  jour</p>
            <p class="text-xl font-semibold">{{ $employee->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="mt-10 flex justify-end gap-4">
        <a href="{{ route('employees.edit', $employee->id) }}" 
           class="bg-kc-primary hover:bg-blue-600 text-black font-semibold px-6 py-2 rounded">
            âœï¸ Modifier
        </a>

        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
              onsubmit="return confirm('Confirmer la suppression de cet employÃ© ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded">
                ðŸ—‘ Supprimer
            </button>
        </form>
    </div>
</div>
@endsection







