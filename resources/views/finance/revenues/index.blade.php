@extends('layouts.app')

@section('title', 'Revenus')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-hh-gold">📈 Revenus</h2>

        <a href="{{ route('revenues.create') }}" class="hh-btn-primary">
            + Nouveau Revenu
        </a>
    </div>

    <div class="bg-hh-card rounded-xl shadow border border-hh-border p-4 overflow-x-auto">
        <table class="w-full table-auto hh-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Filiale</th>
                    <th>Agence</th>
                    <th>Document</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($revenues as $revenue)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $revenue->description }}</td>
                        <td class="text-green-400 font-semibold">
                            + {{ number_format($revenue->amount, 0, ',', ' ') }} FBu
                        </td>
                        <td>{{ $revenue->date?->format('d/m/Y') ?? '—' }}</td>
                        <td>{{ $revenue->filiale->name ?? '—' }}</td>
                        <td>{{ $revenue->agence->name ?? '—' }}</td>
                        <td class="text-center">
                            @if($revenue->attachment)
                                <a href="{{ Storage::url($revenue->attachment) }}" target="_blank" 
                                   class="text-blue-400 hover:text-blue-300" title="Télécharger">
                                    <i class="fas fa-file-download"></i>
                                </a>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>
                        <td class="text-right space-x-3">
                            <a href="{{ route('revenues.show', $revenue) }}" class="text-blue-400 hover:text-blue-300">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('revenues.edit', $revenue) }}" class="text-yellow-400 hover:text-yellow-300">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('revenues.destroy', $revenue) }}" method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Supprimer ce revenu ?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-300">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-400">Aucun revenu enregistré.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection




