@php
    $feedbacks = [
        [
            'id' => 0,
            'company' => 'Jabnouni School',
            'name' => 'Amir Jabnouni',
            'position' => 'Founder',
            'comment' =>
                'Une bonne société de création des sites web, se distinguant par son professionnalisme, son écoute et la qualité de son travail. Une équipe sérieuse, réactive et attentive aux besoins, offrant une expérience globalement très satisfaisante.',
            'logo' => 'jabnounischool.webp',
        ],
        [
            'id' => 1,
            'company' => 'Bargougui Wear',
            'name' => 'Bcm Bargougui',
            'position' => 'Founder',
            'comment' => '
                Working with this team was a game-changer. They guided me through building my store with professionalism, creativity, and expertise. What felt overwhelming became a smooth, exciting process, and they brought my vision to life even better than I imagined. I highly recommend them for a high-quality online store.',
            'logo' => 'bargouguiewear.webp',
        ],
        [
            'id' => 2,
            'company' => 'DBA Collection',
            'name' => 'Dhouha Ben Abdallah',
            'position' => 'Founder',
            'comment' =>
                'Je suis vraiment ravie du résultat. C’était un vrai plaisir de voir les performances monter en puissance tout au long de la campagne. Je me suis sentie vraiment épaulée.',
            'logo' => 'dbacollection.webp',
        ],
        [
            'id' => 3,
            'company' => 'Soft and Loft',
            'name' => 'Fatma Maatoug',
            'position' => 'Founder',
            'comment' =>
                'Le concept de page d’accueil que vous proposez me plaît énormément et reflète parfaitement la vision et les objectifs de ma marque.',
            'logo' => 'softandloft.webp',
        ],
    ];
@endphp

<div x-data="feedbackSlider({{ json_encode($feedbacks) }}, 5500)" @mouseenter="stop()" @mouseleave="start()" aria-label="Customer Reviews" class="relative">
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -left-8 top-10 h-44 w-44 rounded-full bg-accentColor/10 blur-3xl"></div>
        <div class="absolute -right-6 bottom-4 h-52 w-52 rounded-full bg-primaryColor-light/10 blur-3xl"></div>
    </div>

    <div class="relative mt-12 flex flex-col items-center gap-7 md:flex-row md:justify-between md:gap-10">
        <button @click="prev()"
            class="group hidden h-14 w-14 items-center justify-center rounded-full border border-lightColor/20 bg-white/10 text-lightColor/80 shadow-sm shadow-darkColor/5 backdrop-blur-sm transition-all duration-300 hover:-translate-x-1 hover:border-accentColor hover:bg-accentColor/20 hover:text-lightColor md:flex"
            aria-label="Previous review">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </button>

        <div class="relative w-full overflow-hidden">
            <div class="relative grid min-h-[600px] place-items-center md:min-h-[400px]">
                <template x-for="(feedback, i) in feedbacks" :key="feedback.id">
                    <article x-show="index === i" class="w-full flex justify-center px-2"
                        x-transition:enter="transition transform-gpu ease-[cubic-bezier(0.22,1,0.36,1)] duration-700"
                        x-transition:enter-start="opacity-0 translate-y-3 scale-[0.985] blur-[2px]"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100 blur-0"
                        x-transition:leave="transition transform-gpu ease-[cubic-bezier(0.55,0,1,0.45)] duration-450 absolute"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100 blur-0"
                        x-transition:leave-end="opacity-0 -translate-y-2 scale-[0.99] blur-[2px]"
                        class="absolute inset-0 flex w-full items-center justify-center px-1">

                        <div
                            class="relative w-full overflow-hidden rounded-[2rem] border border-lightColor/20 bg-gradient-to-br from-white/18 via-white/10 to-white/5 p-7 shadow-md shadow-black/25 backdrop-blur-xl md:p-10">
                            <div
                                class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_95%_15%,rgba(218,94,146,0.22),transparent_35%)]">
                            </div>
                            <div class="pointer-events-none absolute -right-4 -top-6">
                                <i class="fa-solid fa-quote-right text-[8rem] text-lightColor/10"></i>
                            </div>

                            <div class="relative z-10 grid gap-8 md:grid-cols-[1fr_auto] md:items-center md:gap-10">
                                <div class="text-center md:text-left">
                                    <div class="mb-5 flex justify-center gap-1.5 md:justify-start" aria-hidden="true">
                                        <i class="fa-solid fa-star text-sm text-yellow-400"></i>
                                        <i class="fa-solid fa-star text-sm text-yellow-400"></i>
                                        <i class="fa-solid fa-star text-sm text-yellow-300"></i>
                                        <i class="fa-solid fa-star text-sm text-yellow-300"></i>
                                        <i class="fa-solid fa-star text-sm text-yellow-200"></i>
                                    </div>

                                    <p class="font-body text-md font-semibold leading-relaxed text-lightColor "
                                        x-text="feedback.comment"></p>

                                    <div
                                        class="mt-7 h-px w-full bg-gradient-to-r from-lightColor/70 via-lightColor/20 to-transparent">
                                    </div>

                                    <div class="mt-6 flex flex-col gap-1">
                                        <h3 class="font-heading text-xl font-bold text-lightColor"
                                            x-text="feedback.name"></h3>
                                        <p class="font-body text-sm uppercase tracking-[0.18em] text-lightColor/75"
                                            x-text="feedback.position"></p>
                                        <p class="font-body text-xs uppercase tracking-[0.22em] text-accentColor"
                                            x-text="feedback.company"></p>
                                    </div>
                                </div>

                                <div class="mx-auto w-fit md:mx-0">
                                    <div
                                        class="relative flex h-28 w-28 items-center justify-center rounded-full border border-lightColor/40 bg-lightColor/95 p-4 shadow-xl shadow-black/30">
                                        <img :src="'{{ asset('assets/reviews') }}/' + feedback.logo"
                                            :alt="feedback.company" class="h-full w-full rounded-full object-contain">
                                        <div class="absolute -inset-2 rounded-full border border-lightColor/20"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </template>
            </div>
        </div>

        <button @click="next()"
            class="group hidden h-14 w-14 items-center justify-center rounded-full border border-lightColor/20 bg-white/10 text-lightColor/80 shadow-lg shadow-black/20 backdrop-blur-sm transition-all duration-300 hover:translate-x-1 hover:border-accentColor hover:bg-accentColor hover:text-white md:flex"
            aria-label="Next review">
            <i class="fa-solid fa-arrow-right text-lg"></i>
        </button>
    </div>

    <div class="mt-8 flex flex-col items-center gap-5">
        <div class="flex items-center gap-8 md:hidden">
            {{-- Mobile Arrows --}}
            <div class="flex md:hidden items-center gap-8">
                <button @click="prev()" class="p-4 text-lightColor/50 hover:text-white transition active:scale-95"><i
                        class="fa-solid fa-arrow-left text-2xl"></i></button>
                <button @click="next()" class="p-4 text-lightColor/50 hover:text-white transition active:scale-95"><i
                        class="fa-solid fa-arrow-right text-2xl"></i></button>
            </div>
        </div>

        <div
            class="flex items-center gap-3 rounded-full border border-lightColor/10 bg-black/20 px-4 py-2 backdrop-blur-sm">
            <template x-for="(feedback, i) in feedbacks" :key="feedback.id">
                <button @click="goTo(i)" class="relative h-2 rounded-full transition-all duration-500"
                    :class="index === i ? 'w-10 bg-accentColor' : 'w-2 bg-lightColor/25 hover:bg-lightColor/45'"
                    :aria-label="'Go to slide ' + (i + 1)">
                    <span class="sr-only" x-text="'Slide ' + (i + 1)"></span>
                </button>
            </template>
        </div>
    </div>
</div>

<script>
    function feedbackSlider(feedbacks, intervalMs = 5000) {
        return {
            feedbacks: Array.isArray(feedbacks) ? feedbacks : [],
            index: 0,
            intervalMs: intervalMs,
            timer: null,

            init() {
                this.start();
            },

            start() {
                this.stop();
                if (this.feedbacks.length <= 1) return;
                this.timer = setInterval(() => {
                    this.next(true);
                }, this.intervalMs);
            },

            stop() {
                if (this.timer) {
                    clearInterval(this.timer);
                    this.timer = null;
                }
            },

            next(fromAuto = false) {
                if (!this.feedbacks.length) return;
                this.index = (this.index + 1) % this.feedbacks.length;
                if (!fromAuto) this.start();
            },

            prev() {
                if (!this.feedbacks.length) return;
                this.index = (this.index - 1 + this.feedbacks.length) % this.feedbacks.length;
                this.start();
            },

            goTo(i) {
                this.index = i;
                this.start();
            }
        };
    }
</script>
