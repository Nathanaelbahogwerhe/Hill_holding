{{-- resources/views/filiales/form.blade.php --}}
<div class="bg-slate-900 p-6 rounded-lg shadow-xl border border-slate-700 space-y-4">

    {{-- Nom --}}
    <div>
        <label class="block text-gray-300 font-semibold mb-1" for="name">Nom de la filiale *</label>
        <input type="text" name="name" id="name"
               value="{{ old('name', $filiale->name ?? '') }}"
               class="w-full p-3 rounded bg-[#1A1A1A] border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
               required>
        @error('name')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Code --}}
    <div>
        <label class="block text-gray-300 font-semibold mb-1" for="code">Code</label>
        <input type="text" name="code" id="code"
               value="{{ old('code', $filiale->code ?? '') }}"
               class="w-full p-3 rounded bg-[#1A1A1A] border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('code')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Localisation --}}
    <div>
        <label class="block text-gray-300 font-semibold mb-1" for="location">Localisation</label>
        <input type="text" name="location" id="location"
               value="{{ old('location', $filiale->location ?? '') }}"
               class="w-full p-3 rounded bg-[#1A1A1A] border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('location')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Logo --}}
    <div>
        <label class="block text-gray-300 font-semibold mb-1" for="logo">Logo</label>
        <input type="file" name="logo" id="logo" class="w-full text-gray-300">
        @if(isset($filiale) && $filiale->logo)
            <img src="{{ asset('storage/'.$filiale->logo) }}" alt="Logo" class="mt-3 h-24 rounded-lg border border-gray-700">
        @endif
        @error('logo')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Boutons --}}
    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 mt-4">
        <a href="{{ route('filiales.index') }}"
           class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-bold transition text-center">
            Annuler
        </a>
        <button type="submit"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold transition text-center">
            Enregistrer
        </button>
    </div>

</div>
