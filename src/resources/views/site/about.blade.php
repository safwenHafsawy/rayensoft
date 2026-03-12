<x-site.main-layout>

    <x-slot:title>
        About Rayen Soft — Software Solutions That Scale
    </x-slot:title>

    <!-- Intro Section -->
    <section class="relative w-full overflow-hidden section-dark pt-32 pb-20">
        <div class="absolute inset-0 pointer-events-none">
            <div
                class="absolute top-0 left-0 w-96 h-96 bg-primaryColor-light/8 rounded-full blur-[150px] -translate-x-1/2 -translate-y-1/2">
            </div>
            <div
                class="absolute bottom-0 right-0 w-80 h-80 bg-accentColor/5 rounded-full blur-[120px] translate-x-1/3 translate-y-1/3">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 md:px-12 xl:px-24 flex flex-col lg:flex-row items-center gap-16">
            {{-- Left: Text --}}
            <div class="lg:w-1/2 flex flex-col gap-6 text-center lg:text-left">
                <p class="uppercase tracking-[0.25em] text-xs text-accentColor font-semibold">Our Mission</p>
                <h1 class="text-2xl sm:text-3xl lg:text-5xl font-extrabold font-heading leading-tight text-white">
                    Empowering Businesses <span class="gradient-text">to Scale Online</span>
                </h1>
                <p class="text-gray-400 text-lg leading-relaxed">
                    At <span class="font-semibold text-accentColor">Rayen Soft</span>, we build
                    <span class="text-primaryColor-light font-semibold">digital growth systems</span> that help coaches,
                    freelancers,
                    and service providers attract high-quality clients, automate marketing, and scale with confidence.
                </p>
            </div>

            {{-- Right: Image + Stats --}}
            <div class="lg:w-1/2 flex flex-col items-center relative">
                <div class="relative rounded-2xl overflow-hidden glass-card">
                    <img src="{{ asset('assets/team/banner.webp') }}" alt="Rayen Soft Team"
                        class="w-full max-w-md md:max-w-xl h-auto object-cover transition-transform duration-500 ease-out hover:scale-[1.02]" />
                </div>

                {{-- Stats Overlay --}}
                <div class="absolute -bottom-8 flex justify-center gap-4 mt-8">
                    <div
                        class="glass-card rounded-2xl px-6 py-3 text-center transition-transform duration-300 hover:-translate-y-1">
                        <p class="text-2xl md:text-3xl font-extrabold font-heading text-white">2<span
                                class="text-accentColor text-sm align-super">+</span></p>
                        <p class="text-gray-400 text-sm font-medium">Projects</p>
                    </div>
                    <div
                        class="rounded-2xl px-6 py-3 text-center bg-gradient-to-r from-primaryColor-light to-accentColor text-white transition-transform duration-300 hover:-translate-y-1 shadow-lg shadow-primaryColor-light/20">
                        <p class="text-2xl md:text-3xl font-extrabold font-heading">2<span
                                class="text-white/60 text-sm align-super">+</span></p>
                        <p class="text-white/80 text-sm font-medium">Clients</p>
                    </div>
                    <div
                        class="glass-card rounded-2xl px-6 py-3 text-center transition-transform duration-300 hover:-translate-y-1">
                        <p class="text-2xl md:text-3xl font-extrabold text-white font-heading">3<span
                                class="text-accentColor text-sm align-super">+</span></p>
                        <p class="text-gray-400 text-sm font-medium">Team</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Problem & Empathy -->
    <section class="relative py-24 overflow-hidden"
        style="background: linear-gradient(180deg, #0B0F19 0%, #131B2E 50%, #0B0F19 100%);">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-20 left-1/3 w-72 h-72 bg-primaryColor-light/8 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-accentColor/6 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative max-w-5xl mx-auto px-6 text-center">
            <h2 class="text-2xl md:text-4xl font-heading font-extrabold tracking-tight gradient-text mb-6">Sounds
                Familiar?</h2>
            <p class="mt-4 text-lg text-gray-400">Our clients often tell us:</p>

            <ul class="mt-10 space-y-6 text-lg text-gray-300 leading-relaxed max-w-3xl mx-auto">
                <li class="glass-card rounded-xl px-6 py-4 text-left">"I do everything myself — messages, bookings,
                    reminders. It's too much."</li>
                <li class="glass-card rounded-xl px-6 py-4 text-left">"If Instagram stops working, I won't get any new
                    clients."</li>
                <li class="glass-card rounded-xl px-6 py-4 text-left">"I have a website, but it looks old and no one
                    contacts me from it."</li>
                <li class="glass-card rounded-xl px-6 py-4 text-left">"My DMs are full of questions, but no one actually
                    books."</li>
            </ul>

            <div class="w-16 h-1 bg-gradient-to-r from-primaryColor-light to-accentColor mx-auto my-12 rounded-full">
            </div>

            <p class="text-lg md:text-xl text-gray-200 font-semibold max-w-3xl mx-auto leading-relaxed">
                You're not alone — we help service providers like you turn <span
                    class="text-primaryColor-light font-bold">overwhelmed into organized</span>
                and <span class="text-accentColor font-bold">browsers into bookings.</span>
            </p>
        </div>
    </section>

    <!-- Before and After -->
    <section class="relative py-28 section-dark overflow-hidden">
        <div class="relative max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-2xl md:text-4xl font-extrabold font-heading gradient-text mb-16">
                What Happens When You Work With Us
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
                {{-- BEFORE --}}
                <div class="p-10 rounded-3xl glass-card transition-all duration-500 hover:-translate-y-1">
                    <h3 class="text-2xl font-semibold text-red-400 mb-6 font-heading">Before</h3>
                    <ul class="space-y-5 text-gray-300 text-lg leading-relaxed">
                        <li class="flex items-start gap-3"><span class="text-red-400 mt-1">✗</span> You're managing
                            messages, bookings, and reminders manually.</li>
                        <li class="flex items-start gap-3"><span class="text-red-400 mt-1">✗</span> You rely entirely on
                            Instagram or TikTok for new clients.</li>
                        <li class="flex items-start gap-3"><span class="text-red-400 mt-1">✗</span> Your website looks
                            outdated, loads slowly, or doesn't convert.</li>
                    </ul>
                </div>

                {{-- AFTER --}}
                <div
                    class="p-10 rounded-3xl bg-gradient-to-br from-primaryColor-light/20 to-accentColor/20 border border-accentColor/20 transition-all duration-500 hover:-translate-y-1">
                    <h3 class="text-2xl font-semibold text-accentColor mb-6 font-heading">After</h3>
                    <ul class="space-y-5 text-gray-200 text-lg leading-relaxed">
                        <li class="flex items-start gap-3"><span class="text-accentColor mt-1">✓</span> Clients book
                            directly into your calendar — no back and forth.</li>
                        <li class="flex items-start gap-3"><span class="text-accentColor mt-1">✓</span> Your website
                            brings consistent leads, even when socials are quiet.</li>
                        <li class="flex items-start gap-3"><span class="text-accentColor mt-1">✓</span> You own a sleek,
                            fast site built to convert visitors into clients.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Who We Help -->
    <section class="relative py-28 overflow-hidden"
        style="background: linear-gradient(180deg, #0B0F19 0%, #131B2E 100%);">
        <div class="relative max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold font-heading gradient-text mb-16">
                We Specialize in Websites For
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([['title' => 'Coaches', 'desc' => 'Position yourself as a trusted authority and simplify discovery calls.'], ['title' => 'Consultants', 'desc' => 'Build trust and convert visitors into premium clients.'], ['title' => 'Wellness Pros', 'desc' => 'Create a welcoming space where clients feel confident booking sessions.'], ['title' => 'Freelancers', 'desc' => 'Stand out online and fill your calendar with aligned clients.'], ['title' => 'Creatives', 'desc' => 'Showcase your work beautifully while automating bookings and inquiries.'], ['title' => 'Service Businesses', 'desc' => 'From electricians to digital experts — get found, get booked, and grow.']] as $card)
                    <div
                        class="group p-8 rounded-2xl glass-card glass-card-hover text-left transition-all duration-500 hover:-translate-y-2">
                        <h3
                            class="text-xl font-semibold text-white mb-3 font-heading group-hover:text-accentColor transition-colors">
                            {{ $card['title'] }}
                        </h3>
                        <p class="text-gray-400 text-base leading-relaxed">
                            {{ $card['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="relative py-24 section-dark overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 xl:grid-cols-2 items-center gap-16 px-6 md:px-12">
            {{-- LEFT --}}
            <div class="space-y-10">
                <div class="text-center xl:text-left">
                    <p class="text-xs uppercase tracking-[0.25em] text-accentColor font-medium mb-3">How It Works</p>
                    <h2 class="text-2xl lg:text-3xl font-heading font-extrabold tracking-tight gradient-text mb-6">
                        How Rayen Soft Works With You
                    </h2>
                </div>

                <div class="relative pl-8 border-l border-dashed border-primaryColor-light/30 space-y-10">
                    @foreach ([['num' => '1', 'title' => 'Book a Free Discovery Session', 'desc' => 'We learn about your business, your goals, and where your current website falls short.'], ['num' => '2', 'title' => 'Get a Custom Plan', 'desc' => 'We design a tailored website and system built for conversions, automations, and trust.'], ['num' => '3', 'title' => 'Launch & Grow', 'desc' => 'We launch your new client-winning site and support your growth every step of the way.']] as $step)
                        <div class="relative">
                            <span
                                class="absolute -left-[50px] top-0 flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-primaryColor-light to-accentColor text-white font-semibold text-sm shadow-lg">{{ $step['num'] }}</span>
                            <p class="text-xl font-semibold text-white mb-2">{{ $step['title'] }}</p>
                            <p class="text-gray-400 text-base leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    @endforeach

                    <div class="pt-6">
                        <x-site.primary-button route="book">
                            Book Free Discovery Session
                        </x-site.primary-button>
                        <p class="mt-3 text-sm text-gray-600">No pressure — just clarity and next steps.</p>
                    </div>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="relative grid grid-cols-2 gap-4">
                <div class="flex items-center justify-center col-span-2">
                    <img src="{{ asset('assets/team/work.webp') }}" alt="Team working together"
                        class="rounded-2xl object-cover w-4/5 glass-card hover:scale-[1.02] transition-transform duration-500"
                        loading="lazy">
                </div>
                <img src="{{ asset('assets/team/cooperation.webp') }}" alt="Team cooperation"
                    class="rounded-2xl object-cover w-full glass-card hover:scale-[1.02] transition-transform duration-500"
                    loading="lazy">
                <img src="{{ asset('assets/team/ipad.webp') }}" alt="Digital collaboration"
                    class="rounded-2xl object-cover w-full glass-card hover:scale-[1.02] transition-transform duration-500"
                    loading="lazy">
            </div>
        </div>
    </section>

    <!-- Our Team -->
    <section class="relative py-20 overflow-hidden"
        style="background: linear-gradient(180deg, #131B2E 0%, #0B0F19 100%);">
        <div class="text-center px-6 md:px-12 mb-16">
            <x-site.gradient-heading text="Meet The Builders" textAlign="text-center" />
            <p class="max-w-3xl mx-auto text-gray-400 text-base md:text-lg leading-relaxed mt-4">
                Meet the minds shaping digital excellence. Our passionate builders craft websites that don't just look
                good—they perform, convert, and elevate your brand.
            </p>
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 px-8 md:px-12 xl:px-16">
            @foreach ([['img' => 'rihab_ben_ali.webp', 'role' => 'CEO & CO-FOUNDER', 'name' => 'Rihab Ben Ali'], ['img' => 'mohamedhedi.webp', 'role' => 'LEAD DEVELOPER', 'name' => 'Mohamed Hedi Ben Ali'], ['img' => 'safwen.webp', 'role' => 'CTO & CO-FOUNDER', 'name' => 'Safwen Hafsawy']] as $member)
                <div
                    class="group relative overflow-hidden rounded-2xl glass-card transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-primaryColor-light/10">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('assets/team/' . $member['img']) }}" alt="{{ $member['role'] }}"
                            class="w-full h-80 object-cover transition-transform duration-700 group-hover:scale-105"
                            loading="lazy">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-darkColor/80 via-transparent to-transparent">
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <p class="text-xs tracking-[0.15em] text-accentColor mb-1">{{ $member['role'] }}</p>
                        <h3 class="text-lg font-bold font-heading text-white">{{ $member['name'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Featured Blog -->
    <section class="relative py-24 section-dark overflow-hidden">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-2xl md:text-4xl font-extrabold font-heading gradient-text">
                Digital Growth Insights from Our Team
            </h2>
            <p class="mt-4 text-gray-400 text-lg max-w-3xl mx-auto leading-relaxed">
                Discover actionable insights, tips, and case studies to help you grow your business online.
            </p>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ([['slug' => 'rayensoft-solutions-agence-web-services-pme', 'img' => 'rayensoft-solutions-agence-web.webp', 'title' => "Rayen Soft : L'Agence Web Pensée pour les Prestataires de Services et les Petites Entreprises", 'desc' => "Découvrez Rayen Soft, l'agence web pensée pour les prestataires de services et les petites entreprises."], ['slug' => 'creer-un-site-web-e-commerce-performant', 'img' => 'ecommerce-site-web.webp', 'title' => 'Créer un site web e-commerce performant : 5 astuces pour booster vos ventes', 'desc' => 'Votre site e-commerce ne doit pas juste exister — il doit vendre. Voici 5 astuces concrètes.'], ['slug' => 'votre-petite-entreprise-echoue-peut-etre-a-cause-dun-detail-simple-votre-site-web', 'img' => 'petite-entreprise-site-web.webp', 'title' => "Votre petite entreprise échoue peut-être à cause d'un détail simple : votre site web", 'desc' => "Votre site web est bien plus qu'une vitrine : c'est un levier de crédibilité et de conversion."]] as $post)
                    <a href="{{ route('blog.singleArticle', ['slug' => $post['slug']]) }}"
                        class="group block rounded-2xl glass-card glass-card-hover overflow-hidden transition-all duration-500 hover:-translate-y-2">
                        <img src="{{ asset('assets/articles/' . $post['img']) }}" alt="{{ $post['title'] }}"
                            class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="p-6 text-left">
                            <h3
                                class="text-base font-semibold text-white group-hover:text-accentColor transition-colors mb-2 line-clamp-2">
                                {{ $post['title'] }}</h3>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">{{ $post['desc'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

</x-site.main-layout>
