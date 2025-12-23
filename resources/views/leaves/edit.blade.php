@extends('layouts.app')
@section('title', 'Modifier Congé')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">✏️ Modifier Congé</h1>
        <a href="{{ route('leaves.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl">← Retour</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-xl mb-6">
            <h3 class="font-bold mb-2">❌ Erreurs:</h3>
            <ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800">
        <form action="{{ route('leaves.update', $leave->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Employé</label>
                    <input type="text" value="{{ $leave->employee?->first_name }} {{ $leave->employee?->last_name }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Filiale</label>
                    <input type="text" value="{{ $leave->employee?->filiale?->name ?? 'Maison Mère' }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Type de Congé <span class="text-red-500">*</span></label>
                    <select name="leave_type_id" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($leave_types as $type)
                            <option value="{{ $type->id }}" {{ $leave->leave_type_id == $type->id ? 'selected' : '' }}>
                                {{ $type->name }} ({{ $type->duration ?? 0 }} jours)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Département</label>
                    <input type="text" value="{{ $leave->employee?->department?->name ?? '—' }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-neutral-400" disabled>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Date de début <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="{{ $leave->start_date?->format('Y-m-d') }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Date de fin <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" value="{{ $leave->end_date?->format('Y-m-d') }}" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Statut <span class="text-red-500">*</span></label>
                    <select name="status" class="w-full px-4 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                        <option value="pending" {{ $leave->status == 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                        <option value="approved" {{ $leave->status == 'approved' ? 'selected' : '' }}>✅ Approuvé</option>
                        <option value="rejected" {{ $leave->status == 'rejected' ? 'selected' : '' }}>❌ Rejeté</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-[#D4AF37]">📎 Justificatifs</label>
                    <x-file-upload :model="$leave" route="leaves" />
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-[#D4AF37] hover:bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 text-black rounded-xl font-bold transition">✅ Mettre à jour</button>
                <a href="{{ route('leaves.index') }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-bold transition">❌ Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
