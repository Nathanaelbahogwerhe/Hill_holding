@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-4">
    <h2 class="text-xl font-semibold mb-4">Toutes les notifications</h2>

    @foreach($notifications as $notif)
        <div class="border-b py-2 {{ !$notif->is_read ? 'bg-gray-100' : '' }}">
            <a href="{{ $notif->url ?? '#' }}" class="block">
                <strong>{{ $notif->title }}</strong>
                <p class="text-sm text-gray-600">{{ $notif->message }}</p>
                <span class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</span>
            </a>
        </div>
    @endforeach

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection







