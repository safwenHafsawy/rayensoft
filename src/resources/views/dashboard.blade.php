<x-app-layout>
    <div class="space-y-10">
        {{-- Welcome Section --}}
        <section>
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h2
                        class="text-3xl sm:text-4xl font-heading font-black text-gray-900 dark:text-white tracking-tight">
                        Welcome back, Rihab Ben Ali ! 👋
                    </h2>
                </div>
                <div class="mt-6 md:mt-0 flex items-center space-x-3">
                    <div
                        class="px-4 py-2 bg-white/50 dark:bg-black/20 rounded-2xl border border-white/20 dark:border-white/5 shadow-sm">
                        <span class="text-sm font-bold text-gray-500">{{ now()->format('l, jS F Y') }}</span>
                    </div>
                </div>
            </div>
        </section>



        {{-- Stats Grid --}}
        <section class="hidden md:block">
            <livewire:main.overview />
        </section>
        <section class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            <livewire:main.upcoming-meetings />
            <livewire:main.leads-funnel />
        </section>

        {{-- Activity Feed --}}
        <section>
            <livewire:main.recent-activities-table />
        </section>
    </div>
</x-app-layout>
