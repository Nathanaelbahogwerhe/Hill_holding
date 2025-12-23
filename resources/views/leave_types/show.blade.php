@extends('layouts.app')
@section('title', 'Détails Type de Congé')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]">🏝️ {{ $leaveType->name }}</h1>
        <div class="space-x-2">
            <a href="{{ route('leave_types.edit', $leaveType->id) }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-bold">✏️ Éditer</a>
            <a href="{{ route('leave_types.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl">← Retour</a>
        </div>
    </div>

    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-neutral-400 text-sm uppercase">Code</p>
                <p class="text-lg font-semibold text-white">{{ $leaveType->code ?? '—' }}</p>
            </div>
            <div>
                <p class="text-neutral-400 text-sm uppercase">Durée</p>
                <p class="text-lg font-semibold text-[#D4AF37]">{{ $leaveType->duration ?? '0' }} jours</p>
            </div>
        </div>

        @if($leaveType->description)
        <div class="bg-neutral-900 p-4 rounded-xl border border-neutral-800">
            <p class="text-neutral-400 text-sm uppercase mb-2">Description</p>
            <p class="text-white">{{ $leaveType->description }}</p>
        </div>
        @endif
    </div>

    @if($leaveType->leaves && $leaveType->leaves->count() > 0)
    <div class="bg-black rounded-xl shadow-xl p-8 border border-neutral-800">
        <h2 class="text-2xl font-bold text-[#D4AF37] mb-6">🏖️ Congés ({{ $leaveType->leaves->count() }})</h2>
        <div class="space-y-2">
            @foreach($leaveType->leaves->take(10) as $leave)
            <div class="bg-neutral-900 p-3 rounded-xl flex justify-between items-center border border-neutral-800">
                <p class="text-white font-semibold">{{ $leave->employee?->first_name }} {{ $leave->employee?->last_name }}</p>
                <span class="px-3 py-1 rounded-full text-xs font-semibold @if($leave->status === 'pending') bg-yellow-900 text-yellow-200 @elseif($leave->status === 'approved') bg-green-900 text-green-200 @else bg-red-900 text-red-200 @endif">{{ ucfirst($leave->status) }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="mt-8 pt-6 border-t border-neutral-700">
        <form action="{{ route('leave_types.destroy', $leaveType->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold transition">🗑️ Supprimer</button>
        </form>
    </div>
</div>
@endsection