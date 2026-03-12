<div class="relative overflow-hidden glass-card rounded-3xl p-4 sm:p-8 shadow-premium transition-all duration-500 group">
    {{-- Background animation --}}
    <div
        class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primaryColor/5 to-transparent pointer-events-none">
    </div>

    <div class="relative z-10">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8">
            <div class="mb-4 sm:mb-0">
                <h1
                    class="text-2xl sm:text-3xl font-heading font-black text-gray-900 dark:text-light flex items-center mb-2">
                    <span class="premium-gradient bg-clip-text text-transparent mr-3">
                        <i class="fa-solid fa-bolt-lightning"></i>
                    </span>
                    Activity Stream
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-body">Everything that's happening across your
                    agency.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <button wire:click="refresh()"
                    class="group/refresh flex items-center space-x-2 px-6 py-3 bg-white/50 dark:bg-black/40 hover:bg-white dark:hover:bg-black text-gray-700 dark:text-gray-300 rounded-2xl text-xs font-bold transition-all duration-300 border border-white/20 dark:border-white/5 shadow-sm hover-lift">
                    <i class="fa-solid fa-rotate group-hover/refresh:rotate-180 transition-transform duration-500"></i>
                    <span>Refresh Feed</span>
                </button>
            </div>
        </div>

        <div class="w-full">
            @if ($activities->isEmpty())
                <div
                    class="px-6 py-20 text-center text-gray-400 dark:text-gray-500 font-body italic glass-card rounded-2xl border-dashed">
                    <div class="flex flex-col items-center">
                        <div
                            class="w-20 h-20 bg-gray-100/50 dark:bg-gray-800/50 rounded-full flex items-center justify-center mb-6">
                            <i class="fa-solid fa-wind text-3xl opacity-30"></i>
                        </div>
                        <p class="text-xl">The stream is calm...</p>
                        <p class="text-sm mt-2 opacity-60">No recent activities to show right now.</p>
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($activities as $activity)
                        <div
                            class="relative group/activity p-5 rounded-2xl bg-white/40 dark:bg-black/20 border border-white/20 dark:border-white/5 hover:bg-white/60 dark:hover:bg-black/30 transition-all duration-300">
                            <div class="flex flex-col sm:flex-row items-start justify-between">
                                <div class="flex items-center space-x-4 mb-2 sm:mb-0">
                                    <div class="relative">
                                        <div
                                            class="w-12 h-12 rounded-full overflow-hidden border-2 border-white dark:border-gray-800 shadow-sm">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($activity->user_name) }}&background=80558E&color=fff"
                                                alt="{{ $activity->user_name }}">
                                        </div>
                                        <div
                                            class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white dark:border-gray-900 flex items-center justify-center">
                                            <i class="fa-solid fa-check text-[8px] text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex items-center">
                                            <span
                                                class="font-bold text-gray-900 dark:text-gray-100 font-heading">{{ $activity->user_name }}</span>
                                            <span class="mx-2 text-gray-300 dark:text-gray-700">•</span>
                                            <span
                                                class="text-[10px] uppercase font-black tracking-widest text-primaryColor opacity-80">Updated
                                                project</span>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-body">
                                            {{ $activity->details }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-left sm:text-right w-full sm:w-auto pl-[4rem] sm:pl-0">
                                    <div
                                        class="text-[10px] font-bold text-gray-400 dark:text-gray-500 font-numbers uppercase">
                                        @if ($activity->created_at->diffInHours() > 24)
                                            {{ $activity->created_at->format('M j, Y') }}
                                        @else
                                            {{ $activity->created_at->diffForHumans() }}
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-300 dark:text-gray-700 mt-1">
                                        {{ $activity->created_at->format('H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
