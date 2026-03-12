@props(['type' => 'default'])

@php
    $isHero = $type === 'hero';
@endphp

<nav x-data="{ open: false }"
    class="w-screen top-0 left-0 z-30 transition-all duration-300 {{ $isHero ? 'max-w-full relative' : 'fixed bg-darkColor/80 backdrop-blur-xl border-b border-white/5' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-18 py-3">

        {{-- Logo --}}
        <div class="flex items-center">
            <a href="{{ route('welcome') }}" aria-label="Home page link" wire:navigate
                class="group flex items-center gap-3 transition-transform duration-300 hover:scale-[1.02]">
                <x-site.application-logo class="h-10 w-auto" />
                <span class="font-heading font-bold text-white text-lg tracking-tight hidden sm:block">Rayen<span
                        class="text-accentColor">Soft</span></span>
            </a>
        </div>

        {{-- Desktop Navigation --}}
        <div class="hidden xl:flex xl:items-center xl:gap-1">
            @foreach (['welcome' => __('navigation.home'), 'about' => __('navigation.about'), 'portfolio' => __('navigation.portfolio'), 'services' => __('navigation.services'), 'contact' => __('navigation.contact'), 'blog' => __('navigation.blog')] as $route => $label)
                <x-site.nav-link :href="route($route)" :active="request()->routeIs($route)"
                    class="relative px-4 py-2 text-sm text-gray-400 hover:text-white font-medium transition-all duration-300 group">
                    {{ $label }}
                </x-site.nav-link>
            @endforeach

            {{-- CTA Button --}}
            <div class="ml-6 pl-6 border-l border-white/10">
                <x-site.primary-button route="book">
                    <span class="flex items-center gap-2">
                        {{ __('navigation.booking') }}
                        <i class="fa-solid fa-arrow-right text-xs opacity-80"></i>
                    </span>
                </x-site.primary-button>
            </div>
        </div>

        {{-- Mobile Hamburger --}}
        <div class="xl:hidden {{ $isHero ? 'hidden' : 'flex items-center' }}">
            <button @click="open = !open" aria-label="Mobile menu toggle button"
                class="relative w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 hover:text-white hover:bg-white/5 focus:outline-none focus:ring-2 focus:ring-primaryColor-light/30 transition-all duration-300">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu Overlay --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 xl:hidden bg-darkColor/95 backdrop-blur-xl">

        {{-- Menu Panel --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 bottom-0 w-full min-h-screen max-w-sm bg-surface border-l border-white/5">

            <div class="relative flex flex-col h-full">
                {{-- Header --}}
                <div class="flex items-center justify-between p-5 border-b border-white/5">
                    <a href="{{ route('welcome') }}" wire:navigate class="flex items-center gap-3">
                        <x-site.application-logo class="h-9 w-auto" />
                        <span class="font-heading font-bold text-white">Rayen<span
                                class="text-accentColor">Soft</span></span>
                    </a>
                    <button @click="open = false"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 text-gray-400 hover:bg-red-500/10 hover:text-red-400 transition-all duration-300"
                        aria-label="Close menu">
                        <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Navigation Links --}}
                <div class="flex-1 overflow-y-auto py-6 px-5">
                    <div class="space-y-1">
                        @foreach (['welcome' => 'Home', 'about' => 'About', 'portfolio' => 'Portfolio', 'services' => 'Services', 'contact' => 'Contact', 'blog' => 'Blog'] as $route => $label)
                            <x-site.responsive-nav-link :href="route($route)" :active="request()->routeIs($route)">
                                {{ $label }}
                            </x-site.responsive-nav-link>
                        @endforeach
                    </div>
                </div>

                {{-- Footer CTA --}}
                <div class="p-5 border-t border-white/5">
                    <x-site.primary-button route="book" class="w-full justify-center">
                        <span class="flex items-center gap-2">
                            Book Free Discovery Session
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </span>
                    </x-site.primary-button>

                    <div class="flex items-center justify-center gap-4 mt-5 pt-5 border-t border-white/5">
                        <span class="text-xs text-gray-600 uppercase tracking-wider">Follow Us</span>
                        <div class="flex gap-3">
                            <a href="https://www.facebook.com/profile.php?id=61564855903994" target="_blank"
                                class="w-8 h-8 flex items-center justify-center rounded-full bg-white/5 text-gray-500 hover:text-primaryColor-light hover:bg-primaryColor-light/10 transition-all duration-300">
                                <i class="fa-brands fa-facebook text-sm"></i>
                            </a>
                            <a href="https://www.instagram.com/rayensoft.solutions.agency" target="_blank"
                                class="w-8 h-8 flex items-center justify-center rounded-full bg-white/5 text-gray-500 hover:text-accentColor hover:bg-accentColor/10 transition-all duration-300">
                                <i class="fa-brands fa-instagram text-sm"></i>
                            </a>
                            <a href="https://www.linkedin.com/company/rayensoft-solutions/" target="_blank"
                                class="w-8 h-8 flex items-center justify-center rounded-full bg-white/5 text-gray-500 hover:text-primaryColor-light hover:bg-primaryColor-light/10 transition-all duration-300">
                                <i class="fa-brands fa-linkedin-in text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
