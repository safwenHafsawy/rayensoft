@props([
    'background' => 'custom-gradient',
    'text' => '',
    'textAlign' => 'text-center',
    'size' => '2xl',
])

@php
    $classes = "break-words text-2xl text-center font-bold tracking-tight font-heading gradient-text sm:text-3xl md:text-4xl lg:text-4xl 2xl:text-5xl xl:{$textAlign}";
@endphp

<h1 {{ $attributes->merge(['class' => $classes]) }}>
    {{ $text }}
</h1>
