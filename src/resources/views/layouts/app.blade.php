<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta name="robots" content="no index, nofollow">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body x-data="{ mobileMenuOpen: false }"
    class="font-body antialiased bg-light dark:bg-dark text-gray-900 dark:text-gray-100 selection:bg-primaryColor selection:text-white">
    {{-- Global Background Mesh --}}
    <div class="fixed inset-0 pointer-events-none z-[-1] overflow-hidden opacity-30 dark:opacity-20">
        <div
            class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primaryColor/80 rounded-full blur-[120px] animate-mesh">
        </div>
        <div
            class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-accentColor/80 rounded-full blur-[120px] animate-mesh">
        </div>
    </div>

    <div class="flex flex-row min-h-screen transition-colors duration-300">

        <x-auth-session-status />

        <!-- Global Loader -->
        <div id="global-loader" class="z-[9999]">
            <div class="relative">
                <div class="w-24 h-24 border-4 border-primaryColor/10 border-t-primaryColor rounded-full animate-spin">
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <x-application-logo class="w-12 h-12 text-primaryColor animate-pulse" />
                </div>
            </div>

            <h1
                class="loader-title font-heading text-2xl mt-8 font-black tracking-tighter text-gray-800 dark:text-gray-100">
                RAYEN<span class="ml-1 gradient-text">SOFT</span>
            </h1>

            <div class="flex space-x-2 mt-6">
                <span class="w-3 h-3 bg-primaryColor rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
                <span class="w-3 h-3 bg-primaryColor-light rounded-full animate-bounce"
                    style="animation-delay: 0.2s"></span>
                <span class="w-3 h-3 bg-primaryColor-lighter rounded-full animate-bounce"
                    style="animation-delay: 0.3s"></span>
            </div>
        </div>

        @include('layouts.navigation')

        <!-- Mobile Backdrop -->
        <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm md:hidden">
        </div>

        <!-- Page Content -->
        <main class="w-full ml-0 md:ml-16 flex flex-col min-h-screen transition-colors duration-300">
            <!-- Modern Glass Top Bar -->
            <div
                class="sticky top-0 z-40 w-full flex items-center justify-between px-4 md:px-8 py-4 bg-white/80 dark:bg-dark/80 backdrop-blur-md border-b border-gray-100 dark:border-white/5 transition-all duration-300">

                <!-- Left: Context & Navigation -->
                <div class="flex items-center space-x-4 group/breadcrumb">
                    <!-- Mobile Menu Toggle -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-white/5 transition-colors">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>

                    <div
                        class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 hidden md:flex items-center justify-center text-gray-400 group-hover/breadcrumb:text-primaryColor group-hover/breadcrumb:border-primaryColor/20 transition-all duration-300">
                        <i class="fa-solid fa-layer-group text-sm"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <span
                            class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-600 mb-0.5 hidden md:block">Location</span>
                        <h1 class="text-sm font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                            <span class="opacity-40 font-normal hidden md:inline">Workspace</span>
                            <i class="fa-solid fa-chevron-right text-[8px] opacity-30 hidden md:inline"></i>
                            <span
                                class="capitalize">{{ str_replace(['.', '-'], ' ', request()->route()->getName()) }}</span>
                        </h1>
                    </div>
                </div>

                <!-- Right: Actions & Profile -->
                <div class="flex items-center space-x-2 md:space-x-6">
                    {{-- Utility Action Group --}}
                    <div
                        class="flex items-center bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-100 dark:border-white/5 p-1">
                        <!-- Notifications -->
                        <div class="relative">
                            <x-notification-dropdown />
                        </div>

                        <div class="w-[1px] h-4 bg-gray-200 dark:bg-gray-700 mx-1"></div>

                        <!-- Dark Mode Toggle -->
                        <button id="dark-mode-toggle"
                            class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-400 hover:text-primaryColor hover:bg-white dark:hover:bg-white/10 transition-all duration-300">
                            <i class="fa-solid fa-moon hidden dark:inline text-xs"></i>
                            <i class="fa-solid fa-sun inline dark:hidden text-yellow-500 text-xs"></i>
                        </button>
                    </div>

                    {{-- Minimalist Profile (No Image) --}}
                    <div
                        class="flex items-center pl-2 border-none md:pl-6 md:border-l border-gray-100 dark:border-white/5">
                        <div class="group flex items-center gap-3 cursor-pointer">
                            <div class="text-right hidden sm:block">
                                <div
                                    class="text-xs font-bold text-gray-800 dark:text-gray-100 group-hover:text-primaryColor transition-colors">
                                    Rihab Ben Ali
                                </div>
                                <div class="text-[10px] font-medium text-gray-400 dark:text-gray-500">
                                    Developeur
                                </div>
                            </div>

                            <div class="relative">
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 dark:from-white/5 dark:to-white/10 border border-gray-100 dark:border-white/5 flex items-center justify-center text-primaryColor font-bold text-xs shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all duration-300">
                                    @php
                                        $initials = collect(explode(' ', auth()->user()->name))
                                            ->map(fn($n) => mb_substr($n, 0, 1))
                                            ->take(2)
                                            ->join('');
                                    @endphp
                                    RA
                                </div>
                                <span
                                    class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full ring-2 ring-white dark:ring-[#1a1a1a]"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

{{-- 
            <div class="px-4 md:px-8 mt-6">
                <div class="relative overflow-hidden premium-gradient rounded-2xl p-4 shadow-premium group">
                    <div
                        class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <p
                        class="relative z-10 text-center text-white font-bold text-sm sm:text-base tracking-wide flex items-center justify-center">
                        <i class="fa-solid fa-quote-left mr-4 opacity-30 text-2xl"></i>
                        وَقُل رَّبِّ أَدْخِلْنِي مُدْخَلَ صِدْقٍ وَأَخْرِجْنِي مُخْرَجَ صِدْقٍ وَاجْعَل لِّي مِن
                        لَّدُنكَ سُلْطَانًا نَّصِيرًا
                        <i class="fa-solid fa-quote-right ml-4 opacity-30 text-2xl"></i>
                    </p>
                </div>
            </div> --}}
            <!-- Main Content Slot -->
            <div class="flex-1 px-4 md:px-8 py-8">
                {{ $slot }}
            </div>
        </main>
    </div>
    @livewireScripts
</body>

</html>

<script>
    document.addEventListener("livewire:navigating", () => {
        const loader = document.getElementById('global-loader');
        if (loader) {
            loader.style.visibility = 'visible';
            loader.style.opacity = '1';
        }
    });

    document.addEventListener("livewire:navigated", () => {
        const loader = document.getElementById('global-loader');
        if (loader) {
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => loader.style.visibility = 'hidden', 500);
            }, 300);
        }
    });

    // Scope the dark mode logic to avoid "Identifier already declared" errors
    (function() {
        const toggle = document.getElementById('dark-mode-toggle');
        const html = document.documentElement;

        // Check saved preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        if (toggle) {
            // Remove any existing event listeners to prevent duplicates (not strictly necessary with IIFE but good practice if element persists)
            const newToggle = toggle.cloneNode(true);
            toggle.parentNode.replaceChild(newToggle, toggle);

            newToggle.addEventListener('click', () => {
                html.classList.toggle('dark');

                if (html.classList.contains('dark')) {
                    localStorage.theme = 'dark';
                } else {
                    localStorage.theme = 'light';
                }
            });
        }
    })();

    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');

        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);

        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    };

    document.addEventListener('DOMContentLoaded', async () => {
        try {
            // Optional: Only run if the notification setup hasn't run yet
            if (window.pushNotificationSetupDone) return;
            window.pushNotificationSetupDone = true;

            const response = await fetch('https://portal.rayensoftsolution.com/api/fetch-vapid-public-key');
            if (!response.ok) return; // Silent fail if API is down
            const data = await response.json();

            const publicKey = urlBase64ToUint8Array(data.publicKey);
            const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
            if (!csrfTokenElement) return;
            const csrfToken = csrfTokenElement.getAttribute('content');

            if ('Notification' in window && 'serviceWorker' in navigator) {
                const permission = await Notification.requestPermission();

                if (permission === 'granted') {
                    const registration = await navigator.serviceWorker.register('/service-worker.js');
                    const subscription = await registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: publicKey
                    });

                    await fetch('https://portal.rayensoftsolution.com/api/store-subscription', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(subscription)
                    });
                }
            }
        } catch (error) {
            console.error('Error in push notification setup:', error);
        }
    })
</script>
