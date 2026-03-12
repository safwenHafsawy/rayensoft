<x-site.main-layout>
    <x-slot:title>
        Portfolio | Digital Work by Rayen Soft
    </x-slot:title>

    <section class="relative w-full pt-32 pb-12 section-dark overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 right-1/4 w-72 h-72 bg-primaryColor-light/8 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-40 left-1/4 w-80 h-80 bg-accentColor/5 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative w-full md:container md:mx-auto flex flex-col items-center my-8 pt-2 px-6">
            <p class="uppercase tracking-[0.25em] text-xs text-accentColor font-semibold mb-4">Our Work</p>
            <h1
                class="text-3xl sm:text-5xl lg:text-6xl text-center font-extrabold font-heading leading-tight text-white">
                Solutions <span class="gradient-text">That Deliver</span>
            </h1>
            <p class="text-center text-gray-400 md:text-lg max-w-3xl mt-4">
                From sleek websites to conversion-driven systems, we help coaches, consultants, and service providers
                elevate their brand and attract premium clients.
            </p>
        </div>

        @include('site.partials._project_showcase')
    </section>

</x-site.main-layout>
