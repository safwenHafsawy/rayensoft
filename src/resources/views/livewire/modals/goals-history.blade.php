<div x-data="{ open: $wire.entangle('isOpen') }" x-show="open"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
     aria-modal="true">

    <div class="flex items-center justify-center min-h-screen p-4 text-left sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500/50 dark:bg-black/60 backdrop-blur-sm transition-opacity"></div>

        <!-- Modal content -->
        <div
            class="relative bg-white dark:bg-dark/80 rounded-2xl shadow-2xl overflow-hidden transform transition-all sm:w-9/12 max-h-[90vh]">
            <!-- Header -->
            <h3 class="text-lg font-heading font-semibold text-gray-800 dark:text-gray-100 px-6 py-4 border-b border-gray-200/50 dark:border-gray-700/50">
                Goals History
            </h3>

            <div class="p-6 space-y-6 overflow-y-auto max-h-[70vh]">
                <!-- Filters -->
                <div
                    class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-gray-50 dark:bg-dark/70 p-4 rounded-xl shadow-sm">
                    <!-- Date Filters -->
                    <div class="flex flex-wrap gap-2">
                        @foreach([
                            '-1' => 'Previous Week',
                            '-2' => '2 Weeks Ago',
                            'this_month' => 'This Month',
                            'prev_month' => 'Previous Month',
                            '3_month' => '3 Months'
                        ] as $key => $label)
                            <button wire:click="filterByDate('{{ $key }}')"
                                    class="p-4 text-sm font-medium rounded-lg border transition-all duration-200
                                           {{ $activeDateFilter === $key
                                               ? 'bg-primaryColor text-white border-primaryColor'
                                               : 'text-primaryColor border-primaryColor hover:bg-primaryColor hover:text-white' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>

                    <!-- User & Status Filters -->
                    <div class="flex flex-col md:flex-row md:gap-4 flex-1">
                        <x-dropdown :options="$users" placeholder="-- Select User --" model="filters.user"
                                    associative="true"/>
                        <x-dropdown :options="['Achieved', 'Failed']" placeholder="-- Select Status--" model="filters.status"/>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-100 dark:bg-dark/70">
                        <tr>
                            @foreach(['Title', 'Start Date', 'End Date', 'Area', 'Status'] as $col)
                                <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ $col }}
                                </th>
                            @endforeach
                            <th class="px-4 py-3"></th>
                        </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-dark/80 divide-y divide-gray-200 dark:divide-gray-700">
                        @if($goals->isEmpty())
                            <x-table.table-row>
                                <x-table.table-data colspan="6"
                                                    class="text-center text-gray-400 dark:text-gray-500 text-xl py-16 font-body italic">
                                    <i class="fa-solid fa-mug-hot mr-2"></i>
                                    It's quiet... no leads to display.
                                </x-table.table-data>
                            </x-table.table-row>
                        @else
                            @forelse ($goals as $goal)
                                <tr class="hover:bg-gray-50 dark:hover:bg-dark/60 transition-colors duration-150">
                                    <td class="px-4 py-2 font-body">{{ Str::limit($goal['title'], 40, '...') }}</td>
                                    <td class="px-4 py-2 font-body">{{ $goal['start_date'] }}</td>
                                    <td class="px-4 py-2 font-body">{{ $goal['end_date'] }}</td>
                                    <td class="px-4 py-2 font-body">{{ $goal['area'] }}</td>
                                    <td class="px-4 py-2 font-body">
                                    <span
                                        class="px-2 py-1 rounded-lg font-bold {{ $this->setStatusColor($goal['status']) }}">
                                        {{ $goal['status'] }}
                                    </span>
                                    </td>
                                    <td class="px-4 py-2 flex gap-2">
                                        <button wire:click="showDetails('{{ $goal['id'] }}')"
                                                class="text-gray-500 hover:text-primaryColor transition">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                        <button wire:click="recreatedGoal('{{ $goal['id'] }}')"
                                                class="text-gray-500 hover:text-primaryColor transition">
                                            <i class="fa-solid fa-arrow-rotate-right"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="text-center py-20 text-gray-400 dark:text-gray-500 font-body text-lg">
                                        You Had No {{ $filters['status'] }} Goals During This Period
                                        <br>
                                        <span class="text-sm text-gray-300 dark:text-gray-600">
                                        from {{ $filters['date']['start'] }} to {{ $filters['date']['end'] }}
                                    </span>
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button wire:click="closeModal"
                        class="px-6 py-2 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-medium hover:bg-gray-100 dark:hover:bg-dark/60 focus:outline-none focus:ring-2 focus:ring-primaryColor/30 transition">
                    Close History
                </button>
            </div>
        </div>
    </div>

    <livewire:modals.goal-details/>
</div>
