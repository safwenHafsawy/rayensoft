<x-app-layout>
    <div class="space-y-10">




        <section class="hidden md:block">
            <livewire:meetings.overview />
        </section>

        <div class="hidden md:block section-divider"></div>

        <section>
            <livewire:meetings.calendar />
        </section>

        <div class="section-divider"></div>

        <section>
            <livewire:meetings.meeting-table />
        </section>

        <livewire:modals.upsert-meeting />
    </div>
</x-app-layout>
