@props(['value'])

<label {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    {{-- accent bar --}}
    <span class="w-0.5 h-5 rounded-full bg-primaryColor/90 inline-block"></span>

    {{-- text --}}
    <span class="block text-xs font-semibold tracking-wider text-gray-600 uppercase">
        {{ $value ?? $slot }}
    </span>
</label>
