<div class="mt-6 pt-4 w-full">

    <!-- Section Header -->
    <div class="w-full flex flex-col md:flex-row md:justify-between md:items-center py-4 px-6 gap-4">
        <!-- Title Section -->
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold font-heading text-gray-900 dark:text-gray-100">Audience Breakdown
                Insights</h2>
            <p class="text-sm font-body text-gray-500 dark:text-gray-400 mt-1">Overview of user profile, quality of
                visits over selected period</p>
        </div>
        <div class="relative w-full md:w-auto">
            <select id="userDataTimeframe" wire:model.live="userDataTimeframe"
                class="w-full md:w-auto px-8 py-2 border rounded-xl font-medium font-body shadow-sm
               text-gray-700 dark:text-gray-200
               bg-white dark:bg-dark/50
               border-gray-300 dark:border-gray-600
               focus:ring-2 focus:ring-primaryColor focus:outline-none
               transition-all duration-300 hover:scale-105">
                <option value="yesterday">One Day Ago</option>
                <option value="7daysAgo">Last 7 days</option>
                <option value="30daysAgo">Last 30 days</option>
                <option value="90daysAgo">Last 90 days</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
        {{--        country chart --}}
        <div
            class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
            </div>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Top Countries</h2>
                    <p class="text-sm text-gray-500 mt-1 font-body">User Distribution by Country</p>
                </div>
                <button wire:click="openDetailedAnalyticsModal('country')"
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
                <canvas id="country-chart"></canvas>
            </div>
        </div>

        {{--        regions chart --}}
        <div
            class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
            </div>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Top Regions</h2>
                    <p class="text-sm text-gray-500 mt-1 font-body">User Distribution by Region</p>
                </div>
                <button wire:click="openDetailedAnalyticsModal('region')"
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
                <canvas id="region-chart"></canvas>
            </div>
        </div>

        {{--        cities chart --}}
        <div
            class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
            </div>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Top Cities</h2>
                    <p class="text-sm text-gray-500 mt-1 font-body">User Distribution by City</p>
                </div>
                <button wire:click="openDetailedAnalyticsModal('city')"
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
                <canvas id="city-chart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[60%_1fr] gap-4 mt-8">
        <div
            class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
            </div>


            <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100 mb-4">Returning Vs New
                Visitors Daily </h2>

            <div wire:ignore class="relative h-72">
                <canvas id="new-vs-returning-daily-chart"></canvas>
            </div>
        </div>

        <div
            class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
            </div>

            <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100 mb-4">Returning Vs New Visitors
                Total</h2>
            <div wire:ignore class="relative h-72">
                <canvas id="new-vs-returning-total-chart"></canvas>
            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-rows-2 gap-4 mt-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div
                class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
                </div>
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Devices </h2>
                        <p class="text-sm text-gray-500 mt-1 font-body">User Distribution by Device</p>
                    </div>
                    <button wire:click="openDetailedAnalyticsModal('deviceCategory')"
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
                    <canvas id="device-distribution-chart"></canvas>
                </div>
            </div>
            <div
                class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
                </div>
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Top OS</h2>
                        <p class="text-sm text-gray-500 mt-1 font-body">User Distribution by Operating Systems</p>
                    </div>
                    <button wire:click="openDetailedAnalyticsModal('operatingSystem')"
                        class="text-sm font-medium text-gray-600 dark:text-gray-400
                               hover:text-primaryColor dark:hover:text-primaryColor
                               transition-all duration-300 ease-out flex items-center gap-1.5 group">
                        View All
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                <div wire:ignore class="relative h-64">
                    <canvas id="os-distribution-chart"></canvas>
                </div>
            </div>
            <div
                class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
                </div>
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Top
                            Languages</h2>
                        <p class="text-sm text-gray-500 mt-1 font-body">User Distribution by Browser Language</p>
                    </div>
                    <button wire:click="openDetailedAnalyticsModal('language')"
                        class="text-sm font-medium text-gray-600 dark:text-gray-400
                               hover:text-primaryColor dark:hover:text-primaryColor
                               transition-all duration-300 ease-out flex items-center gap-1.5 group">
                        View All
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                <div wire:ignore class="relative h-64">
                    <canvas id="language-distribution-chart"></canvas>
                </div>
            </div>
        </div>
        <div
            class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow">
            </div>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Top Screen
                        Resolutions</h2>
                    <p class="text-sm text-gray-500 mt-1 font-body">User Distribution by Screen Resolution</p>
                </div>
                <button wire:click="openDetailedAnalyticsModal('screenResolution')"
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
                <canvas id="screen-res-chart"></canvas>
            </div>
        </div>
    </div>

    <div id="geo-data-div" hidden wire:key="audience-charts-data-{{ $userDataTimeframe }}"
        data-visit-by-county-data='@json(array_values($visitByCountries))'
        data-visit-by-country-labels='@json(array_keys($visitByCountries))'
        data-visit-by-region-data='@json(array_values($visitByRegions))'
        data-visit-by-region-labels='@json(array_keys($visitByRegions))'
        data-visit-by-city-data='@json(array_values($visitByCities))'
        data-visit-by-city-labels='@json(array_keys($visitByCities))' data-timeframe='{{ $userDataTimeframe }}'></div>

    <div id="behavior-data-div" hidden wire:key="behavior-data-div-${{ $userDataTimeframe }}"
        data-returning-daily-labels='@json(array_values($returningVsNewByDatesLabels))'
        data-returning-daily-data='@json(array_values($returningVisitorsByDates))' data-new-daily-data='@json(array_values($newVisitorsByDates))'
        data-total-rVn-data='@json(array_values($totalVisitorsComp))' data-total-rVn-labels='@json(array_keys($totalVisitorsComp))'>
    </div>

    <div id="user-agent-data" hidden wire:key="user-agent-div-${{ $userDataTimeframe }}"
        data-device-destribution-labels='@json(array_keys($userByDevice))'
        data-device-destribution-data='@json(array_values($userByDevice))'
        data-os-destribution-labels='@json(array_keys($userByOS))'
        data-os-destribution-data='@json(array_values($userByOS))'
        data-language-distribution-labels='@json(array_keys($userByBrowserLanguage))'
        data-language-distribution-data='@json(array_values($userByBrowserLanguage))'
        data-screen-res-distribution-labels='@json(array_keys($userByScreenResolution))'
        data-screen-res-distribution-data='@json(array_values($userByScreenResolution))'>

    </div>
</div>

@script
    <script>
        let countryChart, regionChart, cityChart;
        let returningVsNewDailyChart, returningVsNewTotalChart;
        let devicesChart, OSChart, screeResolutionChart, languagesChart;


        function updateAudienceGoeLocCharts() {
            let countryCtx = document.getElementById('country-chart').getContext('2d');
            let regionCtx = document.getElementById('region-chart').getContext('2d');
            let cityCtx = document.getElementById('city-chart').getContext('2d');

            // destroy charts if they already exists
            if (countryChart) countryChart.destroy();
            if (regionChart) regionChart.destroy();
            if (cityChart) cityChart.destroy();
            countryChart = null;
            regionChart = null;
            cityChart = null;

            const geoDataEl = document.getElementById('geo-data-div');

            let visitByCountriesLabels, visitByCountriesValues, visitByRegionLabels, visitByRegionValues,
                visitByCityLabels,
                visitByCityData;

            try {
                visitByCountriesLabels = JSON.parse(geoDataEl.dataset.visitByCountryLabels);
                visitByCountriesValues = JSON.parse(geoDataEl.dataset.visitByCountyData);
                visitByRegionLabels = JSON.parse(geoDataEl.dataset.visitByRegionLabels);
                visitByRegionValues = JSON.parse(geoDataEl.dataset.visitByRegionData);
                visitByCityData = JSON.parse(geoDataEl.dataset.visitByCityData);
                visitByCityLabels = JSON.parse(geoDataEl.dataset.visitByCityLabels);

                countryChart = Window.chartsConfigs.createChart(countryCtx, {
                    type: 'polarArea',
                    dataList: [{
                        label: 'Number Of Visitors From',
                        data: visitByCountriesValues
                    }],
                    label: visitByCountriesLabels,
                    tooltipSuffix: 'Countries'
                });
                //
                regionChart = Window.chartsConfigs.createChart(regionCtx, {
                    type: 'pie',
                    dataList: [{
                        label: 'Number Of Visitors From',
                        data: visitByRegionValues
                    }],
                    label: visitByRegionLabels,
                    tooltipSuffix: 'Regions'
                })
                //
                cityChart = Window.chartsConfigs.createChart(cityCtx, {
                    type: 'doughnut',
                    dataList: [{
                        label: 'Number Of Visitors From',
                        data: visitByCityData
                    }],
                    label: visitByCityLabels,
                    tooltipSuffix: 'Cities'
                })

            } catch (e) {
                console.error('Failed to parse chart data:', e);
            }
        }

        function updateAudienceBehaviorCharts() {
            let dailyNewVsReturningCtx = document.getElementById('new-vs-returning-daily-chart').getContext('2d');
            let totalNewVsReturningCtx = document.getElementById('new-vs-returning-total-chart').getContext('2d');

            if (returningVsNewDailyChart) returningVsNewDailyChart.destroy();
            if (returningVsNewTotalChart) returningVsNewTotalChart.destroy();
            returningVsNewDailyChart = null;
            returningVsNewTotalChart = null;

            const behaviorDataEl = document.getElementById('behavior-data-div');

            try {

                let returningVsNewLabels = JSON.parse(behaviorDataEl.dataset.returningDailyLabels);
                let retuningVisitsDailyData = JSON.parse(behaviorDataEl.dataset.returningDailyData);
                let newVisitsDailyData = JSON.parse(behaviorDataEl.dataset.newDailyData);

                let totalReturningVsNewData = JSON.parse(behaviorDataEl.dataset.totalRvnData);
                let totalReturningVsNewLabels = JSON.parse(behaviorDataEl.dataset.totalRvnLabels);

                // ----Daily Returning Vs New Visits Chart ----

                returningVsNewDailyChart = Window.chartsConfigs.createChart(dailyNewVsReturningCtx, {
                    type: 'line',
                    dataList: [{
                        label: 'New Visitor(s)',
                        data: newVisitsDailyData
                    }, {
                        label: 'Returning Visitor(s)',
                        data: retuningVisitsDailyData
                    }],
                    label: returningVsNewLabels,
                    tooltipSuffix: 'Visits'
                })

                // ---- Total Returning Vs New Visits Chart ----
                returningVsNewTotalChart = Window.chartsConfigs.createChart(totalNewVsReturningCtx, {
                    type: 'horizontalBar',
                    dataList: [{
                        label: 'Audience Type:',
                        data: totalReturningVsNewData
                    }],
                    label: totalReturningVsNewLabels,
                    tooltipSuffix: ''
                });

            } catch (e) {
                console.error(e);
            }
        }

        function updateUserAgentCharts() {
            let devicesCtx = document.getElementById('device-distribution-chart').getContext('2d');
            let osCtx = document.getElementById('os-distribution-chart').getContext('2d');
            let langCtx = document.getElementById('language-distribution-chart').getContext('2d');
            let screenResCtx = document.getElementById('screen-res-chart').getContext('2d');

            if (devicesChart) devicesChart.destroy();
            if (OSChart) OSChart.destroy();
            if (languagesChart) languagesChart.destroy();
            if (screeResolutionChart) screeResolutionChart.destroy();
            devicesChart = null;
            OSChart = null;
            languagesChart = null;
            screeResolutionChart = null;

            const userAgentDataset = document.getElementById('user-agent-data').dataset;

            try {
                const devicesDistributionData = JSON.parse(userAgentDataset.deviceDestributionData);
                const deviceDistributionLabels = JSON.parse(userAgentDataset.deviceDestributionLabels);
                const OSDistributionLabels = JSON.parse(userAgentDataset.osDestributionLabels);
                const OSDistributionData = JSON.parse(userAgentDataset.osDestributionData);
                const languageDistributionLabels = JSON.parse(userAgentDataset.languageDistributionLabels);
                const languageDistributionData = JSON.parse(userAgentDataset.languageDistributionData);
                const screenResDistributionLabels = JSON.parse(userAgentDataset.screenResDistributionLabels);
                const screenResDistributionData = JSON.parse(userAgentDataset.screenResDistributionData);

                devicesChart = Window.chartsConfigs.createChart(devicesCtx, {
                    type: 'polarArea',
                    dataList: [{
                        label: 'Number of Visitors using',
                        data: devicesDistributionData
                    }],
                    label: deviceDistributionLabels,
                    tooltipSuffix: 'devices'
                });
                //
                OSChart = Window.chartsConfigs.createChart(osCtx, {
                    type: 'pie',
                    dataList: [{
                        label: 'Number of Visitors using',
                        data: OSDistributionData
                    }],
                    label: OSDistributionLabels,
                    tooltipSuffix: 'OS'
                });
                //
                languagesChart = Window.chartsConfigs.createChart(langCtx, {
                    type: 'doughnut',
                    dataList: [{
                        label: 'Number of Visitors using',
                        data: languageDistributionData
                    }],
                    label: languageDistributionLabels,
                    tooltipSuffix: 'Language'
                });
                //
                screeResolutionChart = new Window.chartsConfigs.createChart(screenResCtx, {
                    type: 'verticalBar',
                    dataList: [{
                        label: 'Number of Visitors',
                        data: screenResDistributionData
                    }],
                    label: screenResDistributionLabels,
                    tooltipSuffix: ''
                })

            } catch (e) {
                console.error(e);
            }
        }

        // Initial Render
        updateAudienceGoeLocCharts();
        updateAudienceBehaviorCharts();
        updateUserAgentCharts();

        // update charts with new data
        Livewire.on('update-audience-charts', () => {
            // Delay to ensure DOM is fully updated
            setTimeout(() => {
                updateAudienceGoeLocCharts();
                updateAudienceBehaviorCharts();
                updateUserAgentCharts();
            }, 100);
        });
    </script>
@endscript
