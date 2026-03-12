@props(['active'])

@php
    $active_classes = 'relative flex items-center mx-1 justify-start md:justify-center md:group-hover:justify-start px-4 rounded-xl h-11 transition-all duration-300 ease-out
        bg-primaryColor/15 dark:bg-primaryColor/20
        text-primaryColor dark:text-primaryColor-light
        font-bold shadow-sm
        border border-primaryColor/20 dark:border-primaryColor/30';

    $inactive_classes = 'relative flex items-center mx-1 justify-start md:justify-center md:group-hover:justify-start px-4 rounded-xl h-11 transition-all duration-300 ease-out
        text-gray-500 dark:text-gray-400
        hover:bg-white/50 dark:hover:bg-white/5
        hover:text-gray-900 dark:hover:text-white';

    $classes = $active ?? false ? $active_classes : $inactive_classes;
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} wire:navigate>
    @if ($active ?? false)
        <span class="nav-active-indicator"></span>
    @endif
    {{ $slot }}
</a>
