<div
    x-data="{ open: @entangle('isOpen') }"
    x-show="open"
    x-transition.opacity.duration.300ms
    @keydown.escape.window="open = false; $wire.closeModal()"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm px-4"
    @click.self="$wire.closeModal()"
>

    <!-- Premium Close Button -->
    <button
        @click="$wire.closeModal()"
        class="absolute top-6 right-6 z-60 bg-white/10 backdrop-blur-xl border border-white/20
               rounded-full p-3 shadow-lg hover:bg-white/20 active:scale-90 transition
               text-white"
        aria-label="Close Modal"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Image -->
    <img
        src="{{ asset($imagePath) }}"
        alt="Project Image"
        class="max-w-[90vw] max-h-[85vh] rounded-xl shadow-2xl object-contain
               touch-pinch-zoom transition-transform duration-300 ease-out scale-100"
        x-transition.scale.duration.300ms
    >

</div>
