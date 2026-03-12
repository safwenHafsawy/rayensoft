<div class="h-full w-full">
    <div class="container px-2 sm:px-4 py-4 sm:py-6">
        <div
            class="overflow-x-auto rounded-3xl border border-gray-200/30 dark:border-white/10 bg-white/60 dark:bg-dark/50 backdrop-blur-xl shadow-lg hover:shadow-2xl transition-all duration-500">

            <!-- Header -->
            <div
                class="flex items-center justify-between px-6 py-4 border-b border-gray-200/40 dark:border-white/10 bg-gradient-to-r from-white/50 to-gray-100/30 dark:from-dark/60 dark:to-dark/40 backdrop-blur-lg">
                <div>
                    <span class="text-xl font-semibold font-heading text-gray-800 dark:text-gray-100">
                        {{ $this->chosenMonth['name'] }}
                    </span>
                    <span class="ml-2 text-lg font-medium text-gray-500 dark:text-gray-400">
                        {{ $this->currentYear }}
                    </span>
                </div>

                <div
                    class="flex items-center space-x-2 bg-gray-100/60 dark:bg-white/10 border border-gray-200/30 dark:border-white/10 rounded-xl px-1 py-0.5 shadow-sm">
                    <button type="button"
                        class="inline-flex items-center justify-center p-2 rounded-lg hover:bg-gray-200/70 dark:hover:bg-white/10 transition"
                        wire:click="previousMonth">
                        <i class="fa-solid fa-chevron-left text-gray-600 dark:text-gray-300"></i>
                    </button>
                    <div class="w-px h-5 bg-gray-300/50 dark:bg-gray-600/50"></div>
                    <button type="button"
                        class="inline-flex items-center justify-center p-2 rounded-lg hover:bg-gray-200/70 dark:hover:bg-white/10 transition"
                        wire:click="nextMonth">
                        <i class="fa-solid fa-chevron-right text-gray-600 dark:text-gray-300"></i>
                    </button>
                </div>
            </div>

            <!-- Days of Week -->
            <div class="min-w-[800px]">
                <div class="grid grid-cols-7 bg-gray-100/40 dark:bg-dark/40">
                    @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                        <div
                            class="px-2 py-3 text-sm font-semibold text-center uppercase tracking-wide text-gray-600 dark:text-gray-300">
                            {{ $day }}
                        </div>
                    @endforeach
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 border-t border-gray-200/40 dark:border-white/10">
                    {{-- Blank Days --}}
                    @for ($i = 0; $i < $blankDays; $i++)
                        <div class="h-44 border-r border-b border-gray-200 dark:border-white/10"></div>
                    @endfor

                    {{-- Days --}}
                    @foreach ($daysInMonth as $day)
                        <div class="relative h-44 border-r border-b border-gray-200/40 dark:border-white/10 p-3 hover:bg-gray-50/60 dark:hover:bg-white/5 transition-all duration-300 group cursor-pointer"
                            wire:click="openCreateMeetingModal('{{ $day['date'] }}')">

                            <div class="flex justify-between items-center">
                                <span
                                    class="text-sm font-semibold text-gray-700 dark:text-gray-100 group-hover:text-primary transition">
                                    {{ $day['number'] }}
                                </span>
                                @if ($day['class'])
                                    <span
                                        class="w-2 h-2 rounded-full {{ $day['class'] }} ring-2 ring-primaryColor-lighter"></span>
                                @endif
                            </div>

                            <!-- Events -->
                            <div
                                class="mt-2 space-y-1 overflow-y-auto max-h-28 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
                                @foreach ($events[$day['number']] ?? [] as $event)
                                    <div wire:click.stop="openMeetingDetailsModal('{{ $event['id'] }}')"
                                        class="px-2 py-1 rounded-lg border border-transparent font-medium text-xs truncate shadow-sm hover:shadow-md transition bg-gradient-to-r from-primaryColor to-primaryColor-light text-white"
                                        title="{{ $event['title'] }} - {{ $event['time'] }}">
                                        {{ $event['title'] }} - {{ $event['time'] }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
