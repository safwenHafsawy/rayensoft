<x-modal x-cloak title="{{ $isEditing ? 'Update Transaction' : 'Add New Transaction' }}" for="transacions"
    record_id="{{ $transactionId }}" isEditing="{{ $isEditing }}">
    <form class="p-6" wire:submit.prevent="submit">

        <!-- Basic Information -->
        <section class="space-y-6">
            <h4
                class="text-sm uppercase tracking-wide font-semibold text-gray-600 dark:text-gray-400 border-b border-gray-200/50 dark:border-gray-700/50 pb-2">
                Transaction Details
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="amount" value="Transaction Amount" />
                    <x-text-input type="text" wire:model="transactionData.amount" id="amount" />
                    <x-input-error :messages="$errors->get('transactionData.amount')" />
                </div>
                <div>
                    <x-input-label for="date" value="Transaction Date" />
                    <x-date-picker model="transactionData.date" id="date" placeholder="Select date" />
                    <x-input-error :messages="$errors->get('transactionData.date')" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <x-input-label for="type" value="Transaction Method" />
                    <x-dropdown :options="$methods" placeholder="-- Select Method --" model="transactionData.method" />
                    <x-input-error :messages="$errors->get('transactionData.method')" />
                </div>
                <div>
                    <x-input-label for="type" value="Transaction Type" />
                    <x-dropdown :options="$types" placeholder="-- Select Type --" model="transactionData.type" />
                    <x-input-error :messages="$errors->get('transactionData.type')" />
                </div>

                @if ($transactionData['type'] === 'expense')
                    <div>
                        <x-input-label for="transaction_category" value="Transaction Category" />
                        <x-dropdown :options="$expenseCategory" placeholder="-- Select Category --"
                            model="transactionData.category" />
                        <x-input-error :messages="$errors->get('transactionData.category')" />
                    </div>
                @elseif($transactionData['type'] === 'income')
                    <div>
                        <x-input-label for="transaction_category" value="Transaction Category" />
                        <x-dropdown :options="$incomeCategory" placeholder="-- Select Category --"
                            model="transactionData.category" />
                        <x-input-error :messages="$errors->get('transactionData.category')" />
                    </div>
                @else
                    <div>
                        <x-input-label for="transaction_category" value="Transaction Category" />
                        <x-dropdown :options="[]" placeholder="-- Select Type First --"
                            model="transactionData.category" />
                        <x-input-error :messages="$errors->get('transactionData.category')" />
                    </div>
                @endif
            </div>

            <div>
                <x-input-label for="notes" value="Additional Notes" />
                <textarea wire:model="transactionData.notes" id="notes" rows="5"
                    placeholder="Add any relevant details or comments..."
                    class="w-full rounded-2xl px-4 py-3 bg-white/70 dark:bg-dark/50 border border-gray-300/40 dark:border-gray-700/60
                           focus:border-primaryColor focus:ring-2 focus:ring-primaryColor/20
                           text-gray-800 dark:text-gray-100 font-body placeholder-gray-400 dark:placeholder-gray-500
                           shadow-sm backdrop-blur-sm transition-all duration-200 resize-none"></textarea>
                <x-input-error :messages="$errors->get('transactionData.notes')" class="mt-2" />
            </div>
        </section>
    </form>
</x-modal>
