<div class="flex flex-col items-center
            bg-white/60 dark:bg-dark/60 backdrop-blur-lg
            rounded-2xl shadow-lg border border-white/20 dark:border-white/10
            p-6 transition-colors duration-300">
    <div class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow"></div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 pb-4
                border-b border-gray-200 dark:border-gray-700 w-full">
        <h1 class="text-xl font-heading font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
            🏅 Archived Goals Leaderboard
        </h1>
    </div>

    <!-- Podium Section -->
    <div class="flex flex-wrap items-end justify-center gap-8">

        {{-- 2nd Place --}}
        <div class="relative flex flex-col items-center group">
            <div class="w-24 h-36
                        bg-gradient-to-t from-gray-300 to-gray-100 dark:from-gray-800 dark:to-gray-700
                        rounded-t-3xl flex items-end justify-center shadow-lg dark:shadow-gray-900
                        transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-xl">
                <span class="text-3xl mb-2">🥈</span>
            </div>
            <div class="absolute -top-3 right-3 text-xs bg-white/80 dark:bg-gray-800/80
                        backdrop-blur px-2 py-0.5 rounded-full font-semibold
                        text-gray-800 dark:text-gray-200 shadow">
                #2
            </div>
            @if (isset($leaderboard[1]))
                <span class="mt-3 font-semibold text-gray-800 dark:text-gray-100 truncate w-24 text-center">
                    {{ $leaderboard[1][0] }}
                </span>
                <span class="text-gray-600 dark:text-gray-300 text-sm">
                    {{ $leaderboard[1][1] }} goal{{ $leaderboard[1][1] > 1 ? 's' : '' }}
                </span>
            @else
                <span class="mt-3 font-semibold text-gray-400 dark:text-gray-500 truncate w-24 text-center">—</span>
                <span class="text-gray-400 dark:text-gray-500 text-sm">0 goals</span>
            @endif
        </div>

        {{-- 1st Place --}}
        <div class="relative flex flex-col items-center group">
            <div class="w-28 h-44
                        bg-gradient-to-t from-yellow-400 to-yellow-200 dark:from-yellow-600 dark:to-yellow-500
                        rounded-t-3xl flex items-end justify-center shadow-2xl dark:shadow-yellow-800
                        transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-yellow-700/60">
                <span class="text-4xl mb-2 animate-pulse">🥇</span>
            </div>
            <div class="absolute -top-3 right-3 text-xs bg-white/80 dark:bg-gray-800/80
                        backdrop-blur px-2 py-0.5 rounded-full font-semibold
                        text-gray-800 dark:text-gray-200 shadow">
                #1
            </div>
            @if (isset($leaderboard[0]))
                <span class="mt-3 font-semibold text-gray-800 dark:text-gray-100 truncate w-28 text-center">
                    {{ $leaderboard[0][0] }}
                </span>
                <span class="text-gray-600 dark:text-gray-300 text-sm">
                    {{ $leaderboard[0][1] }} goal{{ $leaderboard[0][1] > 1 ? 's' : '' }}
                </span>
            @else
                <span class="mt-3 font-semibold text-gray-400 dark:text-gray-500 truncate w-28 text-center">—</span>
                <span class="text-gray-400 dark:text-gray-500 text-sm">0 goals</span>
            @endif
        </div>

        {{-- 3rd Place --}}
        <div class="relative flex flex-col items-center group">
            <div class="w-24 h-32
                        bg-gradient-to-t from-orange-400 to-orange-200 dark:from-orange-600 dark:to-orange-500
                        rounded-t-3xl flex items-end justify-center shadow-lg dark:shadow-orange-800
                        transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-xl">
                <span class="text-3xl mb-2">🥉</span>
            </div>
            <div class="absolute -top-3 right-3 text-xs bg-white/80 dark:bg-gray-800/80
                        backdrop-blur px-2 py-0.5 rounded-full font-semibold
                        text-gray-800 dark:text-gray-200 shadow">
                #3
            </div>
            @if (isset($leaderboard[2]))
                <span class="mt-3 font-semibold text-gray-800 dark:text-gray-100 truncate w-24 text-center">
                    {{ $leaderboard[2][0] }}
                </span>
                <span class="text-gray-600 dark:text-gray-300 text-sm">
                    {{ $leaderboard[2][1] }} goal{{ $leaderboard[2][1] > 1 ? 's' : '' }}
                </span>
            @else
                <span class="mt-3 font-semibold text-gray-400 dark:text-gray-500 truncate w-24 text-center">—</span>
                <span class="text-gray-400 dark:text-gray-500 text-sm">0 goals</span>
            @endif
        </div>

    </div>

    <!-- Other Members List -->
    <div class="mt-8 w-full max-h-64 overflow-y-auto rounded-xl
                border border-gray-200 dark:border-gray-700
                divide-y divide-gray-100 dark:divide-gray-700">
        @foreach ($leaderboard as $index => [$member, $score])
            @if ($index > 2)
                <div class="flex items-center justify-between px-4 py-3
                            bg-white/70 dark:bg-gray-800/70 backdrop-blur
                            hover:bg-purple-50 dark:hover:bg-purple-900/40
                            transition duration-200">
                    <span class="font-medium text-gray-700 dark:text-gray-200">
                        {{ $index + 1 }}. {{ $member }}
                    </span>
                    <span class="font-semibold text-gray-800 dark:text-gray-100">
                        {{ $score }} goal{{ $score > 1 ? 's' : '' }}
                    </span>
                </div>
            @endif
        @endforeach
    </div>
</div>
