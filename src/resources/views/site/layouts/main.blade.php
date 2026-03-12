<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Rayen Soft — Software Solutions That Scale' }}</title>
    <meta name="description"
        content="{{ $description ?? 'Rayen Soft builds high-performance web applications, digital platforms, and growth systems for ambitious businesses.' }}">
    <meta name="keywords"
        content="{{ $keywords ?? 'software development Tunisia, digital growth agency, custom web applications, SaaS development, digital transformation Tunisia, Rayen Soft' }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ rtrim(config('app.url'), '/') . request()->getRequestUri() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @if (isset($meta))
        {!! $meta !!}
    @else
        <!-- Open Graph -->
        <meta property="og:title" content="{{ $title ?? 'Rayen Soft — Software Solutions That Scale' }}">
        <meta property="og:description"
            content="{{ $description ?? 'Rayen Soft builds high-performance web applications and digital growth systems for ambitious businesses.' }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ request()->url() }}">
        <meta property="og:image" content="{{ $image ?? asset('assets/fullLogo.png') }}">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $title ?? 'Rayen Soft — Software Solutions That Scale' }}">
        <meta name="twitter:description"
            content="{{ $description ?? 'High-performance web applications and digital growth systems for ambitious businesses.' }}">
        <meta name="twitter:image" content="{{ $image ?? asset('assets/fullLogo.png') }}">
        <meta name="twitter:url" content="{{ request()->url() }}">
        <meta name="twitter:site" content="@RayenSoft">
    @endif

    @if (filled(env('META_PIXEL_ID')))
        <!-- Meta Pixel Code -->
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ env('META_PIXEL_ID') }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ env('META_PIXEL_ID') }}&ev=PageView&noscript=1" /></noscript>
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        as="style">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    </noscript>

    <!-- Styles -->
    @vite(['resources/css/site.css', 'resources/js/site.js'])
    @livewireStyles
</head>

<body class="antialiased bg-darkColor text-gray-200 font-body">
    @if (!request()->is('book'))
        @include('site.layouts.navigation')
    @endif

    <!-- CINEMATIC LOADER -->
    <div id="app-loader">
        <div class="loader-content">
            <h1 class="loader-title">Rayen Soft</h1>
            <p class="loader-slogan">Building Digital Excellence</p>

            <div class="loader-progress">
                <div class="loader-bar"></div>
            </div>
        </div>
    </div>

    <main id="app-content" class="relative">
        {{ $slot }}
    </main>

    @if (!request()->is('book') && !request()->is('/'))
        @include('site.partials._call_to_action')
    @endif

    @livewire('global-notification')
    @livewire('modals.zoom-picture')
    @include('site.partials._footer')

    <script>
        window.loaderProgress = 0;
        window.loaderBar = null;

        document.addEventListener("DOMContentLoaded", () => {
            window.loaderBar = document.querySelector(".loader-bar");
            window.loaderInterval = setInterval(() => {
                if (!window.loaderBar) return;
                window.loaderProgress += Math.random() * 15;
                window.loaderBar.style.width = Math.min(window.loaderProgress, 90) + "%";
            }, 120);
        });
    </script>
    @livewireScripts
</body>
<script>
    window.onload = () => {
        clearInterval(window.loaderInterval);
        if (window.loaderBar) {
            window.loaderBar.style.width = "100%";
        }
        const loader = document.getElementById("app-loader");
        loader.style.opacity = "0";
        loader.style.transition = "opacity .6s ease";
        setTimeout(() => loader.remove(), 600);
    };

    function initializeIntersectionObserver() {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-10');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        });

        document.querySelectorAll('section:not(#contact)').forEach(section => {
            section.classList.add('opacity-0', 'translate-y-10', 'transition-all', 'ease-in-out',
                'duration-1000');
            observer.observe(section);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initializeIntersectionObserver();
    });
</script>

</html>
