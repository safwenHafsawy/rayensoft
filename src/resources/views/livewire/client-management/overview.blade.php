<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <x-dashboard-summary-card title="Total Clients" icon="fa-solid fa-users"
        main_parameter="{{ $totalClientsData['thisMonthClients'] }}"
        change_per_month="{{ $totalClientsData['monthlyChangeInClients'] }}" change_unit="month" cumulative="true" />

    <x-dashboard-summary-card title="Conversion Rate" icon="fa-solid fa-chart-line"
        main_parameter="{{ $conversionRateData['ConversionRate'] }}%"
        change_per_month="{{ $conversionRateData['ChangeInConversionRate'] }}" change_unit="month" cumulative="true" />

    <x-dashboard-summary-card title="New Leads This Month" icon="fa-solid fa-user-plus"
        main_parameter="{{ $leadsData['thisMonthLeads'] }}"
        change_per_month="{{ $leadsData['monthlyChangeInLeads'] }}" />

    <x-dashboard-summary-card title="Follow-Ups Required" icon="fa-solid fa-history"
        main_parameter="{{ $leadsData['thisWeekFollowUps'] }}"
        change_per_month="{{ $leadsData['weeklyChangeInFollowUps'] }}" change_unit="week" />

</div>
