@props(['route' => null, 'backgroundColor' => null, 'hoverColor' => null])

@php
    try {
        $href = route($route);
    } catch (\InvalidArgumentException $e) {
        $href = $route;
    }

    $attributes = $attributes->class(
        'relative min-w-fit flex items-center justify-center px-6 py-3 rounded-xl font-semibold text-sm
         bg-gradient-to-r from-primaryColor-light to-accentColor
         text-white shadow-lg shadow-primaryColor-light/20
         hover:shadow-accentColor/30 hover:-translate-y-0.5
         transition-all duration-300 ease-out
         overflow-hidden cursor-pointer
         focus:outline-none focus:ring-2 focus:ring-accentColor/40 focus:ring-offset-2 focus:ring-offset-darkColor
         disabled:opacity-50 disabled:cursor-not-allowed',
    );
@endphp

<a @if ($route) href="{{ $href }}" @else type="button" @endif {{ $attributes }}>
    <span class="relative z-10 flex items-center justify-center gap-2">
        {{ $slot }}
    </span>
</a>
