@extends('layouts.app')

@section('title', 'Éditer Utilisateur')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#D4AF37]">✏️ Éditer Utilisateur</h1>
            <p class="text-neutral-400 mt-1">Modifier les informations de {{ $user->name }}</p>
        </div>
        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg transition">
            ← Retour
        </a>
    </div>

    <!-- Errors -->
    @if ($errors->any())
        <div class="bg-red-900/20 border border-red-700 text-red-300 p-4 rounded-lg mb-6">
            <h3 class="font-bold mb-2">⚠️ Erreurs de validation:</h3>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Informations de base -->
        <div class="bg-neutral-900 rounded-lg p-6 border border-neutral-800">
            <h3 class="text-xl font-bold text-[#D4AF37] mb-4">📋 Informations de base</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Nom complet <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           class="w-full px-4 py-2 rounded-lg bg-black border border-neutral-700 text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]" 
                           required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="w-full px-4 py-2 rounded-lg bg-black border border-neutral-700 text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]" 
                           required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Nouveau mot de passe</label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-2 rounded-lg bg-black border border-neutral-700 text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]" 
                           placeholder="Laisser vide pour conserver l'ancien">
                    <p class="text-neutral-400 text-sm mt-1">Laisser vide si vous ne voulez pas changer le mot de passe</p>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="password_confirmation" 
                           class="w-full px-4 py-2 rounded-lg bg-black border border-neutral-700 text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]" 
                           placeholder="Répéter le nouveau mot de passe">
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-[#D4AF37]">Filiale</label>
                    <select name="filiale_id" class="w-full px-4 py-2 rounded-lg bg-black border border-neutral-700 text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]">
                        <option value="">🏢 Maison Mère (Hill Holding)</option>
                        @foreach($filiales as $filiale)
                        <option value="{{ $filiale->id }}" {{ old('filiale_id', $user->filiale_id) == $filiale->id ? 'selected' : '' }}>
                            {{ $filiale->name }} @if($filiale->code)({{ $filiale->code }})@endif
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Rôles -->
        <div class="bg-neutral-900 rounded-lg p-6 border border-neutral-800">
            <h3 class="text-xl font-bold text-[#D4AF37] mb-4">🎭 Rôles</h3>
            <p class="text-neutral-400 mb-4">Rôles actuels: 
                @forelse($user->roles as $role)
                    <span class="inline-block px-2 py-1 bg-[#D4AF37]/20 text-[#D4AF37] rounded text-sm">{{ $role->name }}</span>
                @empty
                    <span class="text-neutral-500">Aucun</span>
                @endforelse
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($roles as $role)
                <label class="flex items-start gap-3 p-4 rounded-lg bg-black border border-neutral-700 hover:border-[#D4AF37] cursor-pointer transition">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                           {{ $user->hasRole($role->name) ? 'checked' : '' }}
                           class="mt-1 w-5 h-5 text-[#D4AF37] bg-neutral-800 border-neutral-600 rounded focus:ring-[#D4AF37]">
                    <div>
                        <div class="font-semibold text-white">{{ $role->name }}</div>
                        <div class="text-xs text-neutral-400 mt-1">{{ $role->permissions->count() }} permission(s)</div>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Permissions spécifiques -->
        <div class="bg-neutral-900 rounded-lg p-6 border border-neutral-800">
            <h3 class="text-xl font-bold text-[#D4AF37] mb-4">🔐 Permissions Directes</h3>
            <p class="text-neutral-400 mb-4">Permissions directes (sans compter celles héritées des rôles)</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-96 overflow-y-auto">
                @foreach($permissions as $permission)
                <label class="flex items-center gap-3 p-3 rounded-lg bg-black border border-neutral-700 hover:border-[#D4AF37] cursor-pointer transition">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                           {{ $user->hasDirectPermission($permission->name) ? 'checked' : '' }}
                           class="w-4 h-4 text-[#D4AF37] bg-neutral-800 border-neutral-600 rounded focus:ring-[#D4AF37]">
                    <span class="text-sm text-white">{{ $permission->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4">
            <button type="submit" class="px-6 py-3 bg-[#D4AF37] hover:bg-yellow-500 text-black rounded-lg font-bold transition">
                ✅ Mettre à jour
            </button>
            <a href="{{ route('users.index') }}" class="px-6 py-3 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg font-bold transition">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>
@endsection