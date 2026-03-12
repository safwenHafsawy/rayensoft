<x-app-layout>
    <div class="space-y-10">
        <section class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            <livewire:team.work-session-timer />
            <livewire:team.achieved-goals-chart />
        </section>

        <div class="section-divider"></div>

        <section class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            <livewire:team.team-workload-distribution />
            <livewire:team.failed-goals-chart />
        </section>

        <div class="section-divider"></div>

        <section class="grid grid-cols-1 xl:grid-cols-[60%_1fr] gap-8">
            <livewire:team.goals-table />
            <livewire:team.personal-todos />
        </section>

        <livewire:modals.upsert-goal />
        <livewire:modals.goals-history />
        <livewire:modals.goal-details />
        <livewire:modals.work-session-summary />
    </div>
</x-app-layout>
