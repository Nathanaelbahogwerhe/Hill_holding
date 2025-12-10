@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-kc-card text-white shadow-lg rounded-2xl p-6 mt-10 border border-kc-border">
    <h1 class="text-2xl font-bold text-kc-primary mb-6">âž• Ajouter un EmployÃ©</h1>

    @if ($errors->any())
        <div class="bg-red-700 text-white p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block mb-1 font-semibold text-kc-primary">PrÃ©nom</label>
                <input type="text" name="first_name" class="w-full p-2 rounded bg-gray-900 border border-kc-primary" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold text-kc-primary">Nom</label>
                <input type="text" name="last_name" class="w-full p-2 rounded bg-gray-900 border border-kc-primary" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold text-kc-primary">Email (optionnel)</label>
                <input type="email" name="email" class="w-full p-2 rounded bg-gray-900 border border-kc-primary">
            </div>

            <div>
                <label class="block mb-1 font-semibold text-kc-primary">Salaire de base</label>
                <input type="number" name="basic_salary" class="w-full p-2 rounded bg-gray-900 border border-kc-primary" min="0">
            </div>

            <div>
                <label class="block mb-1 font-semibold text-kc-primary">DÃ©partement</label>
                <select name="department_id" class="w-full p-2 rounded bg-gray-900 border border-kc-primary">
                    <option value="">-- SÃ©lectionner --</option>
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold text-kc-primary">Filiale</label>
                <select name="filiale_id" class="w-full p-2 rounded bg-gray-900 border border-kc-primary">
                    <option value="">-- SÃ©lectionner --</option>
                    @foreach($filiales as $filiale)
                        <option value="{{ $filiale->id }}">{{ $filiale->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold text-kc-primary">Agence</label>
                <select name="agency_id" class="w-full p-2 rounded bg-gray-900 border border-kc-primary">
                    <option value="">-- SÃ©lectionner --</option>
                    @foreach($agences as $agence)
                        <option value="{{ $agence->id }}">{{ $agence->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold text-kc-primary">Utilisateur liÃ© (optionnel)</label>
                <select name="user_id" class="w-full p-2 rounded bg-gray-900 border border-kc-primary">
                    <option value="">-- Aucun --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-kc-primary hover:bg-blue-600 text-black font-semibold px-6 py-2 rounded">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection







