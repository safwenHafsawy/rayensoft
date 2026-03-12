<x-app-layout>
    <div class="space-y-10">




        <section class="hidden md:block">
            <livewire:finances.overview />
        </section>

        <div class="hidden md:block section-divider"></div>

        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <livewire:finances.bank_balance_details />
            <livewire:finances.transaction-table />
        </section>

        <livewire:modals.upsert-transaction />
    </div>
</x-app-layout>
