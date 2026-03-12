<div
    class="
        relative rounded-[1.2rem] p-4 sm:p-8 lg:p-10
        bg-gradient-to-br from-white/95 to-white/80
        dark:bg-gradient-to-br dark:from-dark dark:to-dark/95
        border border-gray-200 dark:border-primaryColor-darker/30
        shadow-xl shadow-primaryColor/10 dark:shadow-black/40
        transition-all duration-500
        hover:shadow-primaryColor/30 hover:-translate-y-[2px]
        overflow-hidden
    ">

    <!-- Premium Ambient Glow -->
    <div class="absolute inset-0 pointer-events-none">
        <div
            class="
            absolute -top-10 -right-10 w-48 h-48
            bg-primaryColor/10 dark:bg-primaryColor/20
            blur-[90px] rounded-full
        ">
        </div>
        <div
            class="
            absolute top-10 left-10 w-40 h-40
            bg-accentColor/10 dark:bg-accentColor/15
            blur-[100px] rounded-full
        ">
        </div>
    </div>

    <!-- Soft Texture Layer -->
    <div
        class="
            absolute inset-0 rounded-[1.2rem]
            bg-gradient-to-br
            from-white/40 via-white/10 to-white/5
            dark:from-primaryColor-darker/10 dark:via-dark/10 dark:to-dark/10
            backdrop-blur-[2px]
            pointer-events-none
        ">
    </div>

    <!-- HEADER -->
    <div
        class="
            relative flex flex-col sm:flex-row items-start sm:items-center
            justify-between mb-8 pb-4
            border-b border-gray-300/60 dark:border-primaryColor-darker/40
        ">

        <h1
            class="
                text-[1.9rem] font-heading font-extrabold
                text-gray-900 dark:text-light
                flex items-center gap-3
                tracking-tight
            ">
            <i class="fa-solid fa-piggy-bank text-primaryColor text-3xl"></i>
            BANK BALANCE
        </h1>

    </div>

    <!-- AMOUNT -->
    <div class="relative space-y-1">
        <p class="text-xs text-gray-600 dark:text-gray-400">Available</p>

        <h1
            class="
                text-4xl font-bold tracking-tight
                text-dark dark:text-light
                relative
            ">
            {{ number_format($bankBalance->amount / 1000, 2) }} TND
        </h1>
    </div>

    <!-- DIVIDER -->
    <div class="my-6 border-t border-primaryColor-lighter/40 dark:border-primaryColor/25"></div>

    <!-- RECORDED AT -->
    <div class="relative space-y-1">
        <p class="text-xs text-gray-600 dark:text-gray-400">Recorded At</p>
        <p class="text-sm font-medium text-dark dark:text-light">
            {{ $bankBalance->recorded_at }}
        </p>
    </div>

    <!-- NOTES -->
    <div class="relative space-y-1 mt-6">
        <p class="text-xs text-gray-600 dark:text-gray-400">Notes</p>

        @if ($bankBalance->notes)
            <p class="text-sm text-dark dark:text-light leading-relaxed">
                {{ $bankBalance->notes }}
            </p>
        @else
            <p class="text-sm italic text-gray-500 dark:text-gray-400">
                No notes recorded.
            </p>
        @endif
    </div>

</div>
