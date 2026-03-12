@props([
    'active' => false,
])

@php
    $baseClasses = 'group flex items-center justify-between w-full px-4 py-3.5 rounded-xl font-body text-base transition-all duration-300 ease-out';

    $inactiveClasses = 'text-gray-600 hover:text-primaryColor hover:bg-gray-50 hover:translate-x-0.5';

    $activeClasses = 'bg-primaryColor/10 text-primaryColor font-semibold shadow-sm';

    $classes = $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
