@extends('layouts.app')
@section('title', 'Modifier Assurance')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-blue-400">✏️ Modifier Assurance</h1>
        <a href="{{ route('employee_insurances.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">← Retour</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-lg mb-6">
            <h3 class="font-bold mb-2">❌ Erreurs:</h3>
            <ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="bg-slate-900 rounded-lg shadow-xl p-8 border border-slate-700">
        <form action="{{ route('employee_insurances.update', $insurance->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Employé <span class="text-red-500">*</span></label>
                    <select name="employee_id" id="employee_id" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white focus:border-blue-500" required>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" data-filiale="{{ $emp->filiale_id }}" {{ $insurance->employee_id == $emp->id ? 'selected' : '' }}>
                                {{ $emp->first_name }} {{ $emp->last_name }}
                                @if($emp->filiale)
                                    ({{ $emp->filiale->name }})
                                @else
                                    (Maison Mère)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Filiale <span class="text-slate-400 text-sm">(auto-remplie)</span></label>
                    <input type="text" id="filiale_name" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-gray-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Plan d'Assurance <span class="text-red-500">*</span></label>
                    <select name="insurance_plan_id" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white focus:border-blue-500" required>
                        @foreach($insurance_plans as $plan)
                            <option value="{{ $plan->id }}" {{ $insurance->insurance_plan_id == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Département</label>
                    <input type="text" value="{{ $insurance->employee?->department?->name ?? '—' }}" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-gray-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Date de début <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="{{ $insurance->start_date?->format('Y-m-d') }}" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white focus:border-blue-500" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-blue-400">Date de fin</label>
                    <input type="date" name="end_date" value="{{ $insurance->end_date?->format('Y-m-d') }}" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white focus:border-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-blue-400">Statut <span class="text-red-500">*</span></label>
                    <select name="status" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white focus:border-blue-500" required>
                        <option value="active" {{ $insurance->status == 'active' ? 'selected' : '' }}>✅ Actif</option>
                        <option value="inactive" {{ $insurance->status == 'inactive' ? 'selected' : '' }}>❌ Inactif</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold transition">✅ Mettre à jour</button>
                <a href="{{ route('employee_insurances.index') }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-bold transition">❌ Annuler</a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('employee_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const filialeId = selectedOption.getAttribute('data-filiale');
    const filialeInput = document.getElementById('filiale_name');
    
    if (filialeId && filialeId !== 'null') {
        filialeInput.value = selectedOption.text.split('(')[1].replace(')', '');
    } else {
        filialeInput.value = 'Maison Mère';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const event = new Event('change');
    document.getElementById('employee_id').dispatchEvent(event);
});
</script>
@endsection