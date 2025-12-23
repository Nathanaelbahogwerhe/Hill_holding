@extends('layouts.app')

@section('title', 'Créer Utilisateur')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#D4AF37]">👤 Créer un Utilisateur</h1>
            <p class="text-neutral-400 mt-1">Ajouter un nouvel utilisateur avec rôles et permissions</p>
        </div>
        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl transition">
            ← Retour
        </a>
    </div>

    <!-- Errors -->
    @if ($errors->any())
        <div class="bg-red-900/20 border border-red-700 text-red-300 p-4 rounded-xl mb-6">
            <h3 class="font-bold mb-2">⚠️ Erreurs de validation:</h3>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Informations de base -->
        <div class="bg-neutral-900 rounded-xl p-6 border border-neutral-800">
            <h3 class="text-xl font-bold text-[#D4AF37] mb-4">📋 Informations de base</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Nom complet <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full px-4 py-2 rounded-xl bg-black border border-neutral-700 text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]" 
                           required placeholder="Ex: Jean Dupont">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           class="w-full px-4 py-2 rounded-xl bg-black border border-neutral-700 text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]" 
                           required placeholder="Ex: jean.dupont@company.com">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Mot de passe <span class="text-red-500">*</span></label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-2 rounded-xl bg-black border border-neutral-700 text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]" 
                           required placeholder="Au moins 6 caractères">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Confirmer le mot de passe <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" 
                           class="w-full px-4 py-2 rounded-xl bg-black border border-neutral-700 text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]" 
                           required placeholder="Répéter le mot de passe">
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Filiale</label>
                    <select name="filiale_id" class="w-full px-4 py-2 rounded-xl bg-black border border-neutral-700 text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]">
                        <option value="">🏢 Maison Mère (Hill Holding)</option>
                        @foreach($filiales as $filiale)
                        <option value="{{ $filiale->id }}" {{ old('filiale_id') == $filiale->id ? 'selected' : '' }}>
                            {{ $filiale->name }} @if($filiale->code)({{ $filiale->code }})@endif
                        </option>
                        @endforeach
                    </select>
                    <p class="text-neutral-400 text-sm mt-1">Laisser vide si l'utilisateur appartient à la maison mère</p>
                </div>
            </div>
        </div>

        <!-- Rôles -->
        <div class="bg-neutral-900 rounded-xl p-6 border border-neutral-800">
            <h3 class="text-xl font-bold text-[#D4AF37] mb-4">🎭 Rôles</h3>
            <p class="text-neutral-400 mb-4">Sélectionnez un ou plusieurs rôles pour cet utilisateur</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($roles as $role)
                <label class="flex items-start gap-3 p-4 rounded-xl bg-black border border-neutral-700 hover:border-[#D4AF37] cursor-pointer transition">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                           {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                           class="mt-1 w-5 h-5 text-[#D4AF37] bg-neutral-800 border-neutral-600 rounded focus:ring-[#D4AF37]">
                    <div>
                        <div class="font-semibold text-white">{{ $role->name }}</div>
                        <div class="text-xs text-neutral-400 mt-1">{{ $role->permissions->count() }} permission(s)</div>
                    </div>
                </label>
                @empty
                <div class="col-span-full text-center text-neutral-400 py-4">
                    ⚠️ Aucun rôle disponible. Créez-en dans l'administration.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Permissions spécifiques -->
        <div class="bg-neutral-900 rounded-xl p-6 border border-neutral-800">
            <h3 class="text-xl font-bold text-[#D4AF37] mb-4">🔐 Permissions Spécifiques (optionnel)</h3>
            <p class="text-neutral-400 mb-4">Permissions supplémentaires en plus de celles héritées des rôles</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-96 overflow-y-auto">
                @forelse($permissions as $permission)
                <label class="flex items-center gap-3 p-3 rounded-xl bg-black border border-neutral-700 hover:border-[#D4AF37] cursor-pointer transition">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                           {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                           class="w-4 h-4 text-[#D4AF37] bg-neutral-800 border-neutral-600 rounded focus:ring-[#D4AF37]">
                    <span class="text-sm text-white">{{ $permission->name }}</span>
                </label>
                @empty
                <div class="col-span-full text-center text-neutral-400 py-4">
                    ⚠️ Aucune permission disponible
                </div>
                @endforelse
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4">
            <button type="submit" class="px-6 py-3 bg-[#D4AF37] hover:bg-gradient-to-br from-yellow-900/50 to-yellow-800/50 border border-yellow-500/300 text-black rounded-xl font-bold transition">
                ✅ Créer l'utilisateur
            </button>
            <a href="{{ route('users.index') }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-xl font-bold transition">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>
@endsection