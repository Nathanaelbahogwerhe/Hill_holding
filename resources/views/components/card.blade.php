@props(['color' => 'blue', 'icon' => '', 'title' => '', 'count' => 0])

<div class="bg-{{ $color }}-500 text-white p-6 rounded-xl shadow flex items-center gap-4">
    <div class="text-3xl">
        <i class="{{ $icon }}"></i>
    </div>
    <div>
        <div class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">{{ $count }}</div>
        <div class="text-sm">{{ $title }}</div>
    </div>
</div>




