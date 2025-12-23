@extends('layouts.app')
@section('title', 'Modifier Fiche de Paie')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">✏️ Modifier Fiche de Paie</h1>
        <a href="{{ route('payrolls.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl">← Retour</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-xl mb-6">
            <h3 class="font-bold mb-2">❌ Erreurs:</h3>
            <ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800">
        <form action="{{ route('payrolls.update', $payroll->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Employé</label>
                    <input type="text" value="{{ $payroll->employee?->first_name }} {{ $payroll->employee?->last_name }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Filiale</label>
                    <input type="text" value="{{ $payroll->employee?->filiale?->name ?? 'Maison Mère' }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Mois <span class="text-red-500">*</span></label>
                    <input type="month" name="month" value="{{ \Carbon\Carbon::parse($payroll->month)->format('Y-m') }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Salaire de base</label>
                    <input type="number" name="base_salary" id="base_salary" value="{{ $payroll->base_salary }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" min="0" step="0.01">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Primes</label>
                    <input type="number" name="bonuses" value="{{ $payroll->bonuses }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" min="0" step="0.01">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Allocations</label>
                    <input type="number" name="allowances" value="{{ $payroll->allowances }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" min="0" step="0.01">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Déductions</label>
                    <input type="number" name="deductions" value="{{ $payroll->deductions }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" min="0" step="0.01">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Salaire net <span class="text-neutral-400 text-sm">(auto-calculé)</span></label>
                    <input type="number" name="net_salary" id="net_salary" value="{{ $payroll->net_salary }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Date de paiement</label>
                    <input type="date" name="payment_date" value="{{ $payroll->payment_date?->format('Y-m-d') }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-[#D4AF37]">📎 Pièces jointes</label>
                    <x-file-upload :model="$payroll" route="payrolls" />
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-[#D4AF37] hover:bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 text-black rounded-xl font-bold transition">✅ Mettre à jour</button>
                <a href="{{ route('payrolls.index') }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-bold transition">❌ Annuler</a>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-calcul du salaire net
function calculateNet() {
    const base = parseFloat(document.getElementById('base_salary').value) || 0;
    const bonuses = parseFloat(document.querySelector('[name="bonuses"]').value) || 0;
    const allowances = parseFloat(document.querySelector('[name="allowances"]').value) || 0;
    const deductions = parseFloat(document.querySelector('[name="deductions"]').value) || 0;
    const net = base + bonuses + allowances - deductions;
    document.getElementById('net_salary').value = net.toFixed(2);
}

['base_salary', 'bonuses', 'allowances', 'deductions'].forEach(field => {
    const input = field === 'base_salary' ? document.getElementById(field) : document.querySelector(`[name="${field}"]`);
    input.addEventListener('input', calculateNet);
});

calculateNet();
</script>
@endsection
