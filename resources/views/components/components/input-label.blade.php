@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#D4AF37]']) }}>
    {{ $value ?? $slot }}
</label>




