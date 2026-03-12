@props([
    'title' => 'Total Revenue', // Example title
    'icon' => 'fa-solid fa-chart-line', // Updated default icon
    'main_parameter' => '$12,450', // Formatted value
    'unit' => '',
    'change_per_month' => '12.5', // Positive change
    'changeUnit' => 'month',
    'cumulative' => false,
])


<div
    {{ $attributes->merge([
        'class' => "relative overflow-hidden rounded-2xl glass-card
                            text-darkColor dark:text-gray-100 shadow-premium p-4 sm:p-6
                            hover-lift transition-all duration-500",
    ]) }}>

    {{-- Background mesh effect --}}
    <div class="absolute inset-0 opacity-10 dark:opacity-20 pointer-events-none animate-mesh premium-gradient"></div>

    <div class="relative z-10">
        {{-- Title Row --}}
        <div class="flex items-center justify-between mb-4">
            <h3
                class="text-xs font-bold tracking-widest uppercase opacity-60 text-gray-700 dark:text-gray-300 font-heading">
                {{ $title }}
            </h3>
            <div
                class="flex items-center justify-center w-12 h-12 rounded-2xl
                       bg-light/50 dark:bg-dark/40 backdrop-blur-xl
                       shadow-sm border border-light/20 dark:border-light/5">
                <i class="{{ $icon }} "></i>
            </div>
        </div>

        {{-- Main Parameter --}}
        <div class="flex items-baseline space-x-1">
            <span class="text-3xl sm:text-4xl font-extrabold tracking-tight font-numbers">
                {{ $main_parameter }}
            </span>
            @if ($unit)
                <span class="text-sm font-medium opacity-60">{{ $unit }}</span>
            @endif
        </div>

        {{-- Change Indicator --}}
        @if ($changeUnit !== 'none')
            <div
                class="flex items-center mt-4 p-2 rounded-xl bg-light/30 dark:bg-dark/20 w-fit border border-light/20 dark:border-light/5">
                @php
                    $changePerMonth = (float) $change_per_month;
                    $isPositive = $changePerMonth > 0;
                    $isNegative = $changePerMonth < 0;
                @endphp

                <div class="flex items-center space-x-1">
                    @if ($isPositive)
                        <div class="flex items-center text-green-600 dark:text-green-400">
                            <i class="fa-solid fa-arrow-up text-[10px] mr-1"></i>
                            <span class="text-xs font-bold">{{ $changePerMonth }}{{ $unit }}</span>
                        </div>
                    @elseif ($isNegative)
                        <div class="flex items-center text-red-600 dark:text-red-400">
                            <i class="fa-solid fa-arrow-down text-[10px] mr-1"></i>
                            <span class="text-xs font-bold">{{ $changePerMonth }}{{ $unit }}</span>
                        </div>
                    @else
                        <div class="flex items-center text-blue-600 dark:text-blue-400">
                            <i class="fa-solid fa-minus text-[10px] mr-1"></i>
                            <span class="text-xs font-bold">0{{ $unit }}</span>
                        </div>
                    @endif
                    <span
                        class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400 font-medium ml-1">
                        vs last {{ $changeUnit }}
                    </span>
                </div>
            </div>
        @endif
    </div>
</div>
