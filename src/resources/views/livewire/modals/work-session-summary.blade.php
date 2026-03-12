<div x-cloak x-data="{ open: $wire.entangle('isWorkSessionSummaryOpen') }"
     x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity"></div>

    <!-- Modal container -->
    <div class="relative w-full max-w-4xl mx-auto rounded-3xl bg-white/90 dark:bg-dark/90 shadow-2xl overflow-hidden backdrop-blur-xl border border-white/20 dark:border-gray-700 transform transition-all">

        <!-- Header -->
        <div class="flex items-center justify-between gap-4 px-8 py-5 bg-gradient-to-r from-primaryColor/20 to-accentColor/20 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <svg class="w-7 h-7 text-primaryColor dark:text-accentColor" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 id="modal-title" class="text-xl font-semibold text-gray-900 dark:text-gray-100 leading-6">
                        Work Session Summary
                    </h3>
                    <p id="modal-desc" class="text-sm text-gray-500 dark:text-gray-300">
                        Quick recap and notes for this session
                    </p>
                </div>
            </div>

            <!-- Close -->
            <button type="button" wire:click="closeModal"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100/50 dark:hover:bg-gray-800 transition-all focus:outline-none">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="px-8 py-6 space-y-6">

            <!-- Congrats + Session Summary -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">🎉 Great job — session complete</h4>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                        Your focus makes a real difference. Thank you for moving our goals forward.
                    </p>
                </div>

                @if (!empty($workSession))
                    <div class="flex flex-wrap md:flex-row items-center gap-3">
                        <!-- Start -->
                        <div class="flex items-center gap-2 px-4 py-2 bg-white/80 dark:bg-dark/80 rounded-xl shadow border border-gray-200 dark:border-gray-700">
                            <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-xs text-gray-600 dark:text-gray-300">
                                <div>Start</div>
                                <div class="font-medium">{{ \Carbon\Carbon::parse($workSession['check_in_time'])->format('g:i A') }}</div>
                            </div>
                        </div>

                        <!-- End -->
                        <div class="flex items-center gap-2 px-4 py-2 bg-white/80 dark:bg-dark/80 rounded-xl shadow border border-gray-200 dark:border-gray-700">
                            <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                            </svg>
                            <div class="text-xs text-gray-600 dark:text-gray-300">
                                <div>End</div>
                                <div class="font-medium">{{ \Carbon\Carbon::parse($workSession['check_out_time'])->format('g:i A') }}</div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primaryColor/20 to-accentColor/20 rounded-xl border border-primaryColor shadow-md">
                            <div class="text-xs text-primaryColor dark:text-accentColor">
                                <div>Total</div>
                                <div class="font-semibold">{{ gmdate('H:i:s', ($totalWorkedTime ?? 0) * 60) }}</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <hr class="border-t border-gray-200 dark:border-gray-700">

            <!-- Goals Chips -->
            <div>
                <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                    Goals worked on this session
                </h5>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @forelse ($userGoals as $goal)
                        <label for="goal-{{ $goal['id'] }}"
                               class="relative flex items-center gap-3 px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 cursor-pointer hover:shadow-lg transition-all focus-within:ring-2 focus-within:ring-primaryColor">
                            <input type="checkbox" id="goal-{{ $goal['id'] }}" value="{{ $goal['id'] }}"
                                   wire:model="summaryData.goalsWorkedOn" class="peer sr-only">

                            <!-- Custom Check -->
                            <span class="w-6 h-6 flex items-center justify-center rounded-lg border peer-checked:bg-primaryColor peer-checked:border-primaryColor transition-all">
                                <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transform scale-90 peer-checked:scale-100 transition-all"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>

                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate">{{ $goal['title'] }}</div>
                            </div>
                        </label>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No goals found.</p>
                    @endforelse
                </div>
                <x-input-error :messages="$errors->get('summaryData.goalsWorkedOn')" />
            </div>

            <hr class="border-t border-gray-200 dark:border-gray-700">

            <!-- Notes -->
            <div class="w-full">
                <x-input-label for="summary" value="Work Session Summary" />
                <textarea
                    wire:model="summaryData.summary"
                    id="summary"
                    rows="5"
                    placeholder="Add any relevant details or comments..."
                    class="w-full rounded-2xl px-4 py-3 bg-white/70 dark:bg-dark/50 border border-gray-300/40 dark:border-gray-700/60
                           focus:border-primaryColor focus:ring-2 focus:ring-primaryColor/20
                           text-gray-800 dark:text-gray-100 font-body placeholder-gray-400 dark:placeholder-gray-500
                           shadow-sm backdrop-blur-sm transition-all duration-200 resize-none"
                ></textarea>
                <x-input-error :messages="$errors->get('summaryData.summary')" />
            </div>

        </div>

        <!-- Footer -->
        <div class="flex items-center justify-end gap-4 px-8 py-5 border-t border-gray-200 dark:border-gray-700">
            <button type="button" wire:click="closeModal"
                    class="rounded-md px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all focus:outline-none">
                Cancel
            </button>
            <x-primary-button type="button" wire:click="saveSummary" wire:loading.attr="disabled"
                    wire:target="saveSummary">
                Finish My Session
            </x-primary-button>
        </div>
    </div>

</div>
