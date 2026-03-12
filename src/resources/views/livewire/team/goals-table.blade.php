<div class="relative glass-card rounded-3xl p-4 sm:p-8 shadow-premium hover-lift overflow-hidden">
    {{-- Decorative background --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-primaryColor/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-accentColor/5 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Header --}}
    <div class="relative z-10 flex flex-col items-start mb-8">
        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-0">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl premium-gradient flex items-center justify-center shadow-premium">
                    <i class="fa-solid fa-bullseye text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-heading font-black text-gray-900 dark:text-white tracking-tight">
                        Goals</h1>
                    <p class="text-xs sm:text-sm text-gray-400 dark:text-gray-500 font-body mt-0.5">Track team objectives
                    </p>
                </div>
            </div>
            <div class="flex gap-3 w-full sm:w-auto">
                <x-primary-button wire:click="openCreateGoalModal" class="flex-1 sm:flex-initial justify-center">
                    <i class="fa-solid fa-plus mr-2"></i>New Goal
                </x-primary-button>
                <x-secondary-button wire:click='openGoalsHistoryModal' class="flex-1 sm:flex-initial justify-center">
                    <i class="fas fa-history mr-2"></i>History
                </x-secondary-button>
            </div>
        </div>

        {{-- Filters --}}
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
            <div>
                <x-input-label for="users" value="Filter By User" />
                <x-dropdown :options="$users" placeholder="All" model="filters.user" />
            </div>
            <div>
                <x-input-label for="status" value="Filter By Status" />
                <x-dropdown :options="$statuses" placeholder="All" model="filters.status" />
            </div>
            <div>
                <x-input-label for="priority" value="Filter By Area" />
                <x-dropdown :options="$areas" placeholder="All" model="filters.area" />
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="relative z-10 rounded-2xl border border-gray-100/50 dark:border-white/5 overflow-x-auto">
        <table class="table-auto w-full min-w-[700px]">
            <thead>
                <x-table.table-row :header="true">
                    <x-table.table-header>Title</x-table.table-header>
                    <x-table.table-header>Start Date</x-table.table-header>
                    <x-table.table-header>End Date</x-table.table-header>
                    <x-table.table-header>Status</x-table.table-header>
                    <x-table.table-header></x-table.table-header>
                </x-table.table-row>
            </thead>
            <tbody>
                @if ($goals->isEmpty())
                    <x-table.table-row>
                        <x-table.table-data colspan="5"
                            class="text-center text-gray-400 dark:text-gray-500 text-lg py-16 font-body">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-white/5 flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-flag text-2xl text-gray-300 dark:text-gray-600"></i>
                                </div>
                                <span class="font-heading font-bold">No goals set</span>
                                <span class="text-sm mt-1 text-gray-400">Create your first goal to get started</span>
                            </div>
                        </x-table.table-data>
                    </x-table.table-row>
                @else
                    @foreach ($goals as $goal)
                        <x-table.table-row>
                            <x-table.table-data>
                                <span
                                    class="font-bold text-gray-900 dark:text-white">{{ Str::Limit($goal->title, 40, '...') }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span class="inline-flex items-center text-sm">
                                    <i class="fa-regular fa-calendar mr-1.5 text-xs text-gray-400"></i>
                                    {{ $goal->start_date }}
                                </span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span class="inline-flex items-center text-sm">
                                    <i class="fa-regular fa-calendar-check mr-1.5 text-xs text-gray-400"></i>
                                    {{ $goal->end_date }}
                                </span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span
                                    class="px-3 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider {{ $this->setStatusColor($goal->status) }}">{{ $goal->status }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <div class="flex items-center space-x-2">
                                    @if (auth()->check() && auth()->id() === $goal->user_id)
                                        <button wire:click="openCreateGoalModal('{{ $goal->id }}')"
                                            class="p-2 rounded-xl text-gray-400 hover:text-primaryColor hover:bg-primaryColor/5 transition-all duration-200">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                    @endif
                                    <button wire:click="showDetails('{{ $goal['id'] }}')"
                                        class="p-2 rounded-xl text-gray-400 hover:text-primaryColor hover:bg-primaryColor/5 transition-all duration-200">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </x-table.table-data>
                        </x-table.table-row>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
