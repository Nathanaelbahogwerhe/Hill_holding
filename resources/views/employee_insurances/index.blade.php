@extends('layouts.app')
@section('title', 'Assurances')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">🛡️ Assurances Employés</h1>
        <a href="{{ route('employee_insurances.create') }}" class="px-6 py-3 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded-lg font-bold transition">
            ➕ Ajouter
        </a>
    </div>

    @if (session('success'))
        <div class="bg-[#D4AF37] bg-opacity-20 border border-[#D4AF37] text-[#D4AF37] p-4 rounded-lg mb-6">✅ {{ session('success') }}</div>
    @endif

    <div class="bg-black rounded-lg shadow-xl overflow-hidden border border-neutral-800">
        <table class="w-full">
            <thead class="bg-[#D4AF37]">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-bold text-black">Employé</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-black">Filiale</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-black">Plan d'Assurance</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-black">Date Début</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-black">Statut</th>
                    <th class="px-6 py-4 text-right text-sm font-bold text-black">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-800">
                @forelse($insurances as $insurance)
                    <tr class="hover:bg-neutral-900 transition">
                        <td class="px-6 py-4 text-sm font-semibold text-white">
                            {{ $insurance->employee?->first_name }} {{ $insurance->employee?->last_name }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $insurance->employee?->filiale?->name ?? '—' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="bg-indigo-900 text-indigo-200 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $insurance->insurancePlan?->name ?? '—' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-300">{{ optional($insurance->start_date)->format('d/m/Y') ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-900 text-green-200">
                                Actif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            <a href="{{ route('employee_insurances.show', $insurance->id) }}" class="inline-block px-3 py-1 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded font-semibold transition">👁️</a>
                            <a href="{{ route('employee_insurances.edit', $insurance->id) }}" class="inline-block px-3 py-1 bg-neutral-700 hover:bg-neutral-600 text-white rounded font-semibold transition">✏️</a>
                            <form action="{{ route('employee_insurances.destroy', $insurance->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded font-semibold transition">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-neutral-500">Aucune assurance trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
