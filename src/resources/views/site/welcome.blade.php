@php
    $org = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Rayen Soft',
        'url' => url('/'),
        'logo' => asset('assets/fullLogo.png'),
        'description' =>
            'Rayen Soft builds high-performance web applications and software solutions for ambitious businesses.',
        'email' => 'contact@rayensoftsolution.com',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Immeuble Hadidane, Rue Ali Belhouane',
            'postalCode' => '8000',
            'addressLocality' => 'Nabeul',
            'addressCountry' => 'TN',
        ],
        'sameAs' => [
            'https://www.instagram.com/rayensoft.solutions.agency',
            'https://www.linkedin.com/company/rayensoft-solutions',
            'https://www.facebook.com/rayensoft.solutions.agency',
        ],
    ];

    $website = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'Rayen Soft',
        'url' => url('/'),
    ];
@endphp

<x-site.main-layout>
    <x-slot:meta>
        <meta property="og:title" content="{{ $title ?? 'Rayen Soft — Software Solutions That Scale' }}">
        <meta property="og:description"
            content="{{ $description ?? 'We build high-performance web applications and digital growth systems for ambitious businesses.' }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ request()->url() }}">
        <meta property="og:image" content="{{ $image ?? asset('assets/fullLogo.png') }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $title ?? 'Rayen Soft — Software Solutions That Scale' }}">
        <meta name="twitter:description"
            content="{{ $description ?? 'High-performance web applications and digital growth systems for ambitious businesses.' }}">
        <meta name="twitter:image" content="{{ $image ?? asset('assets/fullLogo.png') }}">
        <meta name="twitter:url" content="{{ request()->url() }}">
        <meta name="twitter:site" content="@RayenSoft">

        <script type="application/ld+json">
            {!! json_encode($org, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
        </script>
        <script type="application/ld+json">
            {!! json_encode($website, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
        </script>
    </x-slot:meta>

    {{-- HERO --}}
    @include('site.partials._hero')

    {{-- INTRODUCTION / ABOUT --}}
    @include('site.partials.index.introduction')

    {{-- REVIEWS --}}
    <section class="relative py-24 overflow-hidden"
        style="background: linear-gradient(180deg, #0D1B2A 0%, #0B0F19 100%);">
        {{-- Ambient Glows --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute w-[500px] h-[500px] bg-primaryColor-light/8 blur-[140px] bottom-0 left-10"></div>
            <div class="absolute w-[400px] h-[400px] bg-accentColor/5 blur-[120px] top-20 right-10"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <h2 class="text-center text-3xl lg:text-5xl font-extrabold font-heading text-white mb-16">
                @lang('index/reviews.title')
            </h2>

            <div class="w-full max-w-6xl mx-auto">
                @include('site.partials.index/_reviews')
            </div>

            <div class="mt-14 flex items-center justify-center">
                <x-site.primary-button route="book">
                    @lang('index/reviews.CTA') <i class="fa-solid fa-caret-right ml-2"></i>
                </x-site.primary-button>
            </div>
        </div>
    </section>

    {{-- PORTFOLIO / PROJECTS --}}
    @php
        $projects = [
            [
                'imagePath' => 'assets/projects/jabnouniSchool/jabnouni-school-0.webp',
                'title' => 'Jabnouni School',
                'description' => __('index/projects.jabnouniSchool.description'),
                'route' => 'https://jabnounischool.com/',
            ],
            [
                'imagePath' => 'assets/projects/sneakersWorld/sneakers-world-1.webp',
                'title' => 'Sneakers World UI Design',
                'description' => __('index/projects.sneakersWorld.description'),
                'route' => 'https://www.behance.net/gallery/216801541/Sneaker-World-UI-Desing',
            ],
        ];
    @endphp

    <section id="portfolio" class="relative py-24 section-dark">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 xl:px-20">
            <div class="text-center mb-16">
                <p class="uppercase tracking-[0.25em] text-xs text-accentColor font-semibold mb-3">Our work is</p>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-heading text-white leading-tight">
                    {!! __('index/projects.title') !!}
                </h2>
                <p class="text-gray-400 md:text-lg max-w-3xl mx-auto mt-4">
                    {!! __('index/projects.description') !!}
                </p>
            </div>

            <div class="flex flex-col gap-20">
                @foreach ($projects as $project)
                    <div
                        class="flex flex-col {{ $loop->even ? 'lg:flex-row-reverse' : 'lg:flex-row' }} items-center gap-10 lg:gap-16 group">
                        {{-- Image --}}
                        <div
                            class="w-full lg:w-[60%] relative group-hover:-translate-y-2 transition-transform duration-500">
                            <div
                                class="absolute -inset-4 bg-gradient-to-r from-primaryColor-light/10 to-accentColor/10 rounded-3xl blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10">
                            </div>
                            <div class="relative rounded-2xl overflow-hidden glass-card">
                                <div class="aspect-[16/10] overflow-hidden">
                                    <img src="{{ asset($project['imagePath']) }}" alt="{{ $project['title'] }}"
                                        class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                                </div>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div
                            class="w-full lg:w-[40%] flex flex-col items-center lg:items-start text-center lg:text-left space-y-5">
                            <span
                                class="text-accentColor font-semibold tracking-[0.15em] text-xs uppercase">{{ __('index/projects.featured') }}</span>
                            <h3
                                class="text-2xl font-heading font-bold text-white group-hover:text-accentColor transition-colors duration-300">
                                {{ $project['title'] }}
                            </h3>
                            <p class="text-gray-400 text-base leading-relaxed">
                                {{ $project['description'] }}
                            </p>
                            <x-site.secondary-button route="{{ $project['route'] }}">
                                {{ __('index/projects.prejectCTA') }}
                            </x-site.secondary-button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-16 flex justify-center">
                <x-site.primary-button route="portfolio">
                    {{ __('index/projects.CTA') }} <i class="fa-solid fa-caret-right ml-2"></i>
                </x-site.primary-button>
            </div>
        </div>
    </section>

    {{-- PRICING --}}
    <section id="pricing" class="relative py-24 overflow-hidden"
        style="background: linear-gradient(135deg, #0D2847 0%, #1B4B8A 50%, #0D2847 100%);">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute w-[500px] h-[500px] bg-accentColor/10 blur-[150px] bottom-0 right-0"></div>
        </div>

        {{-- Grid pattern --}}
        <div class="absolute inset-0 pointer-events-none opacity-[0.03]"
            style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 60px 60px;">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <div class="text-center max-w-4xl mx-auto mb-16">
                <h2 class="text-3xl lg:text-4xl font-heading font-extrabold text-white mb-4">
                    Growth Plans Built for Real Results
                </h2>
                <p class="text-blue-200/60 text-base lg:text-lg leading-relaxed">
                    Whether you're a solo expert or a growing digital business, our offers are built to help you attract
                    qualified leads, automate your processes, and scale with confidence.
                </p>
            </div>

            @include('site.partials._plans-showcase')

            <div class="flex justify-center mt-16">
                <x-site.primary-button route="services">
                    Explore Our Plans <i class="fa-solid fa-caret-right ml-2"></i>
                </x-site.primary-button>
            </div>
        </div>
    </section>

    {{-- FINAL CTA --}}
    <section id="contact" class="relative py-24 section-dark">
        <div class="max-w-4xl mx-auto px-6 text-center space-y-6">
            <h2 class="text-2xl md:text-4xl font-heading font-extrabold tracking-tight text-white leading-tight">
                Serious About <span class="gradient-text">Growing Your Business?</span>
            </h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                We partner with service providers and digital businesses that are ready to grow.
                If you're looking for a team that delivers custom web development, and real strategic support — you're
                in the right place.
            </p>
            <p class="text-lg font-semibold gradient-text">
                Let's map out a clear, tailored path to results — together.
            </p>
            <div class="pt-4 flex flex-col items-center gap-3">
                <x-site.primary-button route="book">
                    Book Your Free Discovery Session <i class="fa-solid fa-caret-right ml-1"></i>
                </x-site.primary-button>
                <p class="text-sm text-gray-600 mt-2">Limited slots available each month.</p>
            </div>
        </div>
    </section>

</x-site.main-layout>
