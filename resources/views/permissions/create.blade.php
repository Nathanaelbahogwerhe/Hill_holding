@extends('layouts.app')
@section('title', 'Créer une Permission')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center gap-2 text-hh-gold hover:text-hh-gold/80 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Retour aux permissions
        </a>
    </div>

    {{-- Form --}}
    <div class="bg-hh-card rounded-xl p-6 border border-hh-border">
        <h2 class="text-xl font-semibold mb-6">Créer une nouvelle permission</h2>

        @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-6">
            <h3 class="font-semibold text-red-500 mb-2">Erreurs:</h3>
            <ul class="list-disc pl-5 space-y-1 text-sm text-red-400">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.permissions.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-medium text-hh-muted mb-2">
                    Nom de la permission <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-xl text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold @error('name') border-red-500 @enderror" placeholder="Ex: manage-users">
                <p class="mt-1 text-xs text-hh-muted">Utilisez le format kebab-case (ex: view-reports, edit-settings)</p>
                @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="guard_name" class="block text-sm font-medium text-hh-muted mb-2">
                    Guard
                </label>
                <input type="text" id="guard_name" name="guard_name" value="{{ old('guard_name', 'web') }}" class="w-full px-4 py-2 bg-hh-dark border border-hh-border rounded-xl text-hh-light focus:outline-none focus:ring-2 focus:ring-hh-gold" placeholder="web">
                <p class="mt-1 text-xs text-hh-muted">Laisser "web" par défaut</p>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-4 pt-6">
                <a href="{{ route('admin.permissions.index') }}" class="px-6 py-2 bg-hh-dark border border-hh-border rounded-xl hover:bg-hh-dark/50 transition">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-hh-gold text-hh-dark rounded-xl hover:bg-hh-gold/90 transition">
                    Créer la permission
                </button>
            </div>
        </form>
    </div>
</div>
@endsection