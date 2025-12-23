@extends('layouts.app')
@section('title', 'Nouvelle Notification Système')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.system-notifications.index') }}" class="inline-flex items-center gap-2 text-hh-gold hover:text-hh-gold/80 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Retour aux notifications
        </a>
    </div>

    {{-- Form --}}
    <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
        <h2 class="text-xl font-semibold mb-6">Créer une nouvelle notification</h2>

        <form method="POST" action="{{ route('admin.system-notifications.store') }}" class="space-y-6">
            @csrf

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-hh-muted mb-2">
                    Titre <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-xl text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('title') border-red-500 @enderror" placeholder="Titre de la notification">
                @error('title')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Message --}}
            <div>
                <label for="message" class="block text-sm font-medium text-hh-muted mb-2">
                    Message <span class="text-red-500">*</span>
                </label>
                <textarea id="message" name="message" rows="4" required class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-xl text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('message') border-red-500 @enderror" placeholder="Contenu du message...">{{ old('message') }}</textarea>
                @error('message')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type --}}
            <div>
                <label for="type" class="block text-sm font-medium text-hh-muted mb-2">
                    Type <span class="text-red-500">*</span>
                </label>
                <select id="type" name="type" required class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-xl text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('type') border-red-500 @enderror">
                    <option value="info" {{ old('type') == 'info' ? 'selected' : '' }}>Information</option>
                    <option value="success" {{ old('type') == 'success' ? 'selected' : '' }}>Succès</option>
                    <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>Avertissement</option>
                    <option value="error" {{ old('type') == 'error' ? 'selected' : '' }}>Erreur</option>
                </select>
                @error('type')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Target --}}
            <div>
                <label for="target" class="block text-sm font-medium text-hh-muted mb-2">
                    Cible <span class="text-red-500">*</span>
                </label>
                <select id="target" name="target" required class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-xl text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('target') border-red-500 @enderror" onchange="toggleRoleField(this)">
                    <option value="all" {{ old('target') == 'all' ? 'selected' : '' }}>Tous les utilisateurs</option>
                    <option value="admins" {{ old('target') == 'admins' ? 'selected' : '' }}>Administrateurs uniquement</option>
                    <option value="specific_role" {{ old('target') == 'specific_role' ? 'selected' : '' }}>Rôle spécifique</option>
                </select>
                @error('target')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role Name (conditional) --}}
            <div id="role-field" style="display: {{ old('target') == 'specific_role' ? 'block' : 'none' }}">
                <label for="role_name" class="block text-sm font-medium text-hh-muted mb-2">
                    Nom du rôle <span class="text-red-500">*</span>
                </label>
                <select id="role_name" name="role_name" class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-xl text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('role_name') border-red-500 @enderror">
                    <option value="">Sélectionner un rôle</option>
                    <option value="Super Admin" {{ old('role_name') == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="RH Manager" {{ old('role_name') == 'RH Manager' ? 'selected' : '' }}>RH Manager</option>
                    <option value="Admin Finance" {{ old('role_name') == 'Admin Finance' ? 'selected' : '' }}>Admin Finance</option>
                    <option value="Operations Manager" {{ old('role_name') == 'Operations Manager' ? 'selected' : '' }}>Operations Manager</option>
                    <option value="Chargé des Opérations" {{ old('role_name') == 'Chargé des Opérations' ? 'selected' : '' }}>Chargé des Opérations</option>
                </select>
                @error('role_name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Expires At --}}
            <div>
                <label for="expires_at" class="block text-sm font-medium text-hh-muted mb-2">
                    Date d'expiration (optionnel)
                </label>
                <input type="datetime-local" id="expires_at" name="expires_at" value="{{ old('expires_at') }}" class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-xl text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('expires_at') border-red-500 @enderror">
                <p class="mt-1 text-xs text-hh-muted">Laissez vide pour une notification permanente</p>
                @error('expires_at')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Is Active --}}
            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-hh-border bg-hh-dark text-hh-gold focus:ring-2 focus:ring-hh-gold">
                <label for="is_active" class="text-sm text-hh-muted">
                    Activer immédiatement
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-4 pt-6">
                <a href="{{ route('admin.system-notifications.index') }}" class="px-6 py-2 bg-hh-dark border border-hh-border rounded-xl hover:bg-hh-dark/50 transition">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-hh-gold text-hh-dark rounded-xl hover:bg-hh-gold/90 transition">
                    Créer la notification
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleRoleField(select) {
    const roleField = document.getElementById('role-field');
    const roleInput = document.getElementById('role_name');
    
    if (select.value === 'specific_role') {
        roleField.style.display = 'block';
        roleInput.required = true;
    } else {
        roleField.style.display = 'none';
        roleInput.required = false;
    }
}
</script>
@endsection
