<x-app-layout>
    <div class="space-y-10">


        <section class="hidden md:block">
            <livewire:client-management.overview />
        </section>

        <section>
            <x-tab-manager />
        </section>
        <livewire:modals.upsert-lead />
    </div>
</x-app-layout>
