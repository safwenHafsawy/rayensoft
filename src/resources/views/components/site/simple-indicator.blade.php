@props(['active'])

@php
    $attributes = $attributes->merge([
        'class' =>
            ($active ? 'bg-accentColor' : 'bg-gray-300') .
            ' mx-1 xl:my-2 flex w-6 h-6 inline rounded-full transition duration-150 ease-in-out hover:bg-accentColor xl:hidden',
    ]);

    // dd($attributes);

@endphp

<span {{ $attributes }}>
</span>
