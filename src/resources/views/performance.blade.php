<x-app-layout>
    <div class="space-y-10">
        <section>
            <livewire:performance.overview />
        </section>

        <div class="section-divider"></div>

        <section>
            <livewire:performance.traffic-trends />
        </section>

        <div class="section-divider"></div>

        <section>
            <livewire:performance.page-insights />
        </section>

        <div class="section-divider"></div>

        <section>
            <livewire:performance.user-insights />
        </section>

        <div class="section-divider"></div>

        <section>
            <livewire:performance.events-insights />
        </section>

        <livewire:modals.detailed-analytics />
    </div>
</x-app-layout>
