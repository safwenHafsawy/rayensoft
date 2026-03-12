<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <x-dashboard-summary-card title="New Leads This Week" icon="fa-solid fa-user-plus"
        main_parameter="{{ $this->leads['leads_this_week'] }}"
        change_per_month="{{ $this->leads['leads_weekly_change'] }} %" changeUnit="week" unit="%" />

    {{--    <x-dashboard-summary-card title="Clients Acquired This Month" icon="fa-solid fa-user-check" --}}
    {{--                              main_parameter="{{ $this->leads['clients_this_month'] }}" --}}
    {{--                              change_per_month="{{ $this->leads['clients_monthly_change'] }}" /> --}}

    <x-dashboard-summary-card title="Active Projects" icon="fa-solid fa-briefcase"
        main_parameter="{{ $this->projects['ongoing'] }}"
        change_per_month="{{ $this->projects['projects_monthly_change'] }}" />

    <x-dashboard-summary-card title="Pending Follow-Ups" icon="fa-solid fa-calendar-check"
        main_parameter="{{ $this->leads['pending_follow_ups'] }}" change_per_month="0" />

    <x-dashboard-summary-card title="Weekly Meetings" icon="fa-solid fa-handshake"
        main_parameter="{{ $this->meetings['weekly_meetings'] }}"
        change_per_month="{{ $this->meetings['weekly_meetings_change'] }}" changeUnit="week" />
</div>
