<div x-data="{ open: $wire.entangle('isOpen') }"
     x-show="open"
     x-transition:enter="transition ease-out duration-400"
     x-transition:enter-start="opacity-0 scale-90 blur-sm"
     x-transition:enter-end="opacity-100 scale-100 blur-none"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90"
     class="fixed inset-0 z-50 flex items-center justify-center p-6"
     role="dialog" aria-modal="true" aria-labelledby="modal-title">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gradient-to-br from-black/40 via-black/20 to-transparent backdrop-blur-md"></div>

    <!-- Modal -->
    <div class="relative w-full max-w-6xl bg-white/70 dark:bg-dark/60 backdrop-blur-2xl
                rounded-3xl shadow-[0_8px_40px_rgba(0,0,0,0.15)]
                border border-white/20 dark:border-gray-800 overflow-hidden
                transition-all duration-300 ease-out"
         @keydown.escape.window="$wire.isOpen = false">

        <!-- Header -->
        <header class="flex items-center justify-between px-8 py-5 border-b border-gray-200/30 dark:border-white/10 bg-gradient-to-r from-primaryColor/5 to-transparent">
            <h3 id="modal-title" class="text-xl font-semibold font-heading text-gray-900 dark:text-white tracking-wide flex items-center gap-3">
                Performance Insights
            </h3>

            <button @click="$wire.isOpen = false" aria-label="Close"
                    class="text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white
                           p-2 rounded-full hover:bg-gray-200/60 dark:hover:bg-white/10 transition">
                ✕
            </button>
        </header>

        <!-- Body -->
        <div class="px-8 py-6 max-h-[70vh] overflow-y-auto">
            <div class="overflow-x-auto rounded-2xl border border-gray-200/30 dark:border-gray-700 shadow-inner bg-white/60 dark:bg-dark/40 backdrop-blur-xl">
                <table class="min-w-full text-sm divide-y divide-gray-200/40 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-gray-50/70 to-gray-100/50 dark:from-dark/60 dark:to-dark/50">
                    <x-table.table-row :header="true">
                        <x-table.table-header class="font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">{{ $dimension }}</x-table.table-header>
                        @foreach(array_keys($metrics) as $head)
                            <x-table.table-header class="font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">{{ $head }}</x-table.table-header>
                        @endforeach
                    </x-table.table-row>
                    </thead>

                    <tbody class="divide-y divide-gray-100/30 dark:divide-gray-800">
                    @foreach($paginatedData as $dataRowKey => $dataRowValues)
                        <x-table.table-row class="hover:bg-primaryColor/5 dark:hover:bg-primaryColor/10 transition-colors">
                            <x-table.table-data class="px-5 py-3 text-gray-900 dark:text-white font-medium">{{ $dataRowKey }}</x-table.table-data>
                            @foreach($dataRowValues as $dataRowValue)
                                <x-table.table-data class="px-5 py-3 text-right text-gray-700 dark:text-gray-400">{{ $dataRowValue }}</x-table.table-data>
                            @endforeach
                        </x-table.table-row>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-between items-center text-sm">
                <div class="text-gray-500 dark:text-gray-400">
                    Showing <span class="font-medium text-gray-700 dark:text-gray-200">{{ count($paginatedData) }}</span> rows
                </div>
                <div class="dark:[&>nav>div>span]:!text-gray-300">
                    {{ $paginatedData->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="px-8 py-4 bg-gradient-to-r from-gray-50/80 to-transparent dark:from-dark/50 border-t border-gray-200/30 dark:border-gray-800 flex justify-end">
            <x-primary-button wire:click="closeModal">
                Close
            </x-primary-button>
        </footer>
    </div>
</div>

<script>
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') Livewire.dispatch('closeModal');
    });
</script>
