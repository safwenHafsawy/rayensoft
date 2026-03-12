<div class="mt-6 w-full">

    <!-- Section Header -->
    <div class="w-full flex flex-col md:flex-row md:justify-between md:items-center py-4 px-6 gap-4">
        <!-- Title Section -->
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Traffic Trends Insights</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Overview of user activity over selected periods</p>
        </div>

        <!-- Selector Section -->
        <div class="relative w-full md:w-auto">
            <select id="trafficTimeframe" wire:model.live="trafficTimeframe"
                class="w-full md:w-auto px-8 py-2 border rounded-xl font-medium font-body shadow-sm
               text-gray-700 dark:text-gray-200
               bg-white dark:bg-dark/50
               border-gray-300 dark:border-gray-600
               focus:ring-2 focus:ring-primaryColor focus:outline-none
               transition-all duration-300 hover:scale-105">
                <option value="yesterday">One Day Ago</option>
                <option value="7daysAgo">Last 7 days</option>
                <option value="30daysAgo">Last 30 days</option>
                <option value="60daysAgo">Last 60 days</option>
            </select>
        </div>
    </div>

    <div class="mx-0 sm:mx-12 grid grid-cols-1 gap-6">
        <!-- Daily Visitors / Engaged Visitors Chart -->
        <div
            class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
            </div>

            <h2 class="text-lg font-extrabold font-heading text-gray-900 dark:text-gray-100 mb-4">Daily Visits Overview
            </h2>
            <div wire:ignore class="relative h-64">
                <canvas id="daily-visits"></canvas>
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Session Landing Pages Chart -->
        <div
            class="w-full flex flex-col relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-3xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
            </div>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Top Landing Pages</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-body">Pages visitors land on first</p>
                </div>
                <button wire:click="openDetailedAnalyticsModal('LandingPage')"
                    class="text-sm font-medium text-gray-600 dark:text-gray-400
                               hover:text-primaryColor dark:hover:text-primaryColor
                               transition-all duration-300 ease-out flex items-center gap-1.5 group">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <div wire:ignore class="relative h-64">
                <canvas class="max-h-96" id="session-landing-pages"></canvas>
            </div>
        </div>

        <!-- Session Source Chart -->
        <div
            class="w-full flex flex-col relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-3xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
            </div>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Top Visit Source</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-body">Where visitors are coming from
                    </p>
                </div>
                <button wire:click="openDetailedAnalyticsModal('sessionSource')"
                    class="text-sm font-medium text-gray-600 dark:text-gray-400
                               hover:text-primaryColor dark:hover:text-primaryColor
                               transition-all duration-300 ease-out flex items-center gap-1.5 group">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <div wire:ignore class="relative h-64">
                <canvas id="session-sources"></canvas>
            </div>
        </div>

        <!-- Session Medium Chart -->
        <div
            class="w-full flex flex-col relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-3xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
            </div>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Top Visit Mediums</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-body">How visitors find the site</p>
                </div>
                <button wire:click="openDetailedAnalyticsModal('sessionMedium')"
                    class="text-sm font-medium text-gray-600 dark:text-gray-400
                               hover:text-primaryColor dark:hover:text-primaryColor
                               transition-all duration-300 ease-out flex items-center gap-1.5 group">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <div wire:ignore class="relative h-64">
                <canvas id="session-mediums"></canvas>
            </div>
        </div>
    </div>
    <div id="traffic-charts-data" hidden wire:key="traffic-charts-data-{{ $trafficTimeframe }}"
        data-visits-labels='@json(array_values($trafficMonthLabels))' data-visits-data='@json(array_values($totalVisits))'
        data-engagement-data='@json(array_values($engagementVisits))' data-sources-labels='@json(array_keys($sessionSource))'
        data-sources-data='@json(array_values($sessionSource))' data-mediums-labels='@json(array_keys($sessionMedium))'
        data-mediums-data='@json(array_values($sessionMedium))' data-landing-labels='@json(array_keys($sessionLandingPages))'
        data-landing-values='@json(array_values($sessionLandingPages))' data-timeframe='{{ $trafficTimeframe }}'>
    </div>
</div>
@script
    <script>
        let trafficChart = {
            dailyVisits: null,
            sources: null,
            mediums: null,
            landingPages: null,
        }

        function updateTrafficCharts() {
            const dailyVisitsCtx = document.getElementById('daily-visits').getContext('2d');
            const sourceCtx = document.getElementById('session-sources').getContext('2d');
            const landingPageCtx = document.getElementById('session-landing-pages').getContext('2d');
            const mediumsCtx = document.getElementById('session-mediums').getContext('2d');

            // destroy old chart
            if (trafficChart.dailyVisits) trafficChart.dailyVisits.destroy();
            if (trafficChart.sources) trafficChart.sources.destroy();
            if (trafficChart.mediums) trafficChart.mediums.destroy();
            if (trafficChart.landingPages) trafficChart.landingPages.destroy();

            trafficChart = {
                dailyVisits: null,
                sources: null,
                mediums: null,
                landingPages: null,
            }

            if (!dailyVisitsCtx || !sourceCtx || !landingPageCtx || !mediumsCtx) {
                console.error('Canvas elements not found');
                return;
            }

            const trafficDataEl = document.getElementById('traffic-charts-data');

            let dailyVisitsTot, dailyEngVisits, trafficMonthLabels, sourceLabels, sourceValues, landingPagesLabels,
                landingPagesValues, mediumValues, mediumLabels;

            try {
                dailyVisitsTot = JSON.parse(trafficDataEl.dataset.visitsData);
                dailyEngVisits = JSON.parse(trafficDataEl.dataset.engagementData);
                trafficMonthLabels = JSON.parse(trafficDataEl.dataset.visitsLabels);

                sourceLabels = JSON.parse(trafficDataEl.dataset.sourcesLabels);
                sourceValues = JSON.parse(trafficDataEl.dataset.sourcesData);

                landingPagesLabels = JSON.parse(trafficDataEl.dataset.landingLabels);
                landingPagesValues = JSON.parse(trafficDataEl.dataset.landingValues);

                mediumLabels = JSON.parse(trafficDataEl.dataset.mediumsLabels);
                mediumValues = JSON.parse(trafficDataEl.dataset.mediumsData);

            } catch (e) {
                console.error('Failed to parse chart data:', e);
                return;
            }

            // ---- Daily Visits Chart ----
            trafficChart.dailyVisits = Window.chartsConfigs.createChart(dailyVisitsCtx, {
                type: 'line',
                dataList: [{
                    label: 'Total visits',
                    data: dailyVisitsTot
                }, {
                    label: 'Total engagements',
                    data: dailyEngVisits
                }],
                label: trafficMonthLabels,
                tooltipSuffix: 'month',
            })

            // ---- Session Sources Doughnut ----
            trafficChart.sources = Window.chartsConfigs.createChart(sourceCtx, {
                type: 'pie',
                dataList: [{
                    label: '',
                    data: sourceValues
                }],
                label: sourceLabels,
                tooltipSuffix: '',
            })

            // ---- Landing Pages Bar Chart ----
            trafficChart.landingPages = Window.chartsConfigs.createChart(landingPageCtx, {
                type: 'verticalBar',
                dataList: [{
                    label: 'Sessions starting here',
                    data: landingPagesValues
                }],
                label: landingPagesLabels,
                tooltipSuffix: '',
            })

            // ---- session medium pie Chart ----
            trafficChart.mediums = Window.chartsConfigs.createChart(mediumsCtx, {
                type: 'doughnut',
                dataList: [{
                    label: '',
                    data: mediumValues
                }],
                label: mediumLabels,
                tooltipSuffix: '',
            })
        }

        // initial render
        updateTrafficCharts();

        // update charts with new data
        Livewire.on('update-traffic-charts', () => {
            // Delay to ensure DOM is fully updated
            setTimeout(() => {
                updateTrafficCharts();
            }, 100);
        });
    </script>
@endscript
