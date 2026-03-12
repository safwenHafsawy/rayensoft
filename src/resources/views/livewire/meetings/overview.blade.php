<div class="mx-20 grid grid-cols-3 gap-4">
    <x-dashboard-summary-card title="Monthly Meetings" icon="fa-solid fa-calendar-days"
                              main_parameter="{{ $monthlyMeetings['monthly_meetings'] }}"
                              change_per_month="{{ $monthlyMeetings['monthly_change'] }}" metric="week"
                              class="shadow-lg hover:shadow-xl transition-shadow duration-200" />

    <x-dashboard-summary-card title="Pending Monthly Meetings" icon="fa-solid fa-hourglass-half"
                              main_parameter="{{ $monthlyMeetings['this_month_pending'] }}"
                              change_per_month="{{ $monthlyMeetings['monthly_pending_change'] }}"
                              class="shadow-lg hover:shadow-xl transition-shadow duration-200" />

    <x-dashboard-summary-card title="Pending Weekly Meetings" icon="fa-solid fa-calendar-week"
                              main_parameter="{{ $weeklyMeetings['this_week_pending'] }}"
                              change_per_month="{{ $weeklyMeetings['weekly_pending_change'] }}"
                              class="shadow-lg hover:shadow-xl transition-shadow duration-200" />
</div>
