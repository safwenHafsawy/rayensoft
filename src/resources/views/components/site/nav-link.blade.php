@props(['active', 'ActiveTextColor' => 'text-primaryColor'])

@php
    $classes =
        $active ?? false
            ? "inline-flex items-center px-1 pt-1 border-b-2 border-primaryColor text-sm font-medium leading-5 $ActiveTextColor outline-none ring-0 focus:outline-none focus:ring-0 transition duration-150 ease-in-out"
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 outline-none ring-0 focus:outline-none focus:ring-0 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}

    <span
        class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-primaryColor rounded-full transition-all duration-300 {{$active ? '':'group-hover:w-3/4'}}"></span>
</a>
