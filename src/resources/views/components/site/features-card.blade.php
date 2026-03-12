@props([
    'imagePath' => '',
    'cardTitle' => '',
    'cardDescription' => '',
    'span' => 'sm:col-span-2 lg:col-span-1',
])

<div
    class="{{ $span }} group relative rounded-2xl overflow-hidden
    glass-card glass-card-hover p-8
    transition-all duration-500 hover:-translate-y-2">

    {{-- Accent glow on hover --}}
    <div
        class="absolute -bottom-10 right-0 w-32 h-32
        bg-accentColor/10 rounded-full blur-2xl pointer-events-none
        opacity-0 group-hover:opacity-100 transition-all duration-500">
    </div>

    {{-- Accent line --}}
    <div
        class="w-10 h-1 bg-gradient-to-r from-primaryColor-light to-accentColor rounded-full mb-5
        group-hover:w-16 transition-all duration-500">
    </div>

    {{-- Title --}}
    <h3 class="text-lg font-semibold leading-tight text-white relative z-10">
        {{ $cardTitle }}
    </h3>

</div>
