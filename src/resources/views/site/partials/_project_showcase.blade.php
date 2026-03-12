@php
    $projects = [
        [
            'id' => 0,
            'title' => 'Jabnouni School',
            'description' =>
                'Jabnouni School is a high-performance e-learning platform for Tunisian Economics students. It features a secure vault of video lessons and PDFs, automated online payments for tiered subscriptions, and integrated Google Meet scheduling for live "Elite" sessions—all managed through a centralized teacher dashboard.',
            'imagePaths' => [
                'jabnouni-school-login' => 'assets/projects/jabnouniSchool/jabnouni-school-0.webp',
                'jabnouni-school-home-page' => 'assets/projects/jabnouniSchool/jabnouni-school-1.webp',
                'jabnouni-school-subjects' => 'assets/projects/jabnouniSchool/jabnouni-school-2.webp',
                'jabnouni-school-chapter' => 'assets/projects/jabnouniSchool/jabnouni-school-3.webp',
                'jabnouni-school-course' => 'assets/projects/jabnouniSchool/jabnouni-school-4.webp',
                'jabnouni-school-live-session' => 'assets/projects/jabnouniSchool/jabnouni-school-5.webp',
                'jabnouni-school-offers' => 'assets/projects/jabnouniSchool/jabnouni-school-6.webp',
            ],
            'url' => 'https://www.jabnounischool.com',
        ],
[
            'id' => 1, 
            'title' => 'Bargougui Wear',
            'description' => 
                'Bargougui Wear is a premium luxury streetwear brand based in Finland. The store delivers a high-end shopping experience with a focus on visual storytelling, featuring custom-tailored product galleries, seamless cart transitions, and an editorial-style interface designed for the modern fashion enthusiast.',
            'imagePaths' => [
                'bargougui-hero' => 'assets/projects/bargouguiStore/bargougui-0.webp',
                'bargougui-collections-showcase' => 'assets/projects/bargouguiStore/bargougui-1.webp',
                'bargougui-best-sellers' => 'assets/projects/bargouguiStore/bargougui-2.webp',
                'bargougui-best-product' => 'assets/projects/bargouguiStore/bargougui-3.webp',
                'bargougui-footer' => 'assets/projects/bargouguiStore/bargougui-4.webp',
                'bargougui-collection-list' => 'assets/projects/bargouguiStore/bargougui-5.webp',
                'bargougui-collection-details' => 'assets/projects/bargouguiStore/bargougui-6.webp',
                'bargougui-product-details' => 'assets/projects/bargouguiStore/bargougui-7.webp',
            ],
            'url' => 'https://bargougui-2.myshopify.com/',
        ],
        [
            'id' => 2,
            'title' => 'Happy Shopping Marketplace',
            'description' =>
                'Happy Shopping is an innovative e-commerce platform designed to empower small businesses. It offers a diverse range of products and services, ensuring a seamless and user-friendly experience for both buyers and sellers.',
            'imagePaths' => [
                'happy-shopping-dashboard-overview' => 'assets/projects/happyShopping/happy-shopping-1.webp',
                'happy-shopping-hero' => 'assets/projects/happyShopping/happy-shopping-2.webp',
                'happy-shopping-product-details' => 'assets/projects/happyShopping/happy-shopping-3.webp',
                'happy-shopping-extra-analytics' => 'assets/projects/happyShopping/happy-shopping-4.webp',
                'happy-shopping-special-prices-section' => 'assets/projects/happyShopping/happy-shopping-5.webp',
            ],
            'url' => 'https://oracleapex.com/ords/r/rs_wsp/happy_shopping/home',
        ],
        [
            'id' => 3,
            'title' => 'Swift Cars',
            'description' =>
                'Swift Cars is a comprehensive web application for car enthusiasts. It allows users to browse, book, and manage car rentals with ease, featuring a user-friendly interface for customers and robust tools for administrators.',
            'imagePaths' => [
                'swift-cars-hero' => 'assets/projects/swiftCars/swift-cars-1.webp',
                'swift-cars-cars-listing' => 'assets/projects/swiftCars/swift-cars-2.webp',
                'swift-cars-filtering' => 'assets/projects/swiftCars/swift-cars-3.webp',
            ],
            'url' => 'https://car-dealership-one.vercel.app',
        ],
        [
            'id' => 4,
            'title' => 'Sneakers World UI Design',
            'description' =>
                'Sneakers World is a sophisticated UI design project that aims to create an elegant and stylish interface for a tunisian sneaker shop. The design focuses on aesthetics and user experience.',
            'imagePaths' => [
                'sneakers-world-hero' => 'assets/projects/sneakersWorld/sneakers-world-1.webp',
                'sneakers-world-special-prices-section' => 'assets/projects/sneakersWorld/sneakers-world-2.webp',
                'sneakers-world-product-details' => 'assets/projects/sneakersWorld/sneakers-world-3.webp',
                'sneakers-world-other-home-page-section' => 'assets/projects/sneakersWorld/sneakers-world-4.webp',
            ],
            'url' => 'https://www.behance.net/gallery/216801541/Sneaker-World-UI-Desing',
        ],
        [
            'id' => 5,
            'title' => 'Soft And Loft UI Design',
            'description' =>
                'Soft And Loft is a charming UI design project that captures the essence of the brand\'s cuteness. The design emphasizes a playful and inviting user interface.',
            'imagePaths' => [
                'soft-and-loft-hero' => 'assets/projects/softAndLoft/soft-and-loft-1.webp',
                'soft-and-loft-about-section' => 'assets/projects/softAndLoft/soft-and-loft-2.webp',
                'soft-and-loft-products-section' => 'assets/projects/softAndLoft/soft-and-loft-3.webp',
                'soft-and-loft-avis-clients' => 'assets/projects/softAndLoft/soft-and-loft-4.webp',
            ],
            'url' => 'https://www.behance.net/gallery/216807899/Soft-and-Loft-UI-Design',
        ],
    ];
@endphp

<div x-data="projectShowcase(@js($projects))" aria-label="Projects Showcase" class="relative w-full">
    <div
        class="relative w-full grid grid-cols-1 xl:grid-cols-[40%_1fr] items-center py-20 md:py-28 px-4 md:px-8 lg:px-16 gap-10 xl:gap-16 overflow-hidden">
        {{-- Ambient Background Blobs --}}
        <div class="absolute -top-32 left-1/4 w-96 h-96 bg-primaryColor/8 rounded-full blur-[80px] pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 right-1/3 w-[28rem] h-[28rem] bg-accentColor/6 rounded-full blur-[100px] pointer-events-none">
        </div>
        <div class="absolute top-1/2 -right-20 w-64 h-64 bg-primaryColor/5 rounded-full blur-[60px] pointer-events-none">
        </div>

        {{-- Text Content Section --}}
        <div class="w-full flex flex-col justify-center gap-5 order-2 xl:order-1 relative z-10">
            {{-- Project Counter Badge --}}
            <div class="flex items-center gap-3 mb-2">
                {{-- index starts at 0, display starts at 01 --}}
                <span class="text-primaryColor font-bold text-2xl tabular-nums"
                    x-text="String(index + 1).padStart(2, '0')"></span>

                <span class="w-8 h-[2px] bg-darkColor/20 rounded-full"></span>

                <span class="text-darkColor/40 font-medium text-sm tracking-wide"
                    x-text="String(projects.length).padStart(2, '0') + ' Projects'"></span>
            </div>

            {{-- Title --}}
            <h3 class="text-3xl lg:text-4xl font-heading font-black tracking-tight leading-tight"
                x-text="current.title"></h3>

            {{-- Description --}}
            <p class=" text-base md:text-lg leading-relaxed max-w-lg" x-text="current.description"></p>

            {{-- CTA Button --}}
            <div class="w-fit mt-4">
                <a :href="current.url" target="_blank" rel="noopener"
                    class="group inline-flex items-center gap-2 rounded-lg px-2 py-1 -mx-2
                        font-body text-primaryColor-darker no-underline
                        transition-colors duration-300 ease-out
                        hover:text-accentColor
                        focus:outline-none focus:ring-2 focus:ring-inset focus:ring-accentColor/40">
                    <span class="relative">
                        View Live Project
                        <span
                            class="pointer-events-none absolute left-0 -bottom-0.5 h-px w-full origin-left scale-x-0
                            bg-accentColor transition-transform duration-300 ease-out group-hover:scale-x-100"></span>
                    </span>
                    <i
                        class="fa-solid fa-arrow-up-right-from-square text-xs opacity-70
                            transition duration-300 ease-out
                            group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-100"></i>
                </a>
            </div>

            {{-- Navigation Controls --}}
            <div
                class="flex items-center justify-center xl:justify-start gap-4 mt-10 pt-6 border-t border-darkColor/10">
                {{-- Prev --}}
                <button type="button" @click="prev()"
                    class="w-12 h-12 flex items-center justify-center rounded-full bg-lightColor border border-gray-200 text-primaryColor shadow-sm hover:bg-primaryColor hover:text-white hover:border-primaryColor transition-all duration-300"
                    aria-label="Previous Project">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </button>

                {{-- Pagination Dots --}}
                <div class="flex items-center gap-2 px-3">
                    <template x-for="(project, i) in projects" :key="project.id">
                        <button type="button" @click="goTo(i)"
                            class="rounded-full transition-all duration-400 ease-out"
                            :class="i === index ? 'w-7 h-2.5 bg-primaryColor' : 'w-2.5 h-2.5 bg-gray-300 hover:bg-gray-400'"
                            :aria-label="'Go to Project ' + (i + 1)"></button>
                    </template>
                </div>

                {{-- Next --}}
                <button type="button" @click="next()"
                    class="w-12 h-12 flex items-center justify-center rounded-full bg-white border border-gray-200 text-primaryColor shadow-sm hover:bg-primaryColor hover:text-white hover:border-primaryColor transition-all duration-300"
                    aria-label="Next Project">
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </div>
        </div>

        {{-- Image Section --}}
        <div class="relative w-full order-1 xl:order-2 group">
            {{-- Decorative Frame --}}
            <div
                class="absolute -inset-3 bg-gradient-to-br from-primaryColor/10 via-transparent to-accentColor/10 rounded-2xl -z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            </div>

            {{-- Main Image Container --}}
            <div
                class="relative h-72 sm:h-[45vh] xl:h-[70vh] w-full flex items-center justify-center bg-gradient-to-br from-gray-50 to-primaryColor-lighter/30 rounded-2xl overflow-hidden shadow-xl shadow-darkColor/5 border border-white/50">
                {{-- Subtle Corner Accent --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-primaryColor/5 rounded-bl-full"></div>
                <img id="mainProjectImage" :src="getMainImageSrc()"
                    :alt="currentAltTexts[activeImageIndex] || current.title"
                    class="h-full w-full object-contain p-4 cursor-zoom-in transition-transform duration-500 group-hover:scale-[1.02]"
                    @click="openZoom()" />
            </div>

            {{-- Thumbnails --}}
            <div
                class="mt-5 flex gap-3 overflow-x-auto pb-2 justify-start xl:justify-center scrollbar-thin scrollbar-thumb-gray-300">
                <template x-for="(imgPath, i) in currentImages" :key="imgPath">
                    <img :src="assetBase + imgPath" :alt="currentAltTexts[i] || ('Project image ' + (i + 1))"
                        class="thumbnail-image flex-shrink-0 w-20 h-14 object-cover rounded-lg border-2 cursor-pointer transition-all duration-300 hover:shadow-lg hover:scale-105"
                        :class="i === activeImageIndex ? 'active border-primaryColor shadow-md' :
                            'border-transparent opacity-60 hover:opacity-100'"
                        @click="setActiveImage(i)" />
                </template>
            </div>
        </div>
    </div>


    <!-- Lightbox / Modal -->
    <template x-teleport="body">
        <div x-show="isZoomOpen" x-cloak class="fixed inset-0 z-[99999] flex items-center justify-center p-2 md:p-6"
            @keydown.escape.window="closeZoom()" @keydown.arrow-left.window="isZoomOpen && zoomPrevImage()"
            @keydown.arrow-right.window="isZoomOpen && zoomNextImage()" style="display: none;">

            <!-- Backdrop with blur -->
            <div x-show="isZoomOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="absolute inset-0 bg-darkColor/90 backdrop-blur-md"
                @click="closeZoom()">
            </div>

            <!-- Panel -->
            <div x-show="isZoomOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="relative z-10 w-full max-w-6xl max-h-[96vh] flex flex-col rounded-2xl md:rounded-3xl overflow-hidden bg-white shadow-[0_0_50px_rgba(0,0,0,0.5)]">

                <!-- Header -->
                <div
                    class="relative flex-shrink-0 flex items-center justify-between px-4 md:px-6 py-3 md:py-4 bg-white border-b border-darkColor/5">
            
                    <div class="flex items-center gap-3 min-w-0 flex-1">
                        <div
                            class="hidden sm:flex w-9 h-9 rounded-lg bg-primaryColor items-center justify-center shadow-md shadow-primaryColor/20">
                            <i class="fa-solid fa-images text-white text-xs"></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm md:text-base font-heading font-bold text-darkColor truncate"
                                x-text="current.title"></h4>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div
                            class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-darkColor/5 border border-darkColor/10">
                            <span class="text-xs font-semibold text-darkColor/70 tabular-nums"
                                x-text="(activeImageIndex + 1) + ' / ' + currentImages.length"></span>
                        </div>
                        <button type="button"
                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-darkColor/5 hover:bg-canceledColor text-darkColor/60 hover:text-white transition-all duration-300"
                            @click="closeZoom()">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Main Content Area (Flexible) -->
                <div class="relative flex-1 overflow-hidden flex items-center justify-center min-h-0">
                    <!-- Main Image -->
                    <img :src="zoomSrc" :alt="zoomAlt || current.title"
                        class="max-w-full max-h-full object-contain p-2 md:p-4 transition-all duration-500"
                        draggable="false" />

                    <!-- Floating Mobile Counter -->
                    <div class="sm:hidden absolute top-4 left-1/2 -translate-x-1/2 px-3 py-1.5 rounded-full bg-darkColor/5 backdrop-blur-sm text-lightColor text-[10px] font-bold"
                        x-text="(activeImageIndex + 1) + ' / ' + currentImages.length">
                    </div>

                    <!-- Nav Arrows -->
                    <button type="button"
                        class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center rounded-full bg-lightColor border border-gray-200 text-primaryColor shadow-sm hover:bg-primaryColor hover:text-white hover:border-primaryColor transition-all duration-300"
                        @click="zoomPrevImage()">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <button type="button"
                        class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center rounded-full bg-lightColor border border-gray-200 text-primaryColor shadow-sm hover:bg-primaryColor hover:text-white hover:border-primaryColor transition-all duration-300"
                        @click="zoomNextImage()">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Footer / Thumbnails -->
                <div class="flex-shrink-0 backdrop-blur-md border-t border-darkColor/5 p-3 md:p-4">
                    <div class="flex gap-2 overflow-x-auto pb-2 justify-start md:justify-center scrollbar-thin">
                        <template x-for="(imgPath, i) in currentImages" :key="imgPath">
                            <button type="button"
                                class="relative flex-shrink-0 w-14 h-14 md:w-20 md:h-14 overflow-hidden transition-all duration-300"
                                :class="i === activeImageIndex ? 'ring-2 ring-primaryColor ring-offset-2' :
                                    'opacity-40 hover:opacity-100'"
                                @click="activeImageIndex = i; openZoom()">
                                <img :src="assetBase + imgPath" class="w-full h-full object-cover" />
                            </button>
                        </template>
                    </div>

                    <!-- Keyboard Hints -->
                    <div
                        class="hidden lg:flex items-center justify-center gap-4 mt-2 text-[10px] text-darkColor/30 font-medium tracking-wider uppercase">
                        <span>← → Navigate</span>
                        <span class="w-1 h-1 rounded-full bg-darkColor/10"></span>
                        <span>ESC Close</span>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>


<script>
    /**
     * projectShowcase(projects)
     * Manual-only project carousel with thumbnails.
     */
    function projectShowcase(projects) {
        return {

            projects: Array.isArray(projects) ? projects : [],
            index: 0,
            activeImageIndex: 0,

            // Modal state
            isZoomOpen: false,
            zoomSrc: '',
            zoomAlt: '',

            /**
             * Base path prefix for your asset() URLs.
             * We inject it once from Blade so Alpine can build full URLs for images.
             */
            assetBase: "{{ rtrim(asset(''), '/') }}/",

            /**
             * Safe getter for main image source
             */
            getMainImageSrc() {
                const images = this.currentImages;
                const index = this.activeImageIndex;
                if (images && images[index]) {
                    return this.assetBase + images[index];
                }
                // Return empty string to avoid "undefined" 404s
                return '';
            },

            /**
             * current (computed getter)
             * Returns the active project object derived from index.
             */
            get current() {
                return this.projects[this.index] || {
                    id: 0,
                    title: '',
                    description: '',
                    imagePaths: {},
                    url: ''
                };
            },

            /**
             * currentImages (computed)
             * Returns an array of image paths from current.imagePaths (values).
             * Example: ['assets/projects/.../1.webp', '...']
             */
            get currentImages() {
                const project = this.projects[this.index];
                const paths = project?.imagePaths || {};
                return Object.values(paths);
            },

            /**
             * currentAltTexts (computed)
             * Returns an array of alt texts (keys) aligned with currentImages.
             */
            get currentAltTexts() {
                const project = this.projects[this.index];
                const paths = project?.imagePaths || {};
                return Object.keys(paths);
            },

            /**
             * setActiveImage(i)
             * Selects which image to show in the main preview.
             */
            setActiveImage(i) {
                if (i < 0 || i >= this.currentImages.length) return;
                this.activeImageIndex = i;
            },

            /**
             * next()
             * Goes to the next project and resets thumbnail selection to first image.
             */
            next() {
                if (!this.projects.length) return;
                this.index = (this.index + 1) % this.projects.length;
                this.activeImageIndex = 0;
            },

            /**
             * prev()
             * Goes to the previous project and resets thumbnail selection to first image.
             */
            prev() {
                if (!this.projects.length) return;
                this.index = (this.index - 1 + this.projects.length) % this.projects.length;
                this.activeImageIndex = 0;
            },

            /**
             * goTo(i)
             * Jumps to a specific project index and resets thumbnail selection.
             */
            goTo(i) {
                if (i < 0 || i >= this.projects.length) return;
                this.index = i;
                this.activeImageIndex = 0;
            },

            openZoom() {
                const path = this.currentImages[this.activeImageIndex];
                if (!path) return;

                this.zoomSrc = this.assetBase + path;
                this.zoomAlt = this.currentAltTexts[this.activeImageIndex] || '';
                this.isZoomOpen = true;

                // Optional: prevent background scroll while modal open
                document.documentElement.style.overflow = 'hidden';
            },

            closeZoom() {
                this.isZoomOpen = false;

                // Optional: restore scroll
                document.documentElement.style.overflow = '';
            },

            zoomNextImage() {
                if (!this.currentImages.length) return;
                this.activeImageIndex = (this.activeImageIndex + 1) % this.currentImages.length;
                this.openZoom(); // refresh zoomSrc/zoomAlt
            },

            zoomPrevImage() {
                if (!this.currentImages.length) return;
                this.activeImageIndex = (this.activeImageIndex - 1 + this.currentImages.length) % this.currentImages
                    .length;
                this.openZoom(); // refresh zoomSrc/zoomAlt
            },
        };
    }
</script>
