<x-site.main-layout>

    <x-slot:title>
        Services | Rayen Soft — Software Solutions That Scale
    </x-slot:title>

    <section class="relative w-full pt-32 pb-12 section-dark overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-20 left-1/3 w-72 h-72 bg-primaryColor-light/8 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-accentColor/5 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative w-full md:container md:mx-auto flex flex-col items-center my-8 pt-2 px-6">
            <p class="uppercase tracking-[0.25em] text-xs text-accentColor font-semibold mb-4">Your Growth Blueprint</p>
            <h1
                class="text-4xl sm:text-6xl lg:text-7xl text-center font-extrabold font-heading leading-tight text-white">
                The Right <span class="gradient-text">Strategy</span> to Grow
            </h1>
            <p class="text-center text-gray-400 md:text-xl max-w-4xl mt-4">
                From sleek, professional websites to conversion-driven systems, we help coaches, consultants, and
                service providers elevate their brand and attract premium clients.
            </p>
        </div>
    </section>

    @livewire('services-details')

    @include('site.partials._asked_questions')
</x-site.main-layout>
