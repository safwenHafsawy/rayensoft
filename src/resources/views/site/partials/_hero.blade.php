<section class="relative min-h-screen flex flex-col overflow-hidden noise-overlay"
    style="background: linear-gradient(180deg, #0B0F19 0%, #0D1B2A 40%, #0B0F19 100%);">

    <!-- MESH GRADIENT ORBS -->
    <div class="absolute inset-0 pointer-events-none">
        <div
            class="absolute w-[600px] h-[600px] bg-primaryColor-light/10 rounded-full blur-[150px] -top-40 -left-20 animate-float">
        </div>
        <div
            class="absolute w-[500px] h-[500px] bg-accentColor/8 rounded-full blur-[120px] top-1/3 right-0 animate-float-delayed">
        </div>
        <div
            class="absolute w-[400px] h-[400px] bg-secondAccent/5 rounded-full blur-[100px] bottom-20 left-1/3 animate-float">
        </div>
    </div>

    <!-- GRID PATTERN OVERLAY -->
    <div class="absolute inset-0 pointer-events-none opacity-[0.03]"
        style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    <!-- NAVIGATION -->
    <nav class="relative z-30 w-full px-6 md:px-12 lg:px-20 py-6">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            {{-- Logo --}}
            <a href="{{ route('welcome') }}" class="group flex items-center gap-3" wire:navigate>
                <x-site.application-logo class="h-10 w-auto" />
                <span class="font-heading font-bold text-white text-lg tracking-tight hidden sm:block">Rayen<span
                        class="text-accentColor">Soft</span></span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden lg:flex items-center gap-1">
                @foreach (['welcome' => __('navigation.home'), 'about' => __('navigation.about'), 'portfolio' => __('navigation.portfolio'), 'services' => __('navigation.services'), 'contact' => __('navigation.contact'), 'blog' => __('navigation.blog')] as $route => $label)
                    <a href="{{ route($route) }}"
                        class="relative px-4 py-2 text-sm text-gray-400 hover:text-white font-medium transition-all duration-300 group">
                        {{ $label }}
                        <span
                            class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-[2px] bg-gradient-to-r from-primaryColor-light to-accentColor group-hover:w-3/4 transition-all duration-300"></span>
                    </a>
                @endforeach

                <div class="ml-6 pl-6 border-l border-white/10">
                    <x-site.primary-button route="book">
                        <span class="flex items-center gap-2">
                            {{ __('navigation.booking') }}
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </span>
                    </x-site.primary-button>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN HERO CONTENT -->
    <div class="relative z-20 flex-1 flex items-center">
        <div class="w-full max-w-7xl mx-auto px-6 md:px-12 lg:px-20 py-12 lg:py-0">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                {{-- LEFT COLUMN: Text --}}
                <div class="space-y-8 text-center lg:text-left">
                    {{-- Status Badge --}}
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card animate-fade-in-up">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accentColor opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-accentColor"></span>
                        </span>
                        <span
                            class="text-xs tracking-[0.2em] text-gray-400 uppercase font-medium">{{ __('hero.tag') }}</span>
                    </div>

                    {{-- Headline --}}
                    <h1 class="font-heading font-extrabold text-4xl sm:text-5xl md:text-6xl lg:text-7xl leading-[1.05] tracking-tight animate-fade-in-up delay-200"
                        style="opacity:0">
                        <span class="text-white">We craft</span><br>
                        <span class="gradient-text">digital solutions</span><br>
                        <span class="text-white">that scale.</span>
                    </h1>

                    {{-- Subtitle --}}
                    <p class="text-gray-400 text-lg md:text-xl leading-relaxed max-w-xl mx-auto lg:mx-0 animate-fade-in-up delay-400"
                        style="opacity:0">
                        {{ __('hero.tagline1') }}
                    </p>

                    {{-- CTAs --}}
                    <div class="flex flex-col sm:flex-row items-center lg:items-start gap-4 animate-fade-in-up delay-600"
                        style="opacity:0">
                        <x-site.primary-button route="book">
                            <span class="flex items-center gap-2">
                                {{ __('hero.CTA') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </x-site.primary-button>

                        <a href="#about"
                            class="group flex items-center gap-2 text-gray-400 hover:text-accentColor text-sm tracking-wide transition-all duration-300 px-4 py-3">
                            {{ __('hero.secondary_CTA') }}
                            <svg class="w-4 h-4 transform group-hover:translate-y-1 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- RIGHT COLUMN: Visual Element --}}
                <div class="relative hidden lg:flex items-center justify-center animate-fade-in-up delay-500"
                    style="opacity:0">
                    {{-- Floating Glow Card Stack --}}
                    <div class="relative w-full max-w-lg">
                        {{-- Background glow --}}
                        <div
                            class="absolute -inset-4 bg-gradient-to-r from-primaryColor-light/20 via-accentColor/10 to-primaryColor-light/20 rounded-3xl blur-3xl animate-glow-pulse">
                        </div>

                        {{-- Main card --}}
                        <div class="relative glass-card rounded-3xl p-8 space-y-6">
                            {{-- Terminal header --}}
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                                <span class="ml-3 text-xs text-gray-500 font-mono">rayen-soft.dev</span>
                            </div>

                            {{-- Code lines --}}
                            <div class="space-y-3 font-mono text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-600 select-none">01</span>
                                    <span class="text-primaryColor-light">const</span>
                                    <span class="text-accentColor">project</span>
                                    <span class="text-gray-500">=</span>
                                    <span class="text-secondAccent">{</span>
                                </div>
                                <div class="flex items-center gap-2 pl-6">
                                    <span class="text-gray-600 select-none">02</span>
                                    <span class="text-gray-300">type:</span>
                                    <span class="text-accentColor">'web_app'</span><span class="text-gray-500">,</span>
                                </div>
                                <div class="flex items-center gap-2 pl-6">
                                    <span class="text-gray-600 select-none">03</span>
                                    <span class="text-gray-300">stack:</span>
                                    <span class="text-accentColor">'modern'</span><span class="text-gray-500">,</span>
                                </div>
                                <div class="flex items-center gap-2 pl-6">
                                    <span class="text-gray-600 select-none">04</span>
                                    <span class="text-gray-300">status:</span>
                                    <span class="text-accentColor">'shipped'</span>
                                    <span
                                        class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full bg-accentColor/20 text-accentColor text-xs">✓</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-600 select-none">05</span>
                                    <span class="text-secondAccent">}</span>
                                </div>
                            </div>

                            {{-- Metrics row --}}
                            <div class="grid grid-cols-3 gap-4 pt-4 border-t border-white/5">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-white font-heading">99<span
                                            class="text-accentColor text-sm">%</span></p>
                                    <p class="text-xs text-gray-500 mt-1">Uptime</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-white font-heading">&lt;1<span
                                            class="text-accentColor text-sm">s</span></p>
                                    <p class="text-xs text-gray-500 mt-1">Load Time</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-white font-heading">24<span
                                            class="text-accentColor text-sm">/7</span></p>
                                    <p class="text-xs text-gray-500 mt-1">Support</p>
                                </div>
                            </div>
                        </div>

                        {{-- Floating mini cards --}}
                        <div class="absolute -top-6 -right-6 glass-card rounded-2xl px-4 py-3 animate-float">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-accentColor/20 flex items-center justify-center">
                                    <i class="fa-solid fa-rocket text-accentColor text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-white">Deployed</p>
                                    <p class="text-[10px] text-gray-500">Just now</p>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -bottom-4 -left-6 glass-card rounded-2xl px-4 py-3 animate-float-delayed">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-lg bg-primaryColor-light/20 flex items-center justify-center">
                                    <i class="fa-solid fa-chart-line text-primaryColor-light text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-white">+340%</p>
                                    <p class="text-[10px] text-gray-500">Growth</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TRUST BAR -->
    <div class="relative z-20 w-full max-w-7xl mx-auto px-6 md:px-12 lg:px-20 pb-16 lg:pb-24">
        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6">
            <span class="text-xs tracking-[0.25em] uppercase text-gray-600">{{ __('hero.deliverables') }}</span>
            @foreach ([['icon' => 'fa-code', 'label' => __('hero.deliverables_1')], ['icon' => 'fa-mobile-screen', 'label' => __('hero.deliverables_2')], ['icon' => 'fa-palette', 'label' => __('hero.deliverables_3')], ['icon' => 'fa-chart-line', 'label' => __('hero.deliverables_4')]] as $item)
                <div
                    class="flex items-center gap-2 px-4 py-2 rounded-xl glass-card text-xs text-gray-400 hover:text-white hover:border-primaryColor-light/20 transition-all duration-300">
                    <i class="fa-solid {{ $item['icon'] }} text-accentColor text-[10px]"></i>
                    <span class="tracking-wider uppercase font-medium">{{ $item['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

</section>
