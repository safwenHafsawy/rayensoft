    <section id="about" class="relative py-24 overflow-hidden section-dark">
        {{-- Mesh gradient background --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-20 left-1/4 w-80 h-80 bg-accentColor/5 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-0 right-1/3 w-96 h-96 bg-primaryColor-light/8 blur-[140px] rounded-full"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 flex flex-col items-center">
            {{-- Heading --}}
            <div class="max-w-4xl text-center mb-16">
                <p class="uppercase tracking-[0.25em] text-xs text-accentColor font-semibold mb-4">What We Do</p>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-heading font-extrabold tracking-tight text-white mb-6">
                    {{ __('index/introduction.title') }}
                </h2>

                <p class="text-base md:text-lg text-gray-400 leading-relaxed px-2 md:px-8">
                    <span class="font-bold text-accentColor">Rayen Soft</span> {!! __('index/introduction.intro1') !!}
                    {!! __('index/introduction.intro2') !!}
                </p>

                <p class="text-base md:text-lg text-gray-400 leading-relaxed px-2 md:px-8 mt-4">
                    {!! __('index/introduction.description2') !!}
                </p>

                <p class="text-base md:text-lg text-gray-400 leading-relaxed px-2 md:px-8 mt-4">
                    {!! __('index/introduction.description3') !!}
                </p>
            </div>

            {{-- Features Grid --}}
            <div class="w-full">
                <h3 class="text-xl md:text-2xl lg:text-3xl font-heading font-bold text-center text-white mb-10">
                    {{ __('index/introduction.advantage') }}
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 pt-4">
                    <x-site.features-card
                        cardTitle="{{ __('index/introduction.features.scalable-digital-architecture') }}" />
                    <x-site.features-card cardTitle="{{ __('index/introduction.features.seamless-sales-experience') }}" />
                    <x-site.features-card cardTitle="{{ __('index/introduction.features.self-managing-operations') }}" />
                    <x-site.features-card
                        cardTitle="{{ __('index/introduction.features.high-precision-audience-reach') }}" />
                    <x-site.features-card cardTitle="{{ __('index/introduction.features.proactive-growth-management') }}" />
                </div>
            </div>

            {{-- CTA --}}
            <div class="mt-14 flex justify-center">
                <x-site.primary-button route="about" class="px-8 py-4">
                    {{ __('index/introduction.CTA') }} <i class="fa-solid fa-caret-right ml-2"></i>
                </x-site.primary-button>
            </div>
        </div>
    </section>
