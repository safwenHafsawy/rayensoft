<div class="mt-6 pt-4 w-full">

    <!-- Section Header -->
    <div class="w-full flex flex-col md:flex-row md:justify-between md:items-center py-4 px-6 gap-4">
        <!-- Title Section -->
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold font-heading text-gray-900 dark:text-gray-100">Key Events Insights</h2>
            <p class="text-sm font-body text-gray-500 dark:text-gray-400 mt-1">Overview of user activity over selected
                periods</p>
        </div>

        <!-- Selector -->
        <div class="relative w-full md:w-auto">
            <select id="eventsDataTimeFrame" wire:model.live="eventsDataTimeFrame"
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
                <option value="180daysAgo">Last 180 days</option>
                <option value="365daysAgo">Last 365 days</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-10">

        <!-- Funnel Card -->
        <div
            class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40
                    dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-gray-900/20
                    pointer-events-none rounded-3xl animate-pulse-slow">
            </div>

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Booking Funnel</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-body">Most interacted links</p>
                </div>
            </div>

            @php
                $max = max(array_column($funnelData, 'eventCount')) ?: 1;

                $colors = [
                    'Visited Booking Page' => 'from-[#7e1d46] to-[#da5e92]',
                    'Selected Date' => 'from-[#80558E] to-[#E1D4E6]',
                    'Selected Time' => 'from-[#f59e0b] to-[#fdf0da]',
                    'Attempted Booking' => 'from-blue-400 to-blue-300',
                    'Completed Booking' => 'from-emerald-400 to-emerald-300',
                ];
            @endphp

            <div class="space-y-5">
                @foreach ($funnelData as $step => $data)
                    @php $widthPercent = ($data['eventCount'] / $max) * 100; @endphp

                    <div class="flex flex-col gap-1">
                        <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ $step }}</span>
                            <span class="font-medium font-body text-gray-700 dark:text-gray-300">
                                {{ $data['eventCount'] }}
                                <span class="font-body text-sm">(Total Users: {{ $data['userCount'] }})</span>
                            </span>
                        </div>

                        <div class="relative h-3 w-full bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="absolute h-full bg-gradient-to-r {{ $colors[$step] }} rounded-full transition-all duration-700"
                                style="width: {{ $widthPercent }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        <!-- Link Click Events Card -->
        <div
            class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40
                    dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-gray-900/20
                    pointer-events-none rounded-3xl animate-pulse-slow">
            </div>

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-gray-100">Top Link Clicks</h2>
                    <p class="text-sm text-gray-500 mt-1 font-body">Most interacted links</p>
                </div>
            </div>


            @if (count($linkClicksData) > 0)
                <div class="overflow-hidden border border-gray-100 rounded-xl overflow-x-auto">
                    <table class="w-full text-left min-w-[300px]">

                        <thead>
                            <x-table.table-row :header="true">
                                <x-table.table-header>#</x-table.table-header>
                                <x-table.table-header>Link Text</x-table.table-header>
                                <x-table.table-header>Nb. Clicks</x-table.table-header>
                            </x-table.table-row>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @foreach ($linkClicksData as $linkText => $count)
                                <x-table.table-row>
                                    <x-table.table-data>{{ $loop->iteration }}</x-table.table-data>
                                    <x-table.table-data title="{{ $linkText }}">
                                        {{ $linkText }}
                                    </x-table.table-data>
                                    <x-table.table-data>
                                        {{ $count }}
                                    </x-table.table-data>
                                </x-table.table-row>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-gray-400 font-body italic">No link click data for the selected period.</p>
            @endif
        </div>

        <!-- Scroll Depth Card -->
        <div
            class="w-full relative bg-white/70 dark:bg-dark/50 backdrop-blur-xl rounded-3xl shadow-lg border border-white/20 dark:border-gray-700 p-8 overflow-hidden hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-200/40 via-white/20 to-indigo-100/40
                    dark:from-primaryColor-darker/20 dark:via-gray-800/20 dark:to-gray-900/20
                    pointer-events-none rounded-3xl animate-pulse-slow">
            </div>

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-lg font-bold font-heading text-dark dark:text-gray-100">Scroll Depth</h2>
                    <p class="text-sm text-gray-500 mt-1 font-body">User scroll behavior on pages</p>
                </div>
            </div>

            @if (count($scrollDepthData) > 0)
                @php
                    $maxScroll = max($scrollDepthData) ?: 1;
                @endphp
                <div class="space-y-5">
                    @foreach ($scrollDepthData as $threshold => $count)
                        @php $widthPercent = ($count / $maxScroll) * 100; @endphp
                        <div class="flex flex-col gap-1">
                            <div class="flex justify-between text-xs text-dark dark:text-light/60">
                                <span>{{ $threshold }}%</span>
                                <span class="font-medium text-dark dark:text-light">{{ $count }}</span>
                            </div>
                            <div class="relative h-3 w-full bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="absolute h-full bg-gradient-to-r from-blue-400 to-blue-300 rounded-full transition-all duration-700"
                                    style="width: {{ $widthPercent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 font-body italic">No scroll depth data for the selected period.</p>
            @endif
        </div>
    </div>
</div>
