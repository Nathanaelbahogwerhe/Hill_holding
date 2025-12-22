@extends('layouts.app')
@section('title', 'Paies')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">💰 Paies</h1>
        <a href="{{ route('payrolls.create') }}" class="px-6 py-3 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded-lg font-bold transition">
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
                    <th class="px-6 py-4 text-left text-sm font-bold text-black">Agence</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-black">Département</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-black">Salaire Net</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-black">Date</th>
                    <th class="px-6 py-4 text-right text-sm font-bold text-black">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-800">
                @forelse($payrolls as $payroll)
                    <tr class="hover:bg-neutral-900 transition">
                        <td class="px-6 py-4 text-sm font-semibold text-white">{{ $payroll->employee?->first_name }} {{ $payroll->employee?->last_name }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $payroll->employee?->filiale?->name ?? '—' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $payroll->employee?->agence?->name ?? '—' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="bg-[#D4AF37] bg-opacity-20 text-[#D4AF37] px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $payroll->employee?->department?->name ?? '—' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-green-400 font-semibold">{{ number_format($payroll->net_salary ?? 0, 0, ',', ' ') }} FBu</td>
                        <td class="px-6 py-4 text-sm text-neutral-300">{{ $payroll->payment_date?->format('d/m/Y') ?? '—' }}</td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            <a href="{{ route('payrolls.show', $payroll->id) }}" class="inline-block px-3 py-1 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded font-semibold transition" title="Voir">👁️</a>
                            <a href="{{ route('payrolls.edit', $payroll->id) }}" class="inline-block px-3 py-1 bg-neutral-700 hover:bg-neutral-600 text-white rounded font-semibold transition" title="Modifier">✏️</a>
                            <form action="{{ route('payrolls.destroy', $payroll->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded font-semibold transition" title="Supprimer">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-neutral-500">Aucune paie trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
