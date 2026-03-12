@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => '
            w-full mt-2 px-5 py-3.5 font-body text-sm rounded-xl
            transition-all duration-300 ease-out

            /* Light Mode */
            bg-white/70 text-gray-900 border border-gray-200/60
            placeholder-gray-400
            shadow-sm
            focus:border-primaryColor/50 focus:ring-4 focus:ring-primaryColor/10
            hover:border-gray-300 hover:bg-white

            /* Dark Mode */
            dark:bg-white/5 dark:text-gray-100 dark:border-white/10
            dark:placeholder-gray-500
            dark:focus:border-primaryColor/50 dark:focus:ring-4 dark:focus:ring-primaryColor/15
            dark:hover:border-white/20 dark:hover:bg-white/8

            /* Shared */
            backdrop-blur-xl
            disabled:opacity-40 disabled:cursor-not-allowed
        ',
]) !!}>
