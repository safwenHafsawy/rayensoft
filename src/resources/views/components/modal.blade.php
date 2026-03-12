@props([
    'for' => '',
    'title' => '',
    'isEditing' => '',
    'record_id' => '',
    'size' => '',
])

<div x-data="{ open: $wire.entangle('isOpen') }" x-show="open" x-cloak x-effect="document.body.classList.toggle('overflow-hidden', open)"
    x-on:keydown.escape.window="$wire.closeModal()" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
    aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" x-on:click="$wire.closeModal()"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <!-- Modal content -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-[0.97]"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-[0.97]"
        class="relative w-full max-w-3xl bg-light dark:bg-dark border border-gray-200/30 dark:border-white/10 shadow-2xl rounded-2xl overflow-hidden will-change-transform">

        {{-- Top accent line --}}
        <div class="absolute top-0 left-0 right-0 h-[2px] premium-gradient"></div>

        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg premium-gradient flex items-center justify-center">
                    <i class="fa-solid fa-pen-to-square text-white text-xs"></i>
                </div>
                <h3 id="modal-title" class="text-base font-heading font-bold text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>
            </div>
            <button wire:click="closeModal"
                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-white/5 dark:hover:text-gray-300 transition-colors duration-150">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="relative text-gray-700 dark:text-gray-200 max-h-[65vh] overflow-y-auto">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div
            class="flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-0 px-6 py-4 border-t border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-black/10">

            <!-- Delete button -->
            @if ($isEditing && $for !== 'Tasks' && $for !== 'Goals')
                <button wire:click="deleteRecord('{{ $record_id }}')" type="button"
                    class="inline-flex items-center text-red-500 bg-red-500/10 border border-red-500/20 hover:text-white hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300/30 font-heading font-bold text-sm uppercase tracking-wider rounded-xl px-5 py-2 transition-all duration-300">
                    <i class="fa-solid fa-trash mr-2"></i>
                    Delete {{ $for }}
                </button>
            @endif

            <div class="flex space-x-3">
                <button wire:click="closeModal"
                    class="rounded-xl px-5 py-2 font-heading font-bold text-sm uppercase tracking-wider text-gray-500 dark:text-gray-400 border border-gray-200/50 dark:border-white/10 hover:bg-gray-100/50 dark:hover:bg-white/5 transition-colors duration-150">
                    Cancel
                </button>

                <x-primary-button loadingKey="saveForm" wire:click="submit">
                    {{ $title }}
                </x-primary-button>
            </div>
        </div>
    </div>
</div>
