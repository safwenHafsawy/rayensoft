@props([
    'imagePath' => '',
    'title' => '',
    'description' => '',
    'route' => '',
])

<div class="relative flex flex-col rounded-xl shadow-xl hover:scale-105 transition-transform duration-300 ease-in-out overflow-hidden bg-lightColor">
    {{-- Project Image --}}
    <div class="relative w-full h-64 md:h-72 overflow-hidden rounded-t-xl">
        <img src="{{ asset($imagePath) }}" alt="Screenshot of {{ $title }} website" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" loading="lazy">
    </div>

    {{-- Project Info --}}
    <div class="p-6 flex flex-col justify-between flex-1">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-darkColor">{{ $title }}</h3>
            <p class="text-gray-600 font-body text-sm mt-2 leading-relaxed">{{ $description }}</p>
        </div>

        {{-- Button --}}
        <div class="flex flex-col items-start">
            <x-site.secondary-button route="{{ $route }}">
                Check Project
            </x-site.secondary-button>
        </div>
    </div>
</div>
