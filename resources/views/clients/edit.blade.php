@extends('layouts.app')

@section('title', 'Modifier le Client')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-[#D4AF37]"> Modifier {{ $client->name }}</h1>
        <a href="{{ route('clients.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg"> Retour</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-100 p-4 rounded-lg mb-6">
            <h3 class="font-bold mb-2"> Erreurs:</h3>
            <ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="bg-black rounded-lg shadow-xl p-8 border border-neutral-800">
        <form action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ $client->name }}" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ $client->email }}" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Téléphone</label>
                    <input type="text" name="phone" value="{{ $client->phone }}" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Personne de contact</label>
                    <input type="text" name="contact_person" value="{{ $client->contact_person }}" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Filiale</label>
                    <select name="filiale_id" id="filiale_id" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">
                        <option value="">-- Maison Mère --</option>
                        @foreach($filiales as $filiale)
                            <option value="{{ $filiale->id }}" {{ $client->filiale_id == $filiale->id ? 'selected' : '' }}>{{ $filiale->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Agence</label>
                    <select name="agence_id" id="agence_id" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">
                        <option value="">-- Sélectionner --</option>
                        @foreach($agences as $agence)
                            <option value="{{ $agence->id }}" data-filiale="{{ $agence->filiale_id }}" {{ $client->agence_id == $agence->id ? 'selected' : '' }}>
                                {{ $agence->name }} ({{ $agence->filiale?->name ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Adresse</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-2 rounded-lg bg-neutral-900 border border-neutral-700 text-white focus:border-[#D4AF37]">{{ $client->address }}</textarea>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="px-6 py-3 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded-lg font-bold transition"> Mettre à jour</button>
                <a href="{{ route('clients.index') }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg font-bold transition"> Annuler</a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('filiale_id').addEventListener('change', function() {
    const filialeId = this.value;
    const agencySelect = document.getElementById('agence_id');
    const options = agencySelect.querySelectorAll('option');
    options.forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
            return;
        }
        const agencyFiliale = option.getAttribute('data-filiale');
        if (!filialeId || agencyFiliale === filialeId) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const event = new Event('change');
    document.getElementById('filiale_id').dispatchEvent(event);
});
</script>
@endsection
