@props(['route', 'color' => 'text-accentColor'])

@php
    try {
        $href = route($route);
    } catch (\InvalidArgumentException $e) {
        $href = $route;
    }

    $currentDomain = parse_url(url('/'), PHP_URL_HOST);
    $targetDomain = parse_url($href, PHP_URL_HOST);
    $isExternal = $currentDomain !== $targetDomain;

    $attributes = $attributes->merge([
        'class' =>
            '
            relative no-underline
            font-body ' .
            $color .
            '
            hover:text-white transition-colors duration-300 ease-out
            focus:outline-none focus:ring-2 focus:ring-inset focus:ring-accentColor/40
            group gap-2
        ',
    ]);
@endphp

<a href="{{ $href }}" {{ $attributes }} target="{{ $isExternal ? '_blank' : '_self' }}"
    rel="{{ $isExternal ? 'noopener noreferrer' : '' }}">

    <span class="flex items-center gap-2 relative z-10">
        {{ $slot }}
        <svg class="w-5 h-5 text-current transition-transform duration-300 ease-out group-hover:translate-x-1 group-hover:-translate-y-1"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M17 7l-10 10"></path>
            <path d="M8 7l9 0l0 9"></path>
        </svg>
    </span>

    <span
        class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-primaryColor-light to-accentColor origin-bottom-right transform scale-x-0 group-hover:scale-x-100 group-hover:origin-bottom-left transition-transform duration-300 ease-out"></span>
</a>
