<div class="relative overflow-hidden glass-card rounded-3xl p-4 sm:p-8 shadow-premium transition-all duration-500 group">
    {{-- Decorative background elements --}}
    <div
        class="absolute -top-24 -right-24 w-64 h-64 bg-primaryColor/10 rounded-full blur-3xl pointer-events-none group-hover:bg-primaryColor/20 transition-all duration-700">
    </div>
    <div
        class="absolute -bottom-24 -left-24 w-64 h-64 bg-accentColor/10 rounded-full blur-3xl pointer-events-none group-hover:bg-accentColor/20 transition-all duration-700">
    </div>

    <div class="relative z-10">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-10">
            <div>
                <h1
                    class="text-2xl sm:text-3xl font-heading font-black text-gray-900 dark:text-light flex items-center mb-2">
                    <span class=" mr-3">
                        <i class="fa-solid fa-filter"></i>
                    </span>
                    Lead Funnel
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-body">Track your conversion journey from
                    prospecting to closure.</p>
            </div>
        </div>

        @php
            $pipelineStages = [
                [
                    'name' => 'New',
                    'icon' => 'fa-solid fa-leaf',
                    'color' => 'bg-slate-500',
                    'light' => 'bg-slate-50',
                    'text' => 'text-slate-600',
                ],
                [
                    'name' => 'Processing',
                    'icon' => 'fa-solid fa-gear',
                    'color' => 'bg-blue-500',
                    'light' => 'bg-blue-50',
                    'text' => 'text-blue-600',
                ],
                [
                    'name' => 'Call Back Requested',
                    'icon' => 'fa-solid fa-phone-arrow-down-left',
                    'color' => 'bg-yellow-500',
                    'light' => 'bg-yellow-50',
                    'text' => 'text-yellow-600',
                ],
                [
                    'name' => 'Proposition Sent',
                    'icon' => 'fa-solid fa-file-contract',
                    'color' => 'bg-cyan-500',
                    'light' => 'bg-cyan-50',
                    'text' => 'text-cyan-600',
                ],
            ];

            $outcomeStages = [
                [
                    'name' => 'Won',
                    'icon' => 'fa-solid fa-crown',
                    'color' => 'bg-primaryColor',
                    'light' => 'bg-primaryColor/10',
                    'text' => 'text-primaryColor',
                ],
                [
                    'name' => 'Not Interested',
                    'icon' => 'fa-solid fa-user-slash',
                    'color' => 'bg-red-500',
                    'light' => 'bg-red-50',
                    'text' => 'text-red-600',
                ],
            ];
        @endphp

        <!-- Pipeline Section -->
        <div class="mb-10">
            <h3
                class="text-sm font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-6 flex items-center">
                <span class="w-8 h-[1px] bg-gray-300 dark:bg-gray-700 mr-3"></span>
                Active Pipeline
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($pipelineStages as $stage)
                    @php $count = $leadsFunnel[$stage['name']] ?? 0; @endphp
                    <div
                        class="relative group/card bg-white/40 dark:bg-black/20 p-5 rounded-2xl border border-white/20 dark:border-white/5 hover:bg-white/60 dark:hover:bg-black/30 transition-all duration-300 hover-lift">
                        <div class="flex items-start justify-between">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-xl {{ $stage['color'] }} text-white shadow-lg shadow-{{ str_replace('bg-', '', $stage['color']) }}/30 transform group-hover/card:rotate-12 transition-transform">
                                <i class="{{ $stage['icon'] }} text-xl"></i>
                            </div>
                            <span
                                class="text-2xl font-black font-numbers text-gray-800 dark:text-white">{{ $count }}</span>
                        </div>
                        <div class="mt-4">
                            <div class="font-bold text-gray-900 dark:text-gray-100 font-heading">{{ $stage['name'] }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Status progression</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Outcome Section -->
        <div>
            <h3
                class="text-sm font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-6 flex items-center">
                <span class="w-8 h-[1px] bg-gray-300 dark:bg-gray-700 mr-3"></span>
                Quarterly Outcomes
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                @foreach ($outcomeStages as $stage)
                    @php $count = $leadsFunnel[$stage['name']] ?? 0; @endphp
                    <div
                        class="flex items-center p-4 rounded-2xl bg-white/20 dark:bg-black/10 border border-white/10 dark:border-white/5">
                        <div
                            class="mr-4 w-10 h-10 flex items-center justify-center rounded-full {{ $stage['light'] }} dark:bg-opacity-10 {{ $stage['text'] }}">
                            <i class="{{ $stage['icon'] }}"></i>
                        </div>
                        <div>
                            <div class="text-[10px] uppercase font-bold text-gray-400">{{ $stage['name'] }}</div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $count }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
