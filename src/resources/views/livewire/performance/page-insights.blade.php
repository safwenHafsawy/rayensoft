<div class="mt-6 pt-4 w-full">

    <!-- Section Header -->
    <div class="w-full flex flex-col md:flex-row md:justify-between md:items-center py-4 px-6 gap-4">
        <!-- Title Section -->
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold font-heading text-gray-900 dark:text-gray-100">Pages Insights</h2>
            <p class="text-sm font-body text-gray-500 dark:text-gray-400 mt-1">Overview of pages performance over
                selected periods</p>
        </div>
        <div class="w-full md:w-auto">
            <select id="pageDataTimeframe" wire:model.live="pageDataTimeframe"
                class="w-full md:w-auto px-8 py-2 text-sm border rounded-xl font-medium font-body shadow-sm
               text-gray-700 dark:text-gray-200
               bg-white dark:bg-dark/50
               border-gray-300 dark:border-gray-600
               focus:ring-2 focus:ring-primaryColor focus:outline-none
               transition-all duration-300 hover:scale-105">
                <option value="yesterday">One Day Ago</option>
                <option value="7daysAgo">Last 7 days</option>
                <option value="30daysAgo">Last 30 days</option>
                <option value="90daysAgo">Last 90 days</option>
                <option value="180daysAgo">Last 180 days</option>
                <option value="365daysAgo">Last 365 days</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Data storage for charts -->
        <div id="page-insights-charts-data" hidden wire:key="page-insights-charts-data-{{ $pageDataTimeframe }}"
            data-visits-labels='@json(array_keys($topPerformingPages))' data-visits-data='@json(array_values($topPerformingPages))'
            data-engagement-labels='@json(array_keys($engagementTimePerPage))' data-engagement-data='@json(array_values($engagementTimePerPage))'
            data-timeframe='{{ $pageDataTimeframe }}'>
        </div>

        <div
            class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
            </div>
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
                <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Most Visited Pages</h2>
            </div>
            <!-- Chart -->
            <div class="relative h-64">
                <canvas id="top-performing-pages" wire:ignore></canvas>
            </div>
        </div>

        <!-- Engagement Time per Page -->
        <div
            class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
            </div>
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
                <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Top Pages by Engagement
                    Duration</h2>
            </div>

            <!-- Chart -->
            <div class="relative h-64">
                <canvas id="engagement-time-per-page" wire:ignore></canvas>
            </div>
        </div>
    </div>
    <div
        class="w-full mt-8 relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-2 overflow-hidden hover:shadow-2xl transition-all duration-500">
        <div
            class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
        </div>
        <div class="relative p-2 sm:p-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
                <h2 class="text-2xl font-bold font-heading text-gray-900 dark:text-gray-100">Page Performance Metrics
                </h2>
            </div>
            <div class="relative rounded-2xl overflow-hidden border border-gray-200/40 shadow-sm overflow-x-auto">
                <table id="visitors-table" class="min-w-full divide-y divide-gray-200/30">
                    <x-table.table-row :header="true">
                        <x-table.table-header>Page Path</x-table.table-header>
                        <x-table.table-header>Number of Visits (% of Total)</x-table.table-header>
                        <x-table.table-header>Engagement Time</x-table.table-header>
                        <x-table.table-header>Engagement Rate</x-table.table-header>
                        <x-table.table-header>Event Count</x-table.table-header>
                        <x-table.table-header>Active Visitors</x-table.table-header>
                        <x-table.table-header></x-table.table-header>
                    </x-table.table-row>
                    <tbody>
                        @foreach ($paginatedData as $page => $data)
                            <x-table.table-row>
                                <x-table.table-data title="{{ $page }}">
                                    {{ Str::limit($page, 30) }}
                                </x-table.table-data>
                                <x-table.table-data>
                                    <div class="flex flex-col space-y-1">
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-dark/50 dark:text-light/60 font-semibold">{{ number_format($data['numberOfVisits']) }}</span>
                                            <span
                                                class="text-primaryColor font-semibold">{{ round(($data['numberOfVisits'] / $totalVisitors) * 100, 2) }}%</span>
                                        </div>
                                        <div
                                            class="h-2 w-full bg-gray-200 dark:bg-primaryColor-darker/30 rounded-full overflow-hidden">
                                            <div class="h-2 bg-gradient-to-r from-primaryColor to-accentColor rounded-full transition-all duration-500"
                                                style="width: {{ round(($data['numberOfVisits'] / $totalVisitors) * 100, 2) }}%">
                                            </div>
                                        </div>
                                    </div>
                                </x-table.table-data>

                                <x-table.table-data>
                                    {{ $data['engagementTime'] }} seconds
                                </x-table.table-data>
                                <x-table.table-data>
                                    {{ $data['engagementRate'] }}%
                                </x-table.table-data>
                                <x-table.table-data>
                                    {{ $data['eventCount'] }}
                                </x-table.table-data>
                                <x-table.table-data>
                                    {{ $data['activeUsers'] }}
                                </x-table.table-data>
                            </x-table.table-row>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 px-6">
                    {{ $paginatedData->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        let visitsPageChart = null;
        let engagementChart = null;

        function updateChart() {
            const visitedCtx = document.getElementById('top-performing-pages')?.getContext('2d');
            const engagementCtx = document.getElementById('engagement-time-per-page')?.getContext('2d');

            if (!visitedCtx || !engagementCtx) {
                console.error('Canvas elements not found');
                return;
            }

            // Destroy old charts
            if (visitsPageChart) visitsPageChart.destroy();
            if (engagementChart) engagementChart.destroy();
            visitsPageChart = null;
            engagementChart = null;

            // Read fresh data from the hidden div
            const dataEl = document.getElementById('page-insights-charts-data');
            if (!dataEl) {
                console.error('Charts data element not found');
                return;
            }

            let pageLabels, pagesData, pageEngagementLabels, pageEngagementData;
            try {
                pageLabels = JSON.parse(dataEl.dataset.visitsLabels);
                pagesData = JSON.parse(dataEl.dataset.visitsData);
                pageEngagementLabels = JSON.parse(dataEl.dataset.engagementLabels);
                pageEngagementData = JSON.parse(dataEl.dataset.engagementData);
            } catch (e) {
                console.error('Failed to parse chart data:', e);
                return;
            }

            // Top Performing Pages Chart
            visitsPageChart = Window.chartsConfigs.createChart(visitedCtx, {
                type: 'horizontalBar',
                dataList: [{
                    label: 'Number Of Visits For',
                    data: pagesData
                }],
                label: pageLabels,
                tooltipSuffix: '',
            });

            // Engagement Time per Page Chart
            engagementChart = Window.chartsConfigs.createChart(engagementCtx, {
                type: 'verticalBar',
                dataList: [{
                    label: 'Engagement Duration',
                    data: pagesData
                }],
                label: pageEngagementLabels,
                tooltipSuffix: '',
            });
        }

        // Initial render
        updateChart();

        // Listen for Livewire event with a slight delay
        Livewire.on('update-charts', () => {
            // Delay to ensure DOM is fully updated
            setTimeout(() => {
                updateChart();
            }, 100);
        });
    </script>
@endscript
