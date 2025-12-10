@extends('layouts.app')
@section('title', 'Paie')

@section('content')
<div class="max-w-7xl mx-auto bg-hh-card p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-semibold">Gestion des salaires</h1>
        <a href="{{ route('payrolls.create') }}" class="btn btn-primary flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            <span>Nouvelle fiche de paie</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full table-auto border border-gray-700 rounded shadow">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-hh-gold">Employé</th>
                    <th class="px-4 py-2 text-left text-hh-gold">Mois</th>
                    <th class="px-4 py-2 text-left text-hh-gold">Salaire de base</th>
                    <th class="px-4 py-2 text-left text-hh-gold">Primes</th>
                    <th class="px-4 py-2 text-left text-hh-gold">Indemnités</th>
                    <th class="px-4 py-2 text-left text-hh-gold">Indemnité km</th>
                    <th class="px-4 py-2 text-left text-hh-gold">Frais de comm.</th>
                    <th class="px-4 py-2 text-left text-hh-gold">Déductions</th>
                    <th class="px-4 py-2 text-left text-hh-gold">Salaire net</th>
                    <th class="px-4 py-2 text-left text-hh-gold">Statut</th>
                    <th class="px-4 py-2 text-hh-gold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payrolls as $payroll)
                <tr class="border-t border-gray-700">
                    <td class="px-4 py-2">{{ $payroll->employee->name }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($payroll->month)->translatedFormat('F Y') }}</td>
                    <td class="px-4 py-2">{{ number_format($payroll->base_salary, 0, ',', ' ') }} FBU</td>
                    <td class="px-4 py-2">{{ number_format($payroll->bonuses, 0, ',', ' ') }} FBU</td>
                    <td class="px-4 py-2">{{ number_format($payroll->allowances, 0, ',', ' ') }} FBU</td>
                    <td class="px-4 py-2">{{ number_format($payroll->km_allowance, 0, ',', ' ') }} FBU</td>
                    <td class="px-4 py-2">{{ number_format($payroll->comm_allowance, 0, ',', ' ') }} FBU</td>
                    <td class="px-4 py-2">{{ number_format($payroll->deductions, 0, ',', ' ') }} FBU</td>
                    <td class="px-4 py-2 font-semibold text-green-600">
                        {{ number_format(
                            $payroll->base_salary + $payroll->bonuses + $payroll->allowances + $payroll->km_allowance + $payroll->comm_allowance - $payroll->deductions, 
                            0, ',', ' '
                        ) }} FBU
                    </td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-white {{ $payroll->paid ? 'bg-green-600' : 'bg-yellow-600' }}">
                            {{ $payroll->paid ? 'Payé' : 'En attente' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('payrolls.show', $payroll) }}" class="text-blue-600 hover:underline">Voir</a>
                        <a href="{{ route('payrolls.edit', $payroll) }}" class="text-green-600 hover:underline">Éditer</a>
                        <form action="{{ route('payrolls.destroy', $payroll) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer cette fiche de paie ?')" class="text-red-600 hover:underline">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-4 py-2 text-center text-gray-400">Aucune fiche de paie trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $payrolls->links() }}
    </div>
</div>
@endsection







