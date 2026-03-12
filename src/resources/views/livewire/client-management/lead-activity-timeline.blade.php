<div class="glass-card rounded-3xl p-8 shadow-premium min-h-[500px]">
    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
        <i class="fa-solid fa-clock-rotate-left text-gray-400"></i> Activity History
    </h3>

    <div
        class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-200 dark:before:via-white/10 before:to-transparent">

        @foreach ($activities as $activity)
            @php
                $type = $activity['type'];

                // Determine shared color key for uniformity
                $colorKey = match ($type) {
                    'Phone Call', 'phone', 'WhatsApp', 'whatsapp' => 'emerald',
                    'Email', 'email' => 'indigo',
                    'Note', 'note', 'Lead Created' => 'amber',
                    default => 'slate',
                };

                // Background classes for the icon bubble
                $colorClass = match ($colorKey) {
                    'emerald' => 'bg-emerald-500',
                    'indigo' => 'bg-blue-500',
                    'amber' => 'bg-gray-500',
                    default => 'bg-gray-500',
                };

                // Text classes for the timestamp
                $timeColorClass = match ($colorKey) {
                    'emerald' => 'text-emerald-500',
                    'indigo' => 'text-indigo-500',
                    'amber' => 'text-amber-500',
                    default => 'text-slate-500',
                };

                $iconClass = match ($type) {
                    'Phone Call', 'phone' => 'fa-solid fa-phone',
                    'WhatsApp', 'whatsapp' => 'fa-brands fa-whatsapp',
                    'Email', 'email' => 'fa-solid fa-envelope',
                    'Note', 'note' => 'fa-solid fa-note-sticky',
                    'Lead Created' => 'fa-solid fa-plus',
                    default => 'fa-solid fa-info',
                };
            @endphp

            <div
                class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                <div
                    class="flex items-center justify-center w-10 h-10 rounded-full border border-white {{ $colorClass }} text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                    <i class="{{ $iconClass }}"></i>
                </div>
                <div
                    class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white dark:bg-white/5 p-4 rounded-xl border border-slate-200 dark:border-white/10 shadow hover:shadow-md transition-all">
                    <div class="flex items-center justify-between space-x-2 mb-1">
                        <div class="font-bold text-slate-900 dark:text-white">{{ $type }}</div>
                        <time
                            class="font-caveat font-medium {{ $timeColorClass }}">{{ \Carbon\Carbon::parse($activity['created_at'])->format('M d, Y') }}</time>
                    </div>
                    <div class="text-slate-500 dark:text-slate-400">{{ $activity['description'] }}</div>
                </div>
            </div>
        @endforeach

        {{-- Lead Created Event --}}

        <div
            class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
            <div
                class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-gray-400 text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                <i class="fa-solid fa-star"></i>
            </div>
            <div
                class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white dark:bg-white/5 p-4 rounded-xl border border-slate-200 dark:border-white/10 shadow hover:shadow-md transition-all">
                <div class="flex items-center justify-between space-x-2 mb-1">
                    <div class="font-bold text-slate-900 dark:text-white">Lead Created</div>
                    <time
                        class="font-caveat font-medium text-amber-500">{{ \Carbon\Carbon::parse($lead->created_at)->format('M d, Y - H:i A') }}</time>
                </div>
                <div class="text-slate-500 dark:text-slate-400">
                    Lead added via <span class="font-bold">{{ $lead->lead_source ?? 'Unknown Source' }}</span>.
                </div>
            </div>
        </div>
    </div>
</div>
