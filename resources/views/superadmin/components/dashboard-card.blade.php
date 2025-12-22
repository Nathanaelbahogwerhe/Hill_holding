@props(['title', 'count', 'icon', 'route'])

<a href="{{ route($route) }}" class="bg-black text-yellow-500 rounded-xl shadow-lg p-6 hover:shadow-2xl transition flex items-center justify-between">
    <div>
        <p class="text-lg font-semibold">{{ $title }}</p>
        <p class="text-3xl font-bold mt-1">{{ $count }}</p>
    </div>

    <div class="w-12 h-12 flex items-center justify-center">
        @switch($icon)
            @case('users')
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                @break

            @case('clipboard-list')
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h6M9 8h6" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7v12a2 2 0 002 2h6" />
                </svg>
                @break

            @case('currency-dollar')
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v2m0 12v2" />
                </svg>
                @break

            @case('clipboard-document')
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h6M9 8h6" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7v10a2 2 0 002 2h6a2 2 0 002-2V7" />
                </svg>
                @break

            @default
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
        @endswitch
    </div>
</a>




