<nav :class="{ 'translate-x-0 shadow-2xl': mobileMenuOpen, '-translate-x-full md:translate-x-0': !mobileMenuOpen }"
    class="z-[60] fixed flex flex-col h-screen glass-card border-r-0 transition-all duration-500 ease-out w-[260px] md:w-[72px] md:hover:w-[260px] -translate-x-full md:translate-x-0 group overflow-hidden">
    {{-- Sidebar Header --}}
    <div class="relative z-10 flex items-center justify-between h-20 px-4 border-b border-white/10 dark:border-white/5">
        <a href="{{ route('dashboard') }}" class="flex items-center" wire:navigate>
            <div
                class="ml-3 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-300 whitespace-nowrap overflow-hidden">
                <span
                    class="text-sm font-heading font-black tracking-tight text-dark dark:text-light uppercase">Rayen</span>
                <span class="text-sm font-heading font-black tracking-tight gradient-text uppercase">Soft</span>
            </div>
        </a>
        <button @click="mobileMenuOpen = false"
            class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-white/5 transition-colors">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    {{-- Section Label --}}
    <div
        class="relative z-10 px-5 pt-6 pb-2 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-300">
        <span
            class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400/60 dark:text-gray-500/60">Navigation</span>
    </div>

    {{-- Sidebar Links --}}
    <div class="relative z-10 flex-1 flex flex-col px-3 py-2 space-y-1 overflow-y-auto">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <i
                class="fa-solid fa-house-chimney w-5 text-center mr-3 md:mr-0 md:group-hover:mr-3 transition-all duration-200"></i>
            <span class="inline md:hidden md:group-hover:inline text-sm font-heading font-bold whitespace-nowrap">
                {{ __('Dashboard') }}
            </span>
        </x-nav-link>

        <x-nav-link :href="route('client-management')" :active="request()->routeIs('client-management')">
            <i
                class="fa-solid fa-address-book w-5 text-center mr-3 md:mr-0 md:group-hover:mr-3 transition-all duration-200"></i>
            <span class="inline md:hidden md:group-hover:inline text-sm font-heading font-bold whitespace-nowrap">
                {{ __('Clients') }}
            </span>
        </x-nav-link>

        <x-nav-link :href="route('projects')" :active="request()->routeIs('projects')">
            <i
                class="fa-solid fa-folder-open w-5 text-center mr-3 md:mr-0 md:group-hover:mr-3 transition-all duration-200"></i>
            <span class="inline md:hidden md:group-hover:inline text-sm font-heading font-bold whitespace-nowrap">
                {{ __('Projects') }}
            </span>
        </x-nav-link>

        <x-nav-link :href="route('team-management')" :active="request()->routeIs('team-management')">
            <i
                class="fa-solid fa-user-group w-5 text-center mr-3 md:mr-0 md:group-hover:mr-3 transition-all duration-200"></i>
            <span class="inline md:hidden md:group-hover:inline text-sm font-heading font-bold whitespace-nowrap">
                {{ __('Team') }}
            </span>
        </x-nav-link>

        <x-nav-link :href="route('finances')" :active="request()->routeIs('finances')">
            <i
                class="fa-solid fa-wallet w-5 text-center mr-3 md:mr-0 md:group-hover:mr-3 transition-all duration-200"></i>
            <span class="inline md:hidden md:group-hover:inline text-sm font-heading font-bold whitespace-nowrap">
                {{ __('Finances') }}
            </span>
        </x-nav-link>

        <x-nav-link :href="route('messages')" :active="request()->routeIs('messages')">
            <i
                class="fa-solid fa-paper-plane w-5 text-center mr-3 md:mr-0 md:group-hover:mr-3 transition-all duration-200"></i>
            <span class="inline md:hidden md:group-hover:inline text-sm font-heading font-bold whitespace-nowrap">
                {{ __('Messages') }}
            </span>
        </x-nav-link>

        <x-nav-link :href="route('meetings')" :active="request()->routeIs('meetings')">
            <i
                class="fa-solid fa-video w-5 text-center mr-3 md:mr-0 md:group-hover:mr-3 transition-all duration-200"></i>
            <span class="inline md:hidden md:group-hover:inline text-sm font-heading font-bold whitespace-nowrap">
                {{ __('Meetings') }}
            </span>
        </x-nav-link>

        <x-nav-link :href="route('performance')" :active="request()->routeIs('performance')">
            <i
                class="fa-solid fa-chart-line w-5 text-center mr-3 md:mr-0 md:group-hover:mr-3 transition-all duration-200"></i>
            <span class="inline md:hidden md:group-hover:inline text-sm font-heading font-bold whitespace-nowrap">
                {{ __('Performance') }}
            </span>
        </x-nav-link>
    </div>

    {{-- Footer: Logout --}}
    <div class="relative z-10 px-3 py-4 border-t border-white/10 dark:border-white/5">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center group-hover:justify-start px-4 py-3 rounded-xl text-red-400 hover:text-white hover:bg-red-500/20 dark:hover:bg-red-500/10 transition-all duration-300">
                <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                <span
                    class="inline md:hidden md:group-hover:inline ml-3 text-sm font-heading font-bold whitespace-nowrap">Logout</span>
            </button>
        </form>
    </div>
</nav>
