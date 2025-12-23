{{-- resources/views/filiales/form.blade.php --}}
<div class="bg-slate-900 p-6 rounded-xl shadow-xl border border-slate-700 space-y-4">

    {{-- Nom --}}
    <div>
        <label class="block text-neutral-300 font-semibold mb-1" for="name">Nom de la filiale *</label>
        <input type="text" name="name" id="name"
               value="{{ old('name', $filiale->name ?? '') }}"
               class="w-full p-3 rounded bg-[#1A1A1A] border border-gray-700 text-white focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20"
               required>
        @error('name')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Code --}}
    <div>
        <label class="block text-neutral-300 font-semibold mb-1" for="code">Code</label>
        <input type="text" name="code" id="code"
               value="{{ old('code', $filiale->code ?? '') }}"
               class="w-full p-3 rounded bg-[#1A1A1A] border border-gray-700 text-white focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
        @error('code')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Localisation --}}
    <div>
        <label class="block text-neutral-300 font-semibold mb-1" for="location">Localisation</label>
        <input type="text" name="location" id="location"
               value="{{ old('location', $filiale->location ?? '') }}"
               class="w-full p-3 rounded bg-[#1A1A1A] border border-gray-700 text-white focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20">
        @error('location')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Logo --}}
    <div>
        <label class="block text-neutral-300 font-semibold mb-1" for="logo">Logo</label>
        <input type="file" name="logo" id="logo" class="w-full text-neutral-300">
        @if(isset($filiale) && $filiale->logo)
            <img src="{{ asset('storage/'.$filiale->logo) }}" alt="Logo" class="mt-3 h-24 rounded-xl border border-gray-700">
        @endif
        @error('logo')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Boutons --}}
    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 mt-4">
        <a href="{{ route('filiales.index') }}"
           class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-bold transition text-center">
            Annuler
        </a>
        <button type="submit"
                class="px-6 py-3 bg-gradient-to-r from-[#D4AF37] to-yellow-500 hover:from-yellow-500 hover:to-[#D4AF37] text-black rounded-xl font-bold text-white rounded-xl font-bold transition text-center">
            Enregistrer
        </button>
    </div>

</div>
