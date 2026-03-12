<div
    class="flex-1 bg-gradient-to-br from-white/90 to-white dark:from-dark dark:to-dark/95 rounded-[1.2rem] p-6 sm:p-8 lg:p-10 shadow-2xl shadow-primaryColor/10 dark:shadow-dark border border-gray-100 dark:border-primaryColor-darker/30 transition-all duration-500 transform hover:shadow-primaryColor/20">
    <div class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40 dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-drak pointer-events-none rounded-3xl animate-pulse-slow"></div>

    <div
        class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 pb-4 border-b border-gray-200 dark:border-dark-600">
        <h1 class="text-xl font-heading font-extrabold text-gray-900 dark:text-light flex items-center mb-4 sm:mb-0 transition-colors duration-300">
            Team Workload Distribution
        </h1>
    </div>
    <div class="flex justify-center h-48">
        <canvas id="monthlyWorkedTimeChart"></canvas>
    </div>

    <script>
        let workHourCharts = null;
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('monthlyWorkedTimeChart').getContext('2d');

            const data = @json($chartData);

            const labels = data.map(user => user.user);
            const hours = data.map(user => user.hours);

            workHourCharts = Window.chartsConfigs.createChart(ctx, {
                type: 'verticalBar',
                dataList: [{ label: 'Total Worked (Minutes)', data: hours }],
                label: labels,
                tooltipSuffix: ''
            });

        });

    </script>
</div>
