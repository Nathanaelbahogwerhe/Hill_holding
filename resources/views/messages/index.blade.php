@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-yellow-500">ðŸ“¨ Messagerie interne</h1>

    <div class="mb-4">
        <a href="{{ route('messages.create') }}" class="bg-yellow-500 text-black px-4 py-2 rounded hover:bg-yellow-600">
            âž• Nouveau message
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-900 text-white rounded-xl shadow p-4">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left">ExpÃ©diteur</th>
                    <th class="px-6 py-3 text-left">Destinataire</th>
                    <th class="px-6 py-3 text-left">Objet</th>
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                    <tr class="{{ $message->is_read ? 'bg-gray-800' : 'bg-gray-700 font-semibold' }}">
                        <td class="px-6 py-3">{{ $message->sender->first_name ?? 'â€”' }}</td>
                        <td class="px-6 py-3">{{ $message->recipient->first_name ?? 'â€”' }}</td>
                        <td class="px-6 py-3">{{ $message->subject }}</td>
                        <td class="px-6 py-3">{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-3 text-center">
                            <a href="{{ route('messages.show', $message) }}" class="text-yellow-400 hover:text-yellow-600">ðŸ‘ï¸ Lire</a>
                            <form action="{{ route('messages.destroy', $message) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Supprimer ce message ?')" class="text-red-400 hover:text-red-600 ml-2">ðŸ—‘ï¸</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-400">Aucun message trouvÃ©</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $messages->links() }}
    </div>
</div>
@endsection







