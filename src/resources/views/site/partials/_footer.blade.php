<footer class="relative pt-20 pb-8 px-6 lg:px-20 overflow-hidden"
    style="background: linear-gradient(180deg, #0B0F19 0%, #060A12 100%);">

    {{-- Ambient glow --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primaryColor-light/5 rounded-full blur-[150px] pointer-events-none">
    </div>
    <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-accentColor/5 rounded-full blur-[120px] pointer-events-none">
    </div>

    <div class="relative z-10 max-w-7xl mx-auto">
        {{-- Top Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 pb-12 border-b border-white/5">

            {{-- Brand --}}
            <div class="lg:col-span-1 space-y-4">
                <div class="flex items-center gap-3">
                    <x-site.application-logo class="h-10 w-auto" alt="Rayen Soft Logo" />
                    <span class="font-heading font-bold text-white text-xl">Rayen<span
                            class="text-accentColor">Soft</span></span>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed max-w-xs">
                    We build high-performance web applications and digital growth systems for ambitious businesses.
                </p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-xs uppercase tracking-[0.2em] text-gray-500 font-semibold mb-6">Navigation</h4>
                <ul class="space-y-3">
                    @foreach (['welcome' => 'Home', 'about' => 'About Us', 'portfolio' => 'Portfolio', 'services' => 'Services', 'contact' => 'Contact', 'blog' => 'Blog'] as $route => $label)
                        <li>
                            <a href="{{ route($route) }}"
                                class="text-gray-400 text-sm hover:text-accentColor transition-colors duration-300">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Services --}}
            <div>
                <h4 class="text-xs uppercase tracking-[0.2em] text-gray-500 font-semibold mb-6">Services</h4>
                <ul class="space-y-3">
                    <li><span class="text-gray-400 text-sm">Web Development</span></li>
                    <li><span class="text-gray-400 text-sm">UI/UX Design</span></li>
                    <li><span class="text-gray-400 text-sm">SEO & Growth</span></li>
                    <li><span class="text-gray-400 text-sm">Digital Strategy</span></li>
                    <li><span class="text-gray-400 text-sm">Automation</span></li>
                </ul>
            </div>

            {{-- Contact + Social --}}
            <div>
                <h4 class="text-xs uppercase tracking-[0.2em] text-gray-500 font-semibold mb-6">Get in Touch</h4>
                <div class="space-y-3 text-sm text-gray-400">
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-accentColor text-xs"></i>
                        Nabeul, Tunisia
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-accentColor text-xs"></i>
                        info@rayensoftsolution.com
                    </p>
                </div>

                {{-- Social Links --}}
                <div class="flex gap-3 mt-6">
                    <a href="https://www.linkedin.com/company/rayensoft-solutions/" target="_blank"
                        aria-label="LinkedIn"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 text-gray-500 hover:text-white hover:bg-primaryColor-light/20 transition-all duration-300">
                        <i class="fa-brands fa-linkedin-in text-sm"></i>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=61564855903994" target="_blank"
                        aria-label="Facebook"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 text-gray-500 hover:text-white hover:bg-primaryColor-light/20 transition-all duration-300">
                        <i class="fa-brands fa-facebook text-sm"></i>
                    </a>
                    <a href="https://www.instagram.com/rayensoft.solutions.agency" target="_blank"
                        aria-label="Instagram"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 text-gray-500 hover:text-white hover:bg-accentColor/20 transition-all duration-300">
                        <i class="fa-brands fa-instagram text-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="flex flex-col md:flex-row justify-between items-center pt-8 gap-4">
            <p class="text-gray-600 text-xs">&copy; {{ date('Y') }} Rayen Soft. All rights reserved.</p>
            <p class="text-gray-700 text-xs">Designed & built with <span class="text-accentColor">♥</span> in Tunisia
            </p>
        </div>
    </div>
</footer>
