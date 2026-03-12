<div
    class="col-span-2 relative bg-gradient-to-br from-white/90 to-white dark:from-dark dark:to-dark/95 rounded-[1.2rem] p-4 sm:p-8 lg:p-10 shadow-2xl shadow-primaryColor/10 dark:shadow-dark border border-gray-100 dark:border-primaryColor-darker/30 transition-all duration-500 transform hover:shadow-primaryColor/20">
    <div
        class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
    </div>

    <div
        class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 pb-4 border-b border-gray-200 dark:border-dark-600">
        <h1
            class="text-2xl sm:text-3xl font-heading font-extrabold text-gray-900 dark:text-light flex items-center mb-4 sm:mb-0 transition-colors duration-300">
            <i class="fa-solid fa-right-left mr-3 text-primaryColor text-2xl"></i>
            Financial Transactions Table
        </h1>

        <div class="flex space-x-3">
            <x-primary-button loadingKey="openModal" icon="fa-solid fa-file-invoice-dollar"
                wire:click="openTransactionUpsertModal()">
                Add New Transaction
            </x-primary-button>
        </div>
    </div>

    <div class="w-full overflow-x-auto">
        <table class="w-full table-auto min-w-[600px] border-collapse">
            <thead>
                <x-table.table-row :header="true">
                    <x-table.table-header>Type</x-table.table-header>
                    <x-table.table-header>Amount</x-table.table-header>
                    <x-table.table-header>type</x-table.table-header>
                    <x-table.table-header>Date</x-table.table-header>
                </x-table.table-row>
            </thead>
            @if ($transactions->isEmpty())
                <x-table.table-row>
                    <x-table.table-data colspan="6"
                        class="text-center text-gray-400 dark:text-gray-500 text-xl py-16 font-body italic">
                        <i class="fa-solid fa-mug-hot mr-2"></i>
                        It's quiet... no transactions to display.
                    </x-table.table-data>
                </x-table.table-row>
            @else
                @foreach ($transactions as $transaction)
                    <x-table.table-row>
                        <x-table.table-data>{{ $transaction->type ?: '-' }}</x-table.table-data>
                        <x-table.table-data>
                            {{ $transaction->amount ?: '-' }}
                        </x-table.table-data>
                        <x-table.table-data>
                            {{ $transaction->type ?: '-' }}
                        </x-table.table-data>
                        <x-table.table-data>
                            {{ $transaction->date ?: '-' }}
                        </x-table.table-data>
                    </x-table.table-row>
                @endforeach
            @endif
        </table>
    </div>
    <div class="mt-8">
        {{ $transactions->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
