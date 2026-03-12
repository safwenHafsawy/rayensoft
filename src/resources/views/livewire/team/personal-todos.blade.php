<div class="relative glass-card rounded-3xl p-8 shadow-premium hover-lift overflow-hidden">
    {{-- Decorative background --}}
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-accentColor/5 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Header --}}
    <div class="relative z-10 flex flex-col items-start mb-8">
        <div class="w-full flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl premium-gradient flex items-center justify-center shadow-premium">
                    <i class="fa-solid fa-clipboard-check text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-heading font-black text-gray-900 dark:text-white tracking-tight">Action
                        Planner</h1>
                    <p class="text-sm text-gray-400 dark:text-gray-500 font-body mt-0.5">Track your daily tasks</p>
                </div>
            </div>
            <x-primary-button wire:click="openCreateGoalModal">
                <i class="fa-solid fa-plus mr-2"></i>New Task
            </x-primary-button>
        </div>

        {{-- Filters --}}
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
            <div>
                <x-input-label for="status" value="Filter By Status" />
                <x-dropdown :options="$statuses" placeholder="All" model="filters.status" />
            </div>
            <div>
                <x-input-label for="priority" value="Filter By Priority" />
                <x-dropdown :options="$priorities" placeholder="All" model="filters.area" />
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="relative z-10 rounded-2xl border border-gray-100/50 dark:border-white/5 overflow-hidden">
        <table class="table-auto w-full">
            <thead>
                <x-table.table-row :header="true">
                    <x-table.table-header>Title</x-table.table-header>
                    <x-table.table-header>Assigned To</x-table.table-header>
                    <x-table.table-header>Priority</x-table.table-header>
                    <x-table.table-header>Status</x-table.table-header>
                    <x-table.table-header></x-table.table-header>
                </x-table.table-row>
            </thead>
            <tbody>
                @if ($tasks->isEmpty())
                    <x-table.table-row>
                        <x-table.table-data colspan="5"
                            class="text-center text-gray-400 dark:text-gray-500 text-lg py-16 font-body">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-white/5 flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-check-double text-2xl text-gray-300 dark:text-gray-600"></i>
                                </div>
                                <span class="font-heading font-bold">All clear!</span>
                                <span class="text-sm mt-1 text-gray-400">No tasks to display</span>
                            </div>
                        </x-table.table-data>
                    </x-table.table-row>
                @else
                    @foreach ($tasks as $task)
                        <x-table.table-row>
                            <x-table.table-data>
                                <span
                                    class="font-bold text-gray-900 dark:text-white">{{ Str::Limit($task->title, 20, '...') }}</span>
                            </x-table.table-data>
                            <x-table.table-data>{{ $task->assignedToUser->name }}</x-table.table-data>
                            <x-table.table-data>
                                <span
                                    class="px-3 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider {{ $this->setPriorityColor($task->priority) }}">{{ $task->priority }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span
                                    class="px-3 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider {{ $this->setStatusColor($task->status) }}">{{ $task->status }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <div class="flex items-center space-x-2">
                                    <button wire:click="openCreateTaskModal('{{ $task->id }}')"
                                        class="p-2 rounded-xl text-gray-400 hover:text-primaryColor hover:bg-primaryColor/5 transition-all duration-200">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <button
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
