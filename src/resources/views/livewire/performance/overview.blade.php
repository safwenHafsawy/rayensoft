<div class="px-4">

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-lg font-extrabold font-heading text-gray-900 dark:text-gray-100 mb-2">
            Analytics Overview
        </h2>
        <p class="text-gray-500 font-body dark:text-gray-400 text-sm">{{ \Carbon\Carbon::now()->format('F Y') }}</p>
    </div>
    <!-- First Row Cards -->
    <div class="mx-0 sm:mx-12 grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Total Visits -->
        <x-dashboard-summary-card title="Total Visits" icon="fa-solid fa-users" :main_parameter="$currentMonthData['totalVisits'] ?? 0" :changeValue="$totalVisitsChange ?? 0"
            :change_per_month="$this->calculatePercentageChange(
                $currentMonthData['totalVisits'] ?? 0,
                $previousMonthData['totalVisits'] ?? 0,
            )" class="hover:scale-105 transition-transform duration-300" />

        <!-- Unique Visitors -->
        <x-dashboard-summary-card title="Unique Visitors" icon="fa-solid fa-user-check" :main_parameter="$currentMonthData['uniqueUsers'] ?? 0"
            :changeValue="$uniqueVisitorsChange ?? 0" :change_per_month="$this->calculatePercentageChange(
                $currentMonthData['uniqueUsers'] ?? 0,
                $previousMonthData['uniqueUsers'] ?? 0,
            ) ?? 0" class="hover:scale-105 transition-transform duration-300" />

        <!-- First Time Visits -->
        <x-dashboard-summary-card title="First Time Visits" icon="fa-solid fa-user-plus" :main_parameter="$currentMonthData['newUsers'] ?? 0"
            :changeValue="$firstTimeVisitsChange ?? 0" :change_per_month="$this->calculatePercentageChange(
                $currentMonthData['newUsers'] ?? 0,
                $previousMonthData['newUsers'] ?? 0,
            ) ?? 0" class="hover:scale-105 transition-transform duration-300" />
    </div>

    <!-- Second Row Cards -->
    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 mt-8 sm:mt-12">
        <x-dashboard-summary-card title="Avg. Bounce Rate" icon="fa-solid fa-chart-line" :main_parameter="isset($currentMonthData['AvgBounceRate']) ? $currentMonthData['AvgBounceRate'] . '%' : '0%'"
            :changeValue="$bounceRateChange ?? 0" :change_per_month="$this->calculatePercentageChange(
                $currentMonthData['AvgBounceRate'] ?? 0,
                $previousMonthData['AvgBounceRate'] ?? 0,
            ) ?? 0" class="hover:scale-105 transition-transform duration-300" />

        <x-dashboard-summary-card title="Avg. Engagement Rate" icon="fa-solid fa-hand-pointer" :main_parameter="isset($currentMonthData['engagementRate']) ? $currentMonthData['engagementRate'] . '%' : '0%'"
            :changeValue="$engagementRateChange ?? 0" :change_per_month="$this->calculatePercentageChange(
                $currentMonthData['engagementRate'] ?? 0,
                $previousMonthData['engagementRate'] ?? 0,
            ) ?? 0" class="hover:scale-105 transition-transform duration-300" />

        <x-dashboard-summary-card title="Avg. Session Duration" icon="fa-solid fa-clock" :main_parameter="$currentMonthData['avgVisitDuration']
            ? gmdate('i:s', $currentMonthData['avgVisitDuration'])
            : '00:00'"
            :changeValue="$avgSessionDurationChange ?? 0" :change_per_month="$this->calculatePercentageChange(
                $currentMonthData['avgVisitDuration'] ?? 0,
                $previousMonthData['avgVisitDuration'] ?? 0,
            ) ?? 0" class="hover:scale-105 transition-transform duration-300" />

        <x-dashboard-summary-card title="Avg. Pages per Visit" icon="fa-solid fa-file-lines" :main_parameter="$currentMonthData['avgPagePerSession'] ?? '0'"
            :changeValue="$avgPagesPerSessionChange ?? 0" :change_per_month="$this->calculatePercentageChange(
                $currentMonthData['avgPagePerSession'] ?? 0,
                $previousMonthData['avgPagePerSession'] ?? 0,
            ) ?? 0" class="hover:scale-105 transition-transform duration-300" />
    </div>

</div>
