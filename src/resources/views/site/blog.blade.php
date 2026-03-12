@php
    $blogSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Blog',
        'name' => 'Rayen Soft Blog',
        'url' => url()->current(),
    ];
@endphp

<x-site.main-layout>
    <x-slot:title>
        Rayen Soft Blog | Web, SEO & Digital Growth in Tunisia
    </x-slot>

    <x-slot:description>Discover expert tips on web development and Design, SEO, automation, and conversion strategies
        built to grow your business online.</x-slot:description>

    <x-slot:keywords>web development blog, web design tips, SEO insights, automation strategies, online business
        growth, Rayen Soft blog</x-slot:keywords>

    <x-slot:meta>
        <meta property="og:title" content="{{ $title ?? 'Blog | Rayen Soft - Web Agency Tunisia' }}">
        <meta property="og:description"
            content="{{ $description ?? 'Discover expert tips on web development and Design, SEO, automation, and conversion strategies built to grow your business online..' }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ request()->url() }}">
        <meta property="og:image" content="{{ $image ?? asset('assets/fullLogo.png') }}">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $title ?? 'Blog | Rayen Soft - Web Agency Tunisia' }}">
        <meta name="twitter:description"
            content="{{ $description ?? 'Discover expert tips on web development and Design, SEO, automation, and conversion strategies built to grow your business online.' }}">
        <meta name="twitter:image" content="{{ $image ?? asset('assets/fullLogo.png') }}">
        <meta name="twitter:url" content="{{ request()->url() }}">
        <meta name="twitter:site" content="@Rayen Soft">

        <script type="application/ld+json">
            {!! json_encode($blogSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
        </script>
    </x-slot:meta>

    <section class="relative w-full section-dark overflow-hidden px-6 py-24 pt-32">
        <div
            class="absolute top-20 right-1/4 w-72 h-72 bg-primaryColor-light/8 rounded-full blur-[120px] pointer-events-none">
        </div>
        <div
            class="absolute bottom-40 left-1/4 w-80 h-80 bg-accentColor/5 rounded-full blur-[120px] pointer-events-none">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto flex flex-col items-center text-center">
            <p class="text-xs uppercase tracking-[0.25em] text-accentColor font-semibold mb-4">Our Blog</p>
            <h1
                class="text-3xl sm:text-5xl lg:text-6xl text-center font-extrabold font-heading leading-tight text-white">
                Bold Insights. <span class="gradient-text">Real Growth.</span>
            </h1>
            <p class="text-gray-400 max-w-2xl mt-4">
                Discover actionable strategies, design thinking, and web growth insights straight from our creative
                team.
            </p>
        </div>
        <div class="w-full my-8">
            {{-- Article --}}
            <div class="relative z-10 max-w-7xl mx-auto mt-20 flex flex-col xl:flex-row items-center gap-10">
                <!-- Image Area -->
                <div
                    class="relative w-full md:w-1/2 group overflow-hidden rounded-3xl shadow-2xl transition-transform duration-500">
                    <img id="article-image" src="{{ $articles[$currentArticleIndex]['image'] }}"
                        alt="{{ $articles[$currentArticleIndex]['title'] }}"
                        class="w-full h-auto object-cover scale-100 group-hover:scale-105 transition-all duration-700" />
                </div>
                <div class="w-full md:w-3/4 xl:w-1/2 flex flex-col justify-between items-start text-left gap-1">
                    <h2 id="article-title"
                        class="text-xl md:text-2xl font-heading font-extrabold text-white tracking-tight">
                        {{ $articles[$currentArticleIndex]['title'] }}
                    </h2>
                    <p id="article-content" class="text-gray-400 leading-relaxed mb-8 text-base md:text-lg">
                        {!! $articles[$currentArticleIndex]['preview'] !!}
                    </p>

                    <x-site.secondary-button id="readMoreBtn"
                        route="{{ route('blog.singleArticle', $articles[$currentArticleIndex]['slug']) }}">
                        Continue Reading
                    </x-site.secondary-button>

                </div>
            </div>
        </div>

        <!-- Navigation Controls -->
        <div class="flex items-center justify-center w-full mt-10">
            <div class="flex items-center justify-evenly gap-12">
                <button id="prev-article"
                    class="w-10 h-10 flex items-center justify-center rounded-full glass-card text-gray-400 hover:text-white hover:bg-white/10 transition-all duration-300 transform hover:scale-[1.05]"
                    aria-label="Previous Project">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <div class="flex gap-2">
                    @foreach ($articles as $index => $article)
                        <span
                            class="project-indicator w-2.5 h-2.5 rounded-full cursor-pointer transition-all duration-300 {{ $index === $currentArticleIndex ? 'bg-accentColor scale-125' : 'bg-white/10' }}"
                            data-index="{{ $index }}"></span>
                    @endforeach
                </div>

                <button id="next-article"
                    class="w-10 h-10 flex items-center justify-center rounded-full glass-card text-gray-400 hover:text-white hover:bg-white/10 transition-all duration-300 transform hover:scale-[1.05]"
                    aria-label="Next article">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>

        </div>
    </section>


    <script>
        // Track the current article index
        let currentArticleIndex = 0;

        // Select all indicator elements for the articles
        const indicators = document.querySelectorAll('.project-indicator');

        // Function to update the visual state of the indicators
        function updateIndicators() {
            // Reset all indicators to the default color
            indicators.forEach((indicator) => {
                indicator.classList.remove('bg-accentColor', 'scale-125');
                indicator.classList.add('bg-white/10');
            });

            // If index is out of bounds, reset to 0
            if (currentArticleIndex === indicators.length) {
                currentArticleIndex = 0;
            }
            // Highlight the active indicator
            const activeIndicator = document.querySelector(`.project-indicator[data-index="${currentArticleIndex}"]`);
            if (activeIndicator) {
                activeIndicator.classList.remove('bg-white/10');
                activeIndicator.classList.add('bg-accentColor', 'scale-125');
            }
        }

        // On page load, set the initial article content based on screen size
        document.addEventListener('DOMContentLoaded', function() {
            let $articles = @json($articles);
            let $currentArticleIndex = @json($currentArticleIndex);

            // Show mobile or desktop preview depending on screen width
            if (window.innerWidth < 640) {
                document.getElementById('article-content').textContent = $articles[$currentArticleIndex]
                    .mobile_preview;
            } else {
                document.getElementById('article-content').textContent = $articles[$currentArticleIndex].preview;
            }
        });

        // Handle "Next Article" button click
        document.getElementById('next-article').addEventListener('click', function() {
            // Fetch the next article data from the server
            fetch(`blog/next-article/${currentArticleIndex}`)
                .then(response => response.json())
                .then(data => {
                    // Update the article title and image
                    document.getElementById('article-title').textContent = data.article.title;
                    document.getElementById('article-image').src = data.article.image;

                    // Show mobile or desktop preview depending on screen width
                    if (window.innerWidth < 640) {
                        document.getElementById('article-content').textContent = data.article.mobile_preview;
                    } else {
                        document.getElementById('article-content').textContent = data.article.preview;
                    }

                    // Update the current article index
                    currentArticleIndex = data.index;

                    // Update "Continue reading" link dynamically
                    const readMoreBtn = document.getElementById("readMoreBtn");
                    if (readMoreBtn) {
                        readMoreBtn.setAttribute('href', `/blog/${data.article.slug}`);
                    }

                    // Update the indicators to reflect the new active article
                    updateIndicators();
                })
                .catch(error => console.error('Error fetching article:', error));
        });

        // Handle "Previous Article" button click
        document.getElementById('prev-article').addEventListener('click', function() {
            // Fetch the previous article data from the server
            fetch(`blog/prev-article/${currentArticleIndex}`)
                .then(response => response.json())
                .then(data => {
                    // Update the article title and image
                    document.getElementById('article-title').textContent = data.article.title;
                    document.getElementById('article-image').src = data.article.image;

                    // Show mobile or desktop preview depending on screen width
                    if (window.innerWidth < 640) {
                        document.getElementById('article-content').textContent = data.article.mobile_preview;
                    } else {
                        document.getElementById('article-content').textContent = data.article.preview;
                    }

                    // Update the current article index
                    currentArticleIndex = data.index;
                    const readMoreBtn = document.getElementById("readMoreBtn");
                    if (readMoreBtn) {
                        readMoreBtn.setAttribute('href', `/blog/${data.article.slug}`);
                    }

                    // Update the indicators to reflect the new active article
                    updateIndicators();
                })
                .catch(error => console.error('Error fetching article:', error));
        });
    </script>
</x-site.main-layout>
