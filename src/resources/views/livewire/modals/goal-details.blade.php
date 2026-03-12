<div x-data="{ open: @entangle('isOpen') }" x-show="open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4">

    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/50 dark:bg-gray-900/70 transition-opacity backdrop-blur-sm"></div>

    <!-- Modal content -->
    <div class="relative bg-white dark:bg-dark rounded-2xl shadow-2xl overflow-hidden max-w-lg w-full transform transition-all">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Goal Details</h3>
            <button @click="open = false"
                    class="text-gray-400 dark:text-gray-300 hover:text-gray-600 dark:hover:text-white transition-colors rounded-full p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="px-6 py-5">
            @if ($goalDetails)
                <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach (['Title' => $goalDetails->title, 'Description' => $goalDetails->description,
                               'Start Date' => $goalDetails->start_date, 'End Date' => $goalDetails->end_date] as $label => $value)
                        <div class="py-4 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</dt>
                            <dd class="col-span-2 text-sm text-gray-900 dark:text-gray-100">
                                @if(str_contains($label, 'Date'))
                                    <span class="{{ $label === 'Start Date' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }} px-2 py-1 rounded-lg text-xs">
                                        {{ $value }}
                                    </span>
                                @else
                                    {{ $value }}
                                @endif
                            </dd>
                        </div>
                    @endforeach
                </dl>
            @else
                <div class="text-center py-8 text-gray-400 dark:text-gray-500">
                    <p class="text-sm italic">No details available for this goal.</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
            <button wire:click="closeModal"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg transition-colors shadow-sm">
                Exit
            </button>
        </div>

    </div>
</div>
