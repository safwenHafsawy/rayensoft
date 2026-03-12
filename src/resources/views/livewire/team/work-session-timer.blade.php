@props([
    'activeSessions' => [],
])

<div
    {{ $attributes->merge([
        'class' => 'relative glass-card rounded-3xl p-8 shadow-premium hover-lift overflow-hidden',
    ]) }}>

    {{-- Decorative gradient orb --}}
    <div class="absolute -top-16 -right-16 w-48 h-48 bg-primaryColor/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col space-y-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div
                    class="w-12 h-12 rounded-2xl premium-gradient flex items-center justify-center shadow-premium animate-pulse-ring">
                    <i class="fa-solid fa-clock text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-heading font-black text-gray-900 dark:text-white tracking-tight">
                        Active Sessions
                    </h3>
                    <p class="text-xs text-gray-400 font-body">
                        {{ count($activeSessions) }} {{ Str::plural('member', count($activeSessions)) }} working
                    </p>
                </div>
            </div>

            @if (count($activeSessions) > 0)
                <span
                    class="px-3 py-1.5 rounded-xl text-xs font-bold bg-green-500/10 text-green-600 dark:text-green-400 border border-green-500/20 animate-pulse">
                    <i class="fa-solid fa-circle text-[6px] mr-1.5"></i>Live
                </span>
            @endif
        </div>

        {{-- Session List --}}
        @if (count($activeSessions) === 0)
            <div class="flex flex-col items-center py-8">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-white/5 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-moon text-2xl text-gray-300 dark:text-gray-600"></i>
                </div>
                <span class="font-heading font-bold text-gray-500 dark:text-gray-400">All quiet</span>
                <span class="text-sm mt-1 text-gray-400">No active work sessions right now</span>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($activeSessions as $session)
                    <div
                        class="flex items-center justify-between p-4 rounded-2xl
                               glass-subtle
                               transition-all duration-300 hover:shadow-sm">

                        {{-- Left Side --}}
                        <div class="flex items-center space-x-3">
                            {{-- Status Dot --}}
                            <span class="relative flex h-3 w-3">
                                @if ($session['status'] === 'active')
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                @endif
                                <span
                                    class="relative inline-flex rounded-full h-3 w-3
                                       {{ $session['status'] === 'active' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                            </span>

                            {{-- Avatar --}}
                            <img src="{{ Storage::url($session['user_image']) }}" alt="user"
                                class="w-10 h-10 rounded-xl object-cover ring-2 ring-white/50 dark:ring-white/10">

                            {{-- Name & Status --}}
                            <div class="flex flex-col">
                                <span class="font-heading font-bold text-sm text-gray-900 dark:text-white">
                                    {{ $session['user'] }}
                                </span>
                                <span
                                    class="text-[11px] text-gray-400 dark:text-gray-500 uppercase tracking-wider font-bold">
                                    {{ ucfirst($session['status']) }}
                                </span>
                            </div>
                        </div>

                        {{-- Time --}}
                        <span
                            class="text-sm font-numbers font-bold px-4 py-2 rounded-xl
                                   bg-primaryColor/5 dark:bg-primaryColor/10
                                   text-primaryColor dark:text-primaryColor-light
                                   border border-primaryColor/10">
                            {{ $session['formatted'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
