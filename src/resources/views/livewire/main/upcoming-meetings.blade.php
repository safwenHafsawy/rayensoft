<div class="relative glass-card rounded-3xl p-4 sm:p-8 shadow-premium hover-lift overflow-hidden h-full">
    {{-- Decorative background --}}
    <div class="absolute bottom-0 right-0 w-40 h-40 bg-primaryColor/5 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Header -->
    <div class="relative z-10 flex items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl premium-gradient flex items-center justify-center shadow-premium">
                <i class="fa-solid fa-calendar-days text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-heading font-black text-gray-900 dark:text-white tracking-tight">Upcoming
                    Meetings</h1>
                <p class="text-xs text-gray-400 dark:text-gray-500 font-body mt-0.5">Your schedule at a glance</p>
            </div>
        </div>
        <a href="{{ route('meetings') }}"
            class="p-2 rounded-xl text-gray-400 hover:text-primaryColor hover:bg-primaryColor/5 transition-all duration-200"
            title="View Calendar">
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <!-- Meetings List -->
    <div class="relative z-10 space-y-4">
        @if ($meetings->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-white/5 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-mug-hot text-2xl text-gray-300 dark:text-gray-600"></i>
                </div>
                <span class="font-heading font-bold text-gray-500 dark:text-gray-400">Clear Schedule</span>
                <span class="text-xs mt-1 text-gray-400">No upcoming meetings today</span>
            </div>
        @else
            @foreach ($meetings as $meeting)
                <div
                    class="flex items-center p-4 rounded-2xl glass-subtle transition-all duration-300 hover:bg-white/60 dark:hover:bg-white/10 group cursor-pointer">
                    <!-- Date Box -->
                    <div
                        class="flex-shrink-0 flex flex-col items-center justify-center w-14 h-14 rounded-xl bg-white/50 dark:bg-white/5 border border-white/20 dark:border-white/10 shadow-sm mr-4 group-hover:border-primaryColor/30 transition-colors">
                        <span
                            class="text-[10px] font-bold text-gray-500 uppercase tracking-wider text-primaryColor">{{ \Carbon\Carbon::parse($meeting->date)->format('M') }}</span>
                        <span
                            class="text-xl font-black text-gray-900 dark:text-white leading-none mt-0.5">{{ \Carbon\Carbon::parse($meeting->date)->format('d') }}</span>
                    </div>

                    <!-- Details -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="text-sm font-heading font-bold text-gray-900 dark:text-white truncate pr-2">
                                {{ $meeting->title }}</h4>
                            <span
                                class="flex-shrink-0 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-lg
                                @if ($meeting->type === 'discovery') bg-green-500/10 text-green-600 dark:text-green-400
                                @elseif($meeting->type === 'client') bg-blue-500/10 text-blue-600 dark:text-blue-400
                                @else bg-gray-500/10 text-gray-600 dark:text-gray-400 @endif">
                                {{ $meeting->type }}
                            </span>
                        </div>
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 space-x-3">
                            <span class="flex items-center"><i
                                    class="fa-regular fa-clock mr-1.5 text-primaryColor/60"></i>{{ $meeting->hour }}</span>
                            <span class="flex items-center truncate"><i
                                    class="fa-solid fa-location-dot mr-1.5 text-primaryColor/60"></i>Google Meet</span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Footer Action -->
    @if (!$meetings->isEmpty())
        <div class="mt-6 pt-4 border-t border-gray-100/50 dark:border-white/5 text-center">
            <a href="{{ route('meetings') }}"
                class="text-xs font-bold text-gray-400 hover:text-primaryColor transition-colors uppercase tracking-widest">View
                Full Schedule</a>
        </div>
    @endif
</div>
