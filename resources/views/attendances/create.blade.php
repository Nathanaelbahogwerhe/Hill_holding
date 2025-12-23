@extends('layouts.app')
@section('title', 'Ajouter Présence')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">📍 Enregistrer une Présence</h1>
        <a href="{{ route('attendances.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl">← Retour</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-xl mb-6">
            <h3 class="font-bold mb-2">❌ Erreurs:</h3>
            <ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif>

    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800">
        <form action="{{ route('attendances.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Employé <span class="text-red-500">*</span></label>
                    <select name="employee_id" id="employee_id" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" data-filiale="{{ $emp->filiale_id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
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
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Filiale <span class="text-neutral-400 text-sm">(auto-remplie)</span></label>
                    <input type="text" id="filiale_name" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="attendance_date" value="{{ old('attendance_date') }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Heure d'arrivée</label>
                    <input type="time" name="check_in" value="{{ old('check_in') }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Heure de départ</label>
                    <input type="time" name="check_out" value="{{ old('check_out') }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Statut <span class="text-red-500">*</span></label>
                    <select name="status" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                        <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>✅ Présent</option>
                        <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>❌ Absent</option>
                        <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>⏳ En retard</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-[#D4AF37]">📎 Justificatif</label>
                    <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37] file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-[#D4AF37] file:text-black file:font-semibold hover:file:bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300">
                    <p class="text-neutral-400 text-sm mt-1">Formats acceptés: PDF, DOC, DOCX, JPG, PNG (Max: 10MB)</p>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-[#D4AF37] hover:bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 text-black rounded-xl font-bold transition">✅ Enregistrer</button>
                <a href="{{ route('attendances.index') }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-bold transition">❌ Annuler</a>
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

// Au chargement, remplir la filiale si un employé est pré-sélectionné
document.addEventListener('DOMContentLoaded', function() {
    const event = new Event('change');
    document.getElementById('employee_id').dispatchEvent(event);
});
</script>
@endsection
