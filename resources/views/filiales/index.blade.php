@extends('layouts.app')
@section('title','Filiales')
@section('content')
<div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-semibold">Filiales</h2>
    <a href="{{ route('filiales.create') }}" class="px-3 py-2 rounded bg-hh-gold text-black">Nouvelle filiale</a>
</div>

<div class="bg-hh-card p-4 rounded shadow">
    <table class="w-full text-sm">
        <thead class="text-hh-muted"><tr><th class="py-2">Nom</th><th class="py-2">Actions</th></tr></thead>
        <tbody>
            @forelse($filiales ?? [] as $f)
                <tr class="border-t border-hh-border"><td class="py-3">{{ $f->name }}</td><td class="py-3"><a href="{{ route('filiales.edit',$f) }}" class="text-hh-gold">Ã‰diter</a></td></tr>
            @empty
                <tr><td colspan="2" class="py-6 text-center text-hh-muted">Aucune filiale</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection







