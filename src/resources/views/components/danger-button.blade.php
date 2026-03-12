<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
            inline-flex items-center justify-center px-6 py-3
            bg-red-500/10 text-red-600 dark:text-red-400
            font-bold text-sm font-heading uppercase tracking-wider
            rounded-xl border border-red-500/20
            hover:bg-red-500 hover:text-white hover:shadow-lg hover:shadow-red-500/20
            active:scale-[0.97]
            transition-all duration-300 ease-out
            focus:outline-none focus:ring-4 focus:ring-red-500/20
        ',
    ]) }}>
    {{ $slot }}
</button>
