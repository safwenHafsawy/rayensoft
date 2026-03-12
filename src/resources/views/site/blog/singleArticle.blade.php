@php
    $blogSchema = [
        "@context"       => "https://schema.org",
        "@type"          => "BlogPosting",

        "mainEntityOfPage" => [
            "@type" => "WebPage",
            "@id"   => url()->current()
        ],

        "headline"       => $article['meta_title'] ?? $article['title'],
        "description"    => $article['meta_description'] ?? Str::limit(strip_tags($article['content']), 160),
        "image"          => asset($article['image']),

        "author" => [
            "@type" => "Organization",
            "name"  => "Rayen Soft",
            "url"   => config('app.url')
        ],

        "publisher" => [
            "@type" => "Organization",
            "name"  => "Rayen Soft",
            "logo"  => [
                "@type" => "ImageObject",
                "url"   => asset('assets/fullLogo.png')
            ]
        ],

        "datePublished" => \Carbon\Carbon::parse($article['published_date'])->toIso8601String(),
        "dateModified"  => \Carbon\Carbon::parse($article['published_date'])->toIso8601String()
    ];
@endphp

<x-site.main-layout>

    <x-slot:title>
        {{ $article['meta_title'] }}
    </x-slot>
    <x-slot:description>{{ $article['meta_description'] }} </x-slot:description>
    <x-slot:meta>
        <!-- Open Graph Meta Tags (Facebook, LinkedIn, WhatsApp) -->
        <meta property="og:title" content="{{ $article['title'] }}">
        <meta property="og:description" content="{{ Str::limit(strip_tags($article['content']), 160) }}">
        <meta property="og:image" content="{{ asset($article['image']) }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="article">
        <meta property="og:site_name" content="Rayen Soft">
        <meta property="article:published_time" content="{{ $article['published_date'] }}">

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $article['title'] }}">
        <meta name="twitter:description" content="{{ Str::limit(strip_tags($article['content']), 160) }}">
        <meta name="twitter:image" content="{{ asset($article['image']) }}">
        <meta name="twitter:site" content="@Rayen SoftSolutions">
        <meta name="twitter:creator" content="@Rayen SoftSolutions">

        <script type="application/ld+json">
            {!! json_encode($blogSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    </x-slot:meta>

    <!-- Breadcrumb -->
    <nav class="mx-auto max-w-7xl px-6 py-4 mt-28 text-sm text-gray-500 font-medium tracking-wide" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2">
            <li><a href="/blog" class="hover:text-primaryColor transition-colors duration-300">Blog</a></li>
            <li><span class="text-gray-300">/</span></li>
            <li class="text-gray-400  truncate max-w-md">{{ $article['slug'] }}</li>
        </ol>
    </nav>

    <article id="article-body" class="mx-auto max-w-5xl px-6 lg:px-0 relative w-full bg-gradient-to-b from-lightColor via-gray-50 to-lightColor overflow-hidden">
        <div class="absolute top-20 right-1/4 w-72 h-72 bg-primaryColor/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-40 left-1/4 w-80 h-80 bg-accentColor/10 rounded-full blur-3xl"></div>
        <!-- Header -->
        <header class="mb-12">
            <h1 class="text-xl lg:text-6xl font-extrabold font-heading text-darkColor leading-tight tracking-tighter mb-4">
                {{ $article['title'] }}
            </h1>
            <div class="flex items-center space-x-4 text-base text-gray-400">
                <span>{{ $article['published_date'] }}</span>
                <span class="inline-block w-1 h-1 bg-darkColor rounded-full"></span>
                <span class="italic">{{ $article['readTime'] }}</span>
            </div>
        </header>

        <!-- Hero Image -->
        <figure class="relative w-full flex items-center justify-center mb-12 overflow-hidden ">
            <img src="{{ asset($article['image']) }}"
                 alt="{{ $article['title'] ?? 'Article illustration' }}"
                 loading="lazy"
                 class="w-full md:w-2/4 h-auto object-cover transition-transform duration-700 ease-out hover:scale-105 rounded-3xl"/>
        </figure>

        <!-- Content -->
        <section class="mt-16">
            <div class="">
                <div class="prose prose-lg prose-invert leading-relaxed max-w-none">
                    {!! $article['content'] !!}
                </div>
            </div>
        </section>
    </article>

    <!-- Next Article Teaser -->
    @if (isset($nextArticle))
        <aside class="lg:px-48 px-4 my-12 flex justify-end" aria-label="Next article">
            <div class="lg:px-40">
                <h2 class="text-sm font-bold text-gray-700 mb-2">Read Next</h2>
                <x-site.secondary-button class="text-xs"
                                    route="{{ route('blog.singleArticle', ['slug' => $nextArticle['slug']]) }}">
                    {{ $nextArticle['title'] }}
                </x-site.secondary-button>
            </div>
        </aside>
    @endif
</x-site.main-layout>
