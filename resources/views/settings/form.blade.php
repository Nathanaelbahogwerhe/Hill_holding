@csrf
<div class="grid grid-cols-1 gap-4">

    <div>
        <label class="block text-gray-300">Clé</label>
        <input type="text" name="key"
               class="w-full p-2 mt-1 rounded bg-[#1A1A1A] border border-gray-700 text-white"
               value="{{ old('key', $setting->key ?? '') }}" required>
        @error('key') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-gray-300">Valeur</label>
        <textarea name="value"
                  class="w-full p-2 mt-1 rounded bg-[#1A1A1A] border border-gray-700 text-white"
                  rows="3" required>{{ old('value', $setting->value ?? '') }}</textarea>
        @error('value') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-white">
            💾 Enregistrer
        </button>
    </div>

</div>
