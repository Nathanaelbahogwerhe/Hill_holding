@php
    // valeurs de champ (create = old, edit = $employee->field)
    $name = old('name', data_get($employee, 'name'));
    $email = old('email', data_get($employee, 'email'));
    $phone = old('phone', data_get($employee, 'phone'));
    $filialeId = old('filiale_id', data_get($employee, 'filiale_id'));
    $agencyId = old('agency_id', data_get($employee, 'agency_id'));
    $departmentId = old('department_id', data_get($employee, 'department_id'));
    $positionId = old('position_id', data_get($employee, 'position_id'));
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-[#D4AF37]">Nom</label>
        <input type="text" name="name" value="{{ $name }}" class="mt-1 block w-full border rounded p-2" required>
        @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-[#D4AF37]">Email</label>
        <input type="email" name="email" value="{{ $email }}" class="mt-1 block w-full border rounded p-2" required>
        @error('email') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-[#D4AF37]">Téléphone</label>
        <input type="text" name="phone" value="{{ $phone }}" class="mt-1 block w-full border rounded p-2">
        @error('phone') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-[#D4AF37]">Poste</label>
        <select name="position_id" class="mt-1 block w-full border rounded p-2">
            <option value="">— Sélectionner —</option>
            @foreach($positions ?? [] as $position)
                <option value="{{ $position->id }}" @selected($positionId == $position->id)>{{ $position->name }}</option>
            @endforeach
        </select>
        @error('position_id') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-[#D4AF37]">Département</label>
        <select name="department_id" class="mt-1 block w-full border rounded p-2">
            <option value="">— Sélectionner —</option>
            @foreach($departments ?? [] as $dept)
                <option value="{{ $dept->id }}" @selected($departmentId == $dept->id)>{{ $dept->name }}</option>
            @endforeach
        </select>
        @error('department_id') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-[#D4AF37]">Filiale</label>
        <select name="filiale_id" class="mt-1 block w-full border rounded p-2">
            <option value="">— Sélectionner —</option>
            @foreach($filiales ?? [] as $f)
                <option value="{{ $f->id }}" @selected($filialeId == $f->id)>{{ $f->name }}</option>
            @endforeach
        </select>
        @error('filiale_id') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-[#D4AF37]">Agence</label>
        <select name="agency_id" class="mt-1 block w-full border rounded p-2">
            <option value="">— Sélectionner —</option>
            @foreach($agences ?? [] as $a)
                <option value="{{ $a->id }}" @selected($agencyId == $a->id)>{{ $a->name }}</option>
            @endforeach
        </select>
        @error('agency_id') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-[#D4AF37]">Adresse</label>
        <input type="text" name="address" value="{{ old('address', data_get($employee, 'address')) }}" class="mt-1 block w-full border rounded p-2">
    </div>
</div>




