<div class="flex items-center">
    @if (!$workSession)
        <button wire:click="checkIn"
            class="flex items-center gap-2 px-5 py-2.5
                       bg-gradient-to-r from-emerald-500 to-green-400
                       text-white font-heading font-bold text-xs uppercase tracking-wider
                       rounded-xl shadow-lg shadow-green-500/20
                       hover:shadow-green-500/30 hover:scale-[1.03]
                       active:scale-[0.97] transition-all duration-300">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
            </span>
            <span>Check In</span>
        </button>
    @elseif ($workSession->status === 'active')
        <div class="flex items-center gap-3 glass-subtle rounded-xl px-4 py-2">
            <div class="flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-xs font-heading font-bold text-gray-700 dark:text-gray-300">
                    {{ \Carbon\Carbon::parse($workSession->check_in_time)->format('H:i') }}
                </span>
            </div>

            <div class="flex gap-1.5">
                <button wire:click="pause"
                    class="p-2 rounded-lg bg-amber-400/10 text-amber-500 hover:bg-amber-400/20 transition-all duration-200"
                    title="Pause">
                    <i class="fa-solid fa-pause text-xs"></i>
                </button>
                <button wire:click="checkOut"
                    class="p-2 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500/20 transition-all duration-200"
                    title="Check Out">
                    <i class="fa-solid fa-stop text-xs"></i>
                </button>
            </div>
        </div>
    @elseif ($workSession->status === 'paused')
        <div class="flex items-center gap-3 glass-subtle rounded-xl px-4 py-2 border border-amber-500/20">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-pause text-xs text-amber-500"></i>
                <span class="text-xs font-heading font-bold text-amber-600 dark:text-amber-400">Paused</span>
            </div>

            <div class="flex gap-1.5">
                <button wire:click="resume"
                    class="p-2 rounded-lg bg-green-500/10 text-green-500 hover:bg-green-500/20 transition-all duration-200"
                    title="Resume">
                    <i class="fa-solid fa-play text-xs"></i>
                </button>
                <button wire:click="checkOut"
                    class="p-2 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500/20 transition-all duration-200"
                    title="Check Out">
                    <i class="fa-solid fa-stop text-xs"></i>
                </button>
            </div>
        </div>
    @endif
</div>
