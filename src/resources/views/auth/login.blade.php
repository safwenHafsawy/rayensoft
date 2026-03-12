<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-dark relative overflow-hidden">

        <!-- Decorative gradient lights -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-32 -left-20 w-96 h-96 bg-primaryColor/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-accentColor/10 rounded-full blur-[140px]"></div>
        </div>

        <!-- Card -->
        <div
            class="relative w-full max-w-lg bg-white/10 backdrop-blur-2xl border border-white/20 rounded-3xl shadow-[0_8px_40px_-10px_rgba(0,0,0,0.7)] p-10 text-white transition-all duration-500 hover:shadow-[0_8px_60px_-10px_rgba(99,102,241,0.5)]">

            <!-- Header -->
            <div class="text-center mb-10">
                <div class="flex justify-center mb-4">
                    <x-application-logo class="w-12 h-12" />
                </div>
                <h2 class="text-3xl font-heading font-bold tracking-tight">Welcome Back</h2>
                <p class="text-gray-400 mt-2 text-sm">Sign in to your <span class="gradient-text font-semibold">Rayen
                        Soft</span> workspace</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-light text-sm font-medium font-body" />
                    <x-text-input id="email" name="email" type="email" :value="old('email')" required autofocus
                        autocomplete="username" placeholder="you@example.com"
                        class="mt-2 w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white
                               placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primaryColor/50 focus:border-primaryColor transition-all duration-300" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-light text-sm font-medium font-body" />
                    <x-text-input id="password" name="password" type="password" required
                        autocomplete="current-password" placeholder="••••••••"
                        class="mt-2 w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white
                               placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primaryColor/50 focus:border-primaryColor transition-all duration-300" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-sm" />
                </div>

                <!-- Button -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-primaryColor to-accentColor rounded-xl font-heading font-semibold text-lg text-white shadow-lg shadow-primaryColor/30 hover:shadow-primaryColor/50 active:scale-[0.98] transition-all duration-300">
                        Sign In
                    </button>
                </div>
            </form>

        </div>
</x-guest-layout>
