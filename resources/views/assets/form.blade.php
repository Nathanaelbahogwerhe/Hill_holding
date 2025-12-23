<div class="grid grid-cols-2 gap-4 text-white">

    <div>
        <label class="block text-neutral-300">Nom</label>
        <input type="text" name="name"
               class="w-full p-2 mt-1 rounded bg-[#1A1A1A] border border-gray-700 text-white"
               value="{{ old('name', $asset->name ?? '') }}" required>
    </div>

    <div>
        <label class="block text-neutral-300">Catégorie</label>
        <input type="text" name="category"
               class="w-full p-2 mt-1 rounded bg-[#1A1A1A] border border-gray-700 text-white"
               value="{{ old('category', $asset->category ?? '') }}" required>
    </div>

    <div>
        <label class="block text-neutral-300">Valeur</label>
        <input type="number" step="0.01" name="value"
               class="w-full p-2 mt-1 rounded bg-[#1A1A1A] border border-gray-700 text-white"
               value="{{ old('value', $asset->value ?? '') }}">
    </div>

    <div>
        <label class="block text-neutral-300">Statut</label>
        <select name="status"
                class="w-full p-2 mt-1 rounded bg-[#1A1A1A] border border-gray-700 text-white">
            @foreach(['active','inactive','maintenance','disposed'] as $s)
                <option value="{{ $s }}" @selected(old('status', $asset->status ?? '') == $s)>
                    {{ ucfirst($s) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-span-2">
        <label class="block text-neutral-300">Description</label>
        <textarea name="description"
                  class="w-full p-2 mt-1 rounded bg-[#1A1A1A] border border-gray-700 text-white"
        >{{ old('description', $asset->description ?? '') }}</textarea>
    </div>

    <div class="col-span-2">
        <label class="block text-neutral-300">Date d'acquisition</label>
        <input type="date" name="acquisition_date"
               class="w-full p-2 mt-1 rounded bg-[#1A1A1A] border border-gray-700 text-white"
               value="{{ old('acquisition_date', $asset->acquisition_date ?? '') }}">
    </div>

</div>
