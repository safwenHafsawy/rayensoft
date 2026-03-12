<div class="relative glass-card rounded-3xl p-4 sm:p-8 shadow-premium hover-lift overflow-hidden">
    {{-- Decorative background --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-primaryColor/5 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Header --}}
    <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl premium-gradient flex items-center justify-center shadow-premium">
                <i class="fa-solid fa-briefcase text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-2xl font-heading font-black text-gray-900 dark:text-white tracking-tight">Clients</h1>
                <p class="text-sm text-gray-400 dark:text-gray-500 font-body mt-0.5">Your active client portfolio</p>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="relative z-10 w-full overflow-x-auto rounded-2xl border border-gray-100/50 dark:border-white/5">
        <table class="w-full table-auto min-w-[800px] border-collapse">
            <thead>
                <x-table.table-row :header="true">
                    <x-table.table-header>Name</x-table.table-header>
                    <x-table.table-header>Phone</x-table.table-header>
                    <x-table.table-header>Email</x-table.table-header>
                    <x-table.table-header>Location</x-table.table-header>
                    <x-table.table-header>Status</x-table.table-header>
                    <x-table.table-header>Engagement Date</x-table.table-header>
                    <x-table.table-header></x-table.table-header>
                </x-table.table-row>
            </thead>
            <tbody>
                @if (empty($clients))
                    <x-table.table-row>
                        <x-table.table-data colspan="6"
                            class="text-center text-gray-400 dark:text-gray-500 text-lg py-20 font-body">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-white/5 flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-inbox text-2xl text-gray-300 dark:text-gray-600"></i>
                                </div>
                                <span class="font-heading font-bold">No clients yet</span>
                                <span class="text-sm mt-1 text-gray-400">Convert leads to see them here</span>
                            </div>
                        </x-table.table-data>
                    </x-table.table-row>
                @else
                    @foreach ($clients as $client)
                        <x-table.table-row>
                            <x-table.table-data>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $client['name'] }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                {{ $client['phone'] }}
                            </x-table.table-data>
                            <x-table.table-data>
                                <span class="text-primaryColor font-medium">{{ $client['email'] }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                {{ $client['location'] }}
                            </x-table.table-data>
                            <x-table.table-data>
                                <span
                                    class="px-3 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider {{ $this->satisfactionColor($client['type']) }}">{{ $client['type'] }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span class="inline-flex items-center text-sm">
                                    <i class="fa-regular fa-calendar mr-1.5 text-xs text-gray-400"></i>
                                    {{ $client['engagement_date'] }}
                                </span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <button wire:click="openClientModal('{{ $client['id'] }}')"
                                    class="p-2 rounded-xl text-gray-400 hover:text-primaryColor hover:bg-primaryColor/5 transition-all duration-200">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </x-table.table-data>
                        </x-table.table-row>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
