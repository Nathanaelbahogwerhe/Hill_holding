@extends('layouts.app')
@section('title', 'Nouveau Paramètre Système')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.system-settings.index') }}" class="inline-flex items-center gap-2 text-hh-gold hover:text-hh-gold/80 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Retour aux paramètres
        </a>
    </div>

    {{-- Form --}}
    <div class="bg-hh-card rounded-lg p-6 border border-hh-border">
        <h2 class="text-xl font-semibold mb-6">Créer un nouveau paramètre</h2>

        <form method="POST" action="{{ route('admin.system-settings.store') }}" class="space-y-6">
            @csrf

            {{-- Category --}}
            <div>
                <label for="category" class="block text-sm font-medium text-hh-muted mb-2">
                    Catégorie <span class="text-red-500">*</span>
                </label>
                <select id="category" name="category" required class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-lg text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('category') border-red-500 @enderror">
                    <option value="">Sélectionner une catégorie</option>
                    <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>Général</option>
                    <option value="email" {{ old('category') == 'email' ? 'selected' : '' }}>Email</option>
                    <option value="security" {{ old('category') == 'security' ? 'selected' : '' }}>Sécurité</option>
                    <option value="maintenance" {{ old('category') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="api" {{ old('category') == 'api' ? 'selected' : '' }}>API</option>
                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('category')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Key --}}
            <div>
                <label for="key" class="block text-sm font-medium text-hh-muted mb-2">
                    Clé <span class="text-red-500">*</span>
                </label>
                <input type="text" id="key" name="key" value="{{ old('key') }}" required class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-lg text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('key') border-red-500 @enderror" placeholder="app_name, maintenance_mode, etc.">
                <p class="mt-1 text-xs text-hh-muted">Utilisez snake_case (ex: app_name, max_upload_size)</p>
                @error('key')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type --}}
            <div>
                <label for="type" class="block text-sm font-medium text-hh-muted mb-2">
                    Type <span class="text-red-500">*</span>
                </label>
                <select id="type" name="type" required class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-lg text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('type') border-red-500 @enderror">
                    <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Texte</option>
                    <option value="boolean" {{ old('type') == 'boolean' ? 'selected' : '' }}>Booléen (Oui/Non)</option>
                    <option value="number" {{ old('type') == 'number' ? 'selected' : '' }}>Nombre</option>
                    <option value="json" {{ old('type') == 'json' ? 'selected' : '' }}>JSON</option>
                </select>
                @error('type')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Value --}}
            <div>
                <label for="value" class="block text-sm font-medium text-hh-muted mb-2">
                    Valeur <span class="text-red-500">*</span>
                </label>
                <textarea id="value" name="value" rows="3" required class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-lg text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('value') border-red-500 @enderror">{{ old('value') }}</textarea>
                <p class="mt-1 text-xs text-hh-muted">Pour booléen: 0 ou 1. Pour JSON: format JSON valide</p>
                @error('value')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-hh-muted mb-2">
                    Description
                </label>
                <textarea id="description" name="description" rows="2" class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-lg text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Is Public --}}
            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_public" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }} class="w-4 h-4 rounded border-hh-border bg-hh-dark text-hh-gold focus:ring-2 focus:ring-hh-gold">
                <label for="is_public" class="text-sm text-hh-muted">
                    Paramètre public (accessible sans authentification)
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-4 pt-6">
                <a href="{{ route('admin.system-settings.index') }}" class="px-6 py-2 bg-hh-dark border border-hh-border rounded-lg hover:bg-hh-dark/50 transition">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-hh-gold text-hh-dark rounded-lg hover:bg-hh-gold/90 transition">
                    Créer le paramètre
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
