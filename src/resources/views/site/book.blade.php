<x-site.main-layout>

    <x-slot:title>
        Rayen Soft | Book Your Free Discovery Session
    </x-slot:title>

    <div class="min-h-screen section-dark text-gray-200">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 left-0 w-72 h-72 bg-primaryColor-light/8 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-72 right-2/4 w-80 h-80 bg-accentColor/5 rounded-full blur-[120px]"></div>
        </div>

        <!-- Header / Branding -->
        <section class="py-12 px-4 text-center relative z-10">
            <x-site.application-logo class="mx-auto h-16 w-auto" />
            <h1 class="mt-6 text-2xl md:text-3xl font-heading font-extrabold tracking-tight text-white">
                Réservez votre <span class="gradient-text">Séance de Découverte</span> Gratuite
            </h1>
            <p class="text-gray-400 leading-relaxed text-sm md:text-base mt-2">
                Une séance dédiée pour comprendre votre activité, vos objectifs et tracer ensemble la meilleure voie
                pour votre croissance numérique.
            </p>
            <p class="text-gray-500 leading-relaxed text-sm md:text-base mt-2" dir="rtl">
                جلسة مخصصة لفهم نشاطكم، وأهدافكم، ورسم أفضل مسار للنمو الرقمي معًا.
            </p>
        </section>

        <!-- Content Layout -->
        <section class="relative z-10 flex justify-center gap-8 xl:gap-12 px-4 md:px-8 xl:px-24 pb-20">
            <div
                class="flex flex-col justify-center glass-card rounded-3xl px-6 py-10 relative overflow-hidden max-w-3xl w-full">
                <div class="relative z-10 text-center mb-1 space-y-1"></div>
                <div class="relative z-10">
                    @livewire('booking-form')
                </div>
            </div>
        </section>

        <section class="relative z-10 py-14 md:py-20">
            <div class="max-w-2xl mx-auto text-center px-6">
                <p class="text-[11px] tracking-[0.25em] uppercase font-semibold text-gray-500">
                    Avant de réserver
                </p>
                <h4 class="mt-3 text-2xl md:text-3xl font-heading font-semibold text-white leading-tight">
                    Vous hésitez encore ?
                </h4>
                <p class="mt-4 text-sm md:text-base text-gray-400 leading-relaxed">
                    Prenez un moment pour découvrir notre univers, nos réalisations et notre approche.
                    Explorez nos projets récents et voyez comment nous pouvons donner vie à votre vision.
                </p>
                <div class="mt-8 flex justify-center">
                    <x-site.primary-button route="portfolio">
                        Découvrir nos projets <i class="fa-solid fa-arrow-right text-xs opacity-80 ml-2"></i>
                    </x-site.primary-button>
                </div>
            </div>
        </section>
    </div>
</x-site.main-layout>
