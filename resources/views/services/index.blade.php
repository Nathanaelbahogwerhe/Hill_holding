@extends('layouts.app')

@section('title', 'Service - Liste')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-blue-400">
             Service
        </h1>
        <a href="{{ route('services.create') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold transition">
             Ajouter
        </a>
    </div>

    <!-- Messages -->
    @if (session('success'))
        <div class="bg-blue-900 border border-blue-600 text-blue-100 p-4 rounded-lg mb-6">
             {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-slate-900 rounded-lg shadow-xl overflow-hidden border border-slate-700">
        <table class="w-full">
            <thead class="bg-blue-600">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-bold text-white">ID</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-white">Nom</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-white">Statut</th>
                    <th class="px-6 py-4 text-right text-sm font-bold text-white">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse($services as $service)
                    <tr class="hover:bg-slate-800 transition">
                        <td class="px-6 py-4 text-sm text-gray-300">#{{ $service->id }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-100">
                            {{ $service->name ?? $service->first_name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="bg-blue-900 text-blue-200 px-3 py-1 rounded-full text-xs font-semibold">
                                Actif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            <a href="{{ route('services.show', $service->id) }}" class="text-blue-400 hover:text-blue-300 font-bold"></a>
                            <a href="{{ route('services.edit', $service->id) }}" class="text-cyan-400 hover:text-cyan-300 font-bold"></a>
                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 font-bold"></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            Aucun Service trouvé
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination (si paginé) -->
    @if(method_exists($services, 'hasPages') && $services->hasPages())
        <div class="mt-6">
            {{ $services->links() }}
        </div>
    @endif
</div>
@endsection