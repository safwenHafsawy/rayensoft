<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
                relative inline-flex items-center justify-center px-7 py-3 overflow-hidden
                bg-white/60 dark:bg-white/5 text-gray-800 dark:text-gray-200
                font-bold text-sm font-heading uppercase tracking-wider
                rounded-xl shadow-sm
                border border-gray-200/50 dark:border-white/10
                backdrop-blur-xl
                hover:bg-white dark:hover:bg-white/10 hover:shadow-premium hover:scale-[1.02]
                active:scale-[0.97]
                transition-all duration-300 ease-out
                focus:outline-none focus:ring-4 focus:ring-primaryColor/15
                disabled:opacity-50 disabled:cursor-not-allowed
            ',
    ]) }}>
    @if (isset($icon))
        <i class="{{ $icon }} mr-2 text-sm text-primaryColor"></i>
    @endif
    {{ $slot }}
</button>
