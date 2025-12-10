@extends('layouts.app')
@section('title', 'Assurances des employÃ©s')

@section('content')
<div class="max-w-7xl mx-auto bg-hh-card p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-semibold">Gestion des assurances</h1>
        <a href="{{ route('employee_insurances.create') }}" class="btn btn-primary flex items-center space-x-2">
            <span>Nouvelle assurance</span>
        </a>
    </div>

    <table class="w-full table-auto border border-gray-700 rounded shadow">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-4 py-2 text-left text-hh-gold">EmployÃ©</th>
                <th class="px-4 py-2 text-left text-hh-gold">Type dâ€™assurance</th>
                <th class="px-4 py-2 text-left text-hh-gold">NumÃ©ro de police</th>
                <th class="px-4 py-2 text-left text-hh-gold">Date dÃ©but</th>
                <th class="px-4 py-2 text-left text-hh-gold">Date fin</th>
                <th class="px-4 py-2 text-left text-hh-gold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($insurances as $insurance)
            <tr class="border-t border-gray-700">
                <td class="px-4 py-2">{{ $insurance->employee->name }}</td>
                <td class="px-4 py-2">{{ $insurance->type }}</td>
                <td class="px-4 py-2">{{ $insurance->policy_number }}</td>
                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($insurance->start_date)->translatedFormat('d F Y') }}</td>
                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($insurance->end_date)->translatedFormat('d F Y') }}</td>
                <td class="px-4 py-2 space-x-2">
                    <a href="{{ route('employee_insurances.show', $insurance) }}" class="text-blue-600 hover:underline">Voir</a>
                    <a href="{{ route('employee_insurances.edit', $insurance) }}" class="text-green-600 hover:underline">Ã‰diter</a>
                    <form action="{{ route('employee_insurances.destroy', $insurance) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer cette assurance ?')" class="text-red-600 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-2 text-center text-gray-400">Aucune assurance trouvÃ©e.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $insurances->links() }}
    </div>
</div>
@endsection







