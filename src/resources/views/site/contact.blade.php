@php
    $contactInformation = [
        ['icon' => 'fa-solid fa-phone', 'title' => '+216 92 179 433', 'meta' => 'Call us'],
        ['icon' => 'fa-solid fa-envelope', 'title' => 'info@rayensoftsolution.com', 'meta' => 'Email support'],
        [
            'icon' => 'fa-solid fa-street-view',
            'title' => 'Immeuble Hadidane, Rue Ali Belhouane, Nabeul, Tunisia',
            'meta' => 'Head office',
        ],
    ];
    $contactSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'Rayen Soft',
        'image' => asset('assets/fullLogo.png'),
        'url' => url('/'),
        'telephone' => '+216 92 179 433',
        'email' => 'info@rayensoftsolution.com',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Immeuble Hadidane, Rue Ali Belhouane',
            'addressLocality' => 'Nabeul',
            'postalCode' => '8000',
            'addressCountry' => 'TN',
        ],
    ];
@endphp

<x-site.main-layout>
    <x-slot:title>
        Contact Rayen Soft — Let's Build Together
    </x-slot:title>

    <x-slot:meta>
        <meta property="og:title" content="{{ $title ?? 'Contact Us | Rayen Soft' }}">
        <meta property="og:description"
            content="{{ $description ?? 'Need a new website or digital growth system? Reach out to Rayen Soft today.' }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ request()->url() }}">
        <meta property="og:image" content="{{ $image ?? asset('assets/fullLogo.png') }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $title ?? 'Contact Us | Rayen Soft' }}">
        <meta name="twitter:description"
            content="{{ $description ?? 'Need a new website or digital growth system? Reach out to Rayen Soft today.' }}">
        <meta name="twitter:image" content="{{ $image ?? asset('assets/fullLogo.png') }}">
        <meta name="twitter:url" content="{{ request()->url() }}">
        <meta name="twitter:site" content="@RayenSoft">
        <script type="application/ld+json">
            {!! json_encode($contactSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
        </script>
    </x-slot:meta>

    <section class="relative pt-32 pb-16 section-dark overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute bottom-40 left-1/4 w-80 h-80 bg-accentColor/5 rounded-full blur-[120px]"></div>
            <div class="absolute top-0 right-40 w-80 h-80 bg-primaryColor-light/8 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 md:px-12 xl:px-24">
            <div class="grid grid-cols-1 lg:grid-cols-[42%_1fr] gap-16 items-start">
                {{-- Left: text + contact cards --}}
                <div class="flex flex-col justify-start items-start gap-6">
                    <p class="uppercase tracking-[0.25em] text-xs text-accentColor font-semibold">Reach Out</p>
                    <h2 class="text-3xl xl:text-4xl 2xl:text-5xl font-extrabold font-heading leading-tight text-white">
                        Get in <span class="gradient-text">Touch</span>
                    </h2>

                    <p class="text-gray-400 text-lg leading-relaxed max-w-prose">
                        Do you have a project or a question? We'd love to hear from you.
                        Send us a message and we'll get back within one business day.
                    </p>

                    <div class="mt-2 w-full grid gap-3">
                        @foreach ($contactInformation as $info)
                            <address class="not-italic">
                                <div
                                    class="flex items-center gap-4 p-4 rounded-xl glass-card glass-card-hover transition-all duration-300 hover:-translate-y-0.5">
                                    <span
                                        class="flex items-center justify-center w-11 h-11 rounded-lg bg-primaryColor-light/10 text-primaryColor-light text-lg shrink-0">
                                        <i class="{{ $info['icon'] }}" aria-hidden="true"></i>
                                    </span>
                                    <div class="min-w-0">
                                        <h4 class="text-sm font-medium text-white truncate">{{ $info['title'] }}</h4>
                                        @if (!empty($info['meta']))
                                            <p class="mt-1 text-xs text-gray-500">{{ $info['meta'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </address>
                        @endforeach
                    </div>
                </div>

                {{-- Right: contact form --}}
                <div class="w-full">
                    @livewire('contact-form')
                </div>
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="relative w-full section-dark py-4">
        <div class="flex justify-center items-center">
            <div class="w-1/2 border-t border-white/5"></div>
        </div>
        <div class="relative flex justify-center text-sm -mt-3">
            <span class="px-4 bg-surface text-gray-600 font-medium">Or</span>
        </div>
    </div>

    {{-- Office Section --}}
    <section class="relative px-6 md:px-12 xl:px-24 pb-12 pt-12 section-dark overflow-hidden">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-3xl font-heading font-semibold text-white mb-3">Visit Our Office</h2>
            <p class="text-gray-400 text-lg mb-10">
                We're located in the heart of Nabeul — drop by or find us easily on the map below.
            </p>
            <div class="rounded-2xl overflow-hidden glass-card">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3209.1602832606695!2d10.7414287!3d36.45368260000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x130299754df418d5%3A0x77f27d94b57e71e!2sRayen Soft%20Solutions%20Agency!5e0!3m2!1sen!2stn!4v1751367190376!5m2!1sen!2stn"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
</x-site.main-layout>
