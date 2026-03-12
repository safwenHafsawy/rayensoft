<div class="xl:container mt-12 z-10" x-data="{ tab: 'leads' }">
    <!-- Tab Navigation -->
    <div class="flex justify-center">
        <div class="inline-flex p-1.5 rounded-2xl glass-card shadow-premium">
            <!-- Leads Tab -->
            <button @click="tab = 'leads'"
                :class="[
                    'relative flex items-center justify-center px-8 py-3 rounded-xl font-heading font-bold text-sm uppercase tracking-wider transition-all duration-300 ease-out',
                    tab === 'leads' ?
                    'premium-gradient text-white shadow-premium-glow' :
                    'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-white/5'
                ]">
                <i class="fa-solid fa-users mr-2.5 text-xs"></i>
                Leads
            </button>

            <!-- Clients Tab -->
            <button @click="tab = 'clients'"
                :class="[
                    'relative flex items-center justify-center px-8 py-3 rounded-xl font-heading font-bold text-sm uppercase tracking-wider transition-all duration-300 ease-out',
                    tab === 'clients' ?
                    'premium-gradient text-white shadow-premium-glow' :
                    'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-white/5'
                ]">
                <i class="fa-solid fa-briefcase mr-2.5 text-xs"></i>
                Clients
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="mt-8">
        <!-- Leads Tab -->
        <div class="w-full" x-show="tab === 'leads'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <livewire:client-management.leads-table />
        </div>
        <!-- Clients Tab -->
        <div class="w-full" x-show="tab === 'clients'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <livewire:client-management.clients-table />
        </div>
    </div>
</div>
