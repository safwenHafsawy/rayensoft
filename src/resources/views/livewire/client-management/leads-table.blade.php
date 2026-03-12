<div class="relative glass-card rounded-3xl p-4 sm:p-8 overflow-hidden">
    {{-- Decorative background --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-primaryColor/5 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Header --}}
    <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl premium-gradient flex items-center justify-center shadow-premium">
                <i class="fa-solid fa-users text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-2xl font-heading font-black text-gray-900 dark:text-white tracking-tight">Leads Table
                </h1>
                <p class="text-sm text-gray-400 dark:text-gray-500 font-body mt-0.5">Manage and track your prospects</p>
            </div>
        </div>
        <div class="mt-4 sm:mt-0">
            <x-primary-button loadingKey="openModal" icon="fa-solid fa-user-plus" wire:click="openLeadsUpsertModal()">
                Add New Lead
            </x-primary-button>
        </div>
    </div>

    {{-- Filtering Form --}}
    <div class="relative z-10 mb-8 grid md:grid-cols-4 xl:grid-cols-7 gap-4">
        <div>
            <x-input-label for="status" value="Filter By Status" />
            <x-dropdown :options="$lead_statues" placeholder="All" model="filters.status" />
        </div>
        <div>
            <x-input-label for="status" value="Filter By Source" />
            <x-dropdown :options="$leadSources" placeholder="All Sources" model="filters.lead_source" />
        </div>

        <div>
            <x-input-label for="industry" value="Filter By Industry" />
            <x-dropdown :options="$industries" placeholder="All Industries" model="filters.lead_industry" />
        </div>



        <!-- Search Filter -->
        <div class="col-span-6 xl:col-span-3">
            <x-input-label for="status" value="Search By Key Word" />
            <x-text-input type="text" id="search" wire:model.live="filters.search"
                placeholder="Search by name or reason" />
        </div>

        <div class="flex items-end gap-2 xl:col-span-1 col-span-2">
            <x-secondary-button wire:click="toggleShowJunk"
                class="w-full justify-center h-[42px] {{ $showJunk ? 'bg-zinc-200 dark:bg-zinc-800' : '' }}"
                title="Toggle Junk Leads">
                <i class="fa-solid fa-trash-can mr-2 {{ $showJunk ? 'text-red-500' : '' }}"></i> Junk
            </x-secondary-button>
            <x-secondary-button wire:click="resetFilters" class="w-full justify-center h-[42px]">
                <i class="fa-solid fa-filter-circle-xmark mr-2"></i> Clear
            </x-secondary-button>
        </div>
    </div>

    {{-- Table --}}
    <div class="relative w-full overflow-x-auto rounded-2xl border border-gray-100/50 dark:border-white/5">
        <table class="w-full table-auto min-w-[1000px] border-collapse">
            <thead>
                <x-table.table-row :header="true">
                    <x-table.table-header>Name</x-table.table-header>
                    <x-table.table-header>Phone</x-table.table-header>
                    <x-table.table-header>Email</x-table.table-header>
                    <x-table.table-header>Status</x-table.table-header>
                    <x-table.table-header>Source</x-table.table-header>
                    <x-table.table-header>Industry</x-table.table-header>
                    <x-table.table-header>Added At</x-table.table-header>
                    <x-table.table-header></x-table.table-header>
                </x-table.table-row>
            </thead>
            <tbody>
                @if ($leads->isEmpty())

                    <x-table.table-row>
                        <x-table.table-data colspan="7"
                            class="text-center text-gray-400 dark:text-gray-500 text-lg py-20 font-body">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-white/5 flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-inbox text-2xl text-gray-300 dark:text-gray-600"></i>
                                </div>
                                <span class="font-heading font-bold">No leads yet</span>
                                <span class="text-sm mt-1 text-gray-400">Add your first lead to get started</span>
                            </div>
                        </x-table.table-data>
                    </x-table.table-row>
                @else
                    @foreach ($leads as $lead)
                        <x-table.table-row>
                            <x-table.table-data>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $lead->name ?: '-' }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span
                                    class="text-gray-600 dark:text-gray-400 font-mono text-xs">{{ $lead->phone ?: '-' }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span class="text-gray-600 dark:text-gray-400">{{ $lead->email ?: '-' }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span
                                    class="{{ $this->getStatusClass($lead->status) }} inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider">
                                    <i class="{{ $this->getStatusIcon($lead->status) }} text-[10px]"></i>
                                    {{ $lead->status ?: '-' }}
                                </span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span
                                    class="text-xs font-bold uppercase text-gray-500">{{ $lead->lead_source ?: '-' }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span class="text-xs text-gray-500">{{ $lead->industry ?: '-' }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span
                                    class="text-xs text-gray-500">{{ $lead->created_at->format('Y-m-d , H:i A') ?: '-' }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                @if ($lead->status !== 'Won')
                                    <a href="{{ route('lead-info', $lead->id) }}"
                                        class="p-2 rounded-xl text-gray-400 hover:text-primaryColor hover:bg-primaryColor/5 transition-all duration-200">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @endif
                            </x-table.table-data>
                        </x-table.table-row>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="mt-6 px-2">
            {{ $leads->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>
