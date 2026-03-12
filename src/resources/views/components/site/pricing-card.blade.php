@props([
    'id' => '',
    'cardTitle' => '',
    'briefings' => [],
    'type' => 'regular',
])

@php
    $isMain = $type === 'main';
    $baseClasses =
        'relative px-10 md:px-4 lg:px-8 xl:px-10 pt-6 h-fit rounded-3xl transition-all duration-500 transform hover:scale-[1.03]';
    $regularClasses = 'glass-card glass-card-hover text-gray-200';
    $mainClasses =
        'bg-gradient-to-br from-primaryColor-light to-accentColor text-white shadow-lg shadow-primaryColor-light/20';
@endphp

<div {!! $attributes->merge([
    'class' => $baseClasses . ' ' . ($isMain ? $mainClasses : $regularClasses),
]) !!}>

    {{-- Featured Badge --}}
    @if ($isMain)
        <div
            class="absolute -top-4 right-4 px-4 py-1 bg-white/15 backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-widest text-white shadow-md">
            <i class="fa-solid fa-gem mr-1"></i> Popular
        </div>
    @endif

    {{-- Title --}}
    <header class="mb-8 text-center">
        <h2 class="font-heading font-extrabold text-xl md:text-base lg:text-lg xl:text-2xl tracking-tight">
            {{ $cardTitle }}
        </h2>
        <div
            class="w-20 h-1 mx-auto mt-3 rounded-full {{ $isMain ? 'bg-white/80' : 'bg-gradient-to-r from-primaryColor-light to-accentColor' }}">
        </div>
    </header>

    {{-- Features --}}
    <div class="space-y-4 mb-6">
        @foreach ($briefings as $briefing)
            <p class="flex items-start text-base md:text-xs lg:text-base">
                <i class="fa-solid fa-circle-check mr-3 mt-1 text-accentColor flex-shrink-0"></i>
                <span class="{{ $isMain ? 'text-white/90' : 'text-gray-300' }}">{{ $briefing }}</span>
            </p>
        @endforeach
        <p class="text-sm font-light italic text-gray-500 mt-2 text-center">And much more…</p>
    </div>
</div>
