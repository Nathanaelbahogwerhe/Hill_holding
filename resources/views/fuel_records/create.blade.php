@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Nouveau Ravitaillement</h1>
        <p class="text-neutral-400">Enregistrer un ravitaillement en carburant</p>
    </div>

    <form action="{{ route('fuel_records.store') }}" method="POST" class="bg-white rounded-xl shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Véhicule <span class="text-red-500">*</span></label>
                <select name="vehicle_id" class="form-select w-full @error('vehicle_id') border-red-500 @enderror" required id="vehicle_select" onchange="loadVehicleData()">
                    <option value="">Sélectionner</option>
                    @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}" 
                        data-km="{{ $vehicle->kilometrage_actuel }}"
                        data-conso="{{ $vehicle->consommation_moyenne }}"
                        {{ old('vehicle_id', request('vehicle_id')) == $vehicle->id ? 'selected' : '' }}>
                        {{ $vehicle->immatriculation }} - {{ $vehicle->marque }} {{ $vehicle->modele }}
                    </option>
                    @endforeach
                </select>
                @error('vehicle_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            @if(isset($mission))
            <div class="md:col-span-2 bg-gradient-to-br from-blue-900/50 to-blue-800/50 border border-blue-500/30 p-3 rounded">
                <p class="text-sm text-blue-800">Lié à la mission: <strong>{{ $mission->numero }}</strong></p>
                <input type="hidden" name="mission_id" value="{{ $mission->id }}">
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Date Ravitaillement <span class="text-red-500">*</span></label>
                <input type="date" name="date_ravitaillement" value="{{ old('date_ravitaillement', date('Y-m-d')) }}" class="form-input w-full @error('date_ravitaillement') border-red-500 @enderror" required>
                @error('date_ravitaillement')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Conducteur</label>
                <select name="conducteur_id" class="form-select w-full @error('conducteur_id') border-red-500 @enderror">
                    <option value="">Sélectionner</option>
                    @foreach($conducteurs as $conducteur)
                    <option value="{{ $conducteur->id }}" {{ old('conducteur_id') == $conducteur->id ? 'selected' : '' }}>{{ $conducteur->name }}</option>
                    @endforeach
                </select>
                @error('conducteur_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Quantité (Litres) <span class="text-red-500">*</span></label>
                <input type="number" name="quantite" value="{{ old('quantite') }}" class="form-input w-full @error('quantite') border-red-500 @enderror" required step="0.01" min="0" id="quantite" oninput="calculateConso()">
                @error('quantite')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Montant (FCFA) <span class="text-red-500">*</span></label>
                <input type="number" name="montant" value="{{ old('montant') }}" class="form-input w-full @error('montant') border-red-500 @enderror" required step="0.01" min="0">
                @error('montant')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Kilométrage <span class="text-red-500">*</span></label>
                <input type="number" name="kilometrage" value="{{ old('kilometrage') }}" class="form-input w-full @error('kilometrage') border-red-500 @enderror" required min="0" id="kilometrage" oninput="calculateConso()">
                <p class="text-xs text-gray-500 mt-1" id="km_hint"></p>
                @error('kilometrage')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Kilométrage Précédent</label>
                <input type="number" name="kilometrage_precedent" value="{{ old('kilometrage_precedent') }}" class="form-input w-full @error('kilometrage_precedent') border-red-500 @enderror" min="0" id="km_prec" oninput="calculateConso()">
                @error('kilometrage_precedent')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Consommation (L/100km)</label>
                <input type="number" name="consommation" value="{{ old('consommation') }}" class="form-input w-full bg-gray-50 @error('consommation') border-red-500 @enderror" step="0.01" min="0" id="consommation" readonly>
                <p class="text-xs text-gray-500 mt-1" id="conso_hint"></p>
                @error('consommation')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Station Service</label>
                <input type="text" name="station_service" value="{{ old('station_service') }}" class="form-input w-full @error('station_service') border-red-500 @enderror">
                @error('station_service')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#D4AF37] mb-1">Remarques</label>
                <textarea name="remarques" rows="2" class="form-input w-full @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                @error('remarques')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
            <a href="{{ route('fuel_records.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</div>

<script>
function loadVehicleData() {
    const select = document.getElementById('vehicle_select');
    const option = select.options[select.selectedIndex];
    const kmActuel = option.getAttribute('data-km');
    const consoMoy = option.getAttribute('data-conso');
    
    if (kmActuel) {
        document.getElementById('km_hint').textContent = `Kilométrage actuel: ${kmActuel} km`;
        document.getElementById('kilometrage').value = kmActuel;
    }
    
    if (consoMoy) {
        document.getElementById('conso_hint').textContent = `Consommation moyenne: ${consoMoy} L/100km`;
    }
}

function calculateConso() {
    const km = parseFloat(document.getElementById('kilometrage').value) || 0;
    const kmPrec = parseFloat(document.getElementById('km_prec').value) || 0;
    const quantite = parseFloat(document.getElementById('quantite').value) || 0;
    
    if (km > kmPrec && kmPrec > 0 && quantite > 0) {
        const distance = km - kmPrec;
        const conso = (quantite / distance) * 100;
        document.getElementById('consommation').value = conso.toFixed(2);
    }
}

window.addEventListener('load', loadVehicleData);
</script>
@endsection
