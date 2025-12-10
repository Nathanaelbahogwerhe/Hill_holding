@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-black text-white rounded-2xl shadow-lg border border-yellow-600 p-6 mt-8">

    {{-- En-tÃªte --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-yellow-500">
            ðŸ‘¥ Liste des EmployÃ©s
        </h1>
        <a href="{{ route('employees.create') }}" 
           class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-5 py-2 rounded-lg shadow-md transition">
            âž• Nouvel EmployÃ©
        </a>
    </div>

    {{-- Barre de recherche --}}
    <form method="GET" action="{{ route('employees.index') }}" class="mb-6">
        <div class="flex items-center bg-gray-900 rounded-lg overflow-hidden border border-yellow-500">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="ðŸ” Rechercher un employÃ© (nom, email...)"
                   class="w-full bg-gray-900 text-white px-4 py-2 focus:outline-none">
            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-black px-4 py-2 font-semibold">
                Rechercher
            </button>
        </div>
    </form>

    {{-- Tableau des employÃ©s --}}
    <div class="overflow-x-auto rounded-xl border border-gray-800">
        <table class="min-w-full divide-y divide-gray-800">
            <thead class="bg-gray-900 text-yellow-500 uppercase text-sm">
                <tr>
                    <th class="px-4 py-3 text-left">Nom complet</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">DÃ©partement</th>
                    <th class="px-4 py-3 text-left">Filiale</th>
                    <th class="px-4 py-3 text-left">Agence</th>
                    <th class="px-4 py-3 text-right">Salaire</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                    <th class="px-4 py-3 text-center">Statut Paie</th>
                    <th class="px-4 py-3 text-center">Statut CongÃ©</th>
                    
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800 text-sm">
                @forelse ($employees as $employee)
                    <tr class="hover:bg-gray-800 transition">
                        <td class="px-4 py-3 font-semibold text-white">
                            {{ $employee->first_name }} {{ $employee->last_name }}
                        </td>
                        <td class="px-4 py-3 text-gray-300">
                            {{ $employee->email ?? $employee->generated_email }}
                        </td>
                        <td class="px-4 py-3">{{ $employee->department->name ?? 'â€”' }}</td>
                        <td class="px-4 py-3">{{ $employee->filiale->name ?? 'â€”' }}</td>
                        <td class="px-4 py-3">{{ $employee->agence->name ?? 'â€”' }}</td>
                        <td class="px-4 py-3 text-right">
                            {{ number_format($employee->basic_salary, 0, ',', ' ') }} FBu
                        </td>
                        <td class="px-4 py-3 text-center flex justify-center gap-2">
                            <a href="{{ route('employees.show', $employee->id) }}" 
                               class="bg-gray-800 hover:bg-yellow-600 text-yellow-400 hover:text-black px-3 py-1 rounded-md transition">
                                ðŸ‘ï¸
                            </a>
                            <a href="{{ route('employees.edit', $employee->id) }}" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-black px-3 py-1 rounded-md transition">
                                âœï¸
                            </a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" 
                                  onsubmit="return confirm('Confirmer la suppression de cet employÃ© ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md transition">
                                    ðŸ—‘
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-400">
                            Aucun employÃ© trouvÃ©.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $employees->links('pagination::tailwind') }}
    </div>
</div>
@endsection







