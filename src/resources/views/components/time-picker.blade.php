@props([
    'model',
    'id' => null,
    'placeholder' => 'Select time',
    'disabled' => false,
    'step' => 30,
])

<div
    {{ $attributes->merge(['class' => 'relative mt-2']) }}
    x-data="{
        open: false,
        value: @entangle($model).live,
        step: Number(@js($step)),
        times: [],
        init() {
            this.buildTimes();
        },
        buildTimes() {
            const slot = Number.isFinite(this.step) && this.step > 0 ? this.step : 30;
            this.times = [];

            for (let hour = 0; hour < 24; hour++) {
                for (let minute = 0; minute < 60; minute += slot) {
                    this.times.push(`${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`);
                }
            }
        },
        choose(timeValue) {
            this.value = timeValue;
            this.open = false;
        },
        display() {
            if (!this.value || !/^\\d{2}:\\d{2}$/.test(this.value)) return @js($placeholder);
            const [hourRaw, minuteRaw] = this.value.split(':').map(Number);
            const period = hourRaw >= 12 ? 'PM' : 'AM';
            const hour12 = hourRaw % 12 === 0 ? 12 : hourRaw % 12;
            return `${hour12}:${String(minuteRaw).padStart(2, '0')} ${period}`;
        },
    }"
    x-on:click.outside="open = false"
    x-on:keydown.escape.window="open = false"
>
    <button
        type="button"
        @if($id) id="{{ $id }}" @endif
        class="
            w-full px-5 py-3.5 font-body text-sm rounded-xl text-left
            transition-all duration-300 ease-out
            bg-white/70 text-gray-900 border border-gray-200/60
            shadow-sm hover:border-gray-300 hover:bg-white
            focus:outline-none focus:border-primaryColor/50 focus:ring-4 focus:ring-primaryColor/10
            dark:bg-white/5 dark:text-gray-100 dark:border-white/10
            dark:hover:border-white/20 dark:hover:bg-white/8
            dark:focus:border-primaryColor/50 dark:focus:ring-4 dark:focus:ring-primaryColor/15
            backdrop-blur-xl disabled:opacity-40 disabled:cursor-not-allowed
        "
        x-on:click="open = !open"
        :disabled="@js($disabled)"
        :aria-expanded="open"
        aria-haspopup="listbox"
    >
        <span :class="value ? '' : 'text-gray-400 dark:text-gray-500'" x-text="display()"></span>
        <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-500 dark:text-gray-400">
            <i class="fa-solid fa-clock"></i>
        </span>
    </button>

    <div
        x-cloak
        x-show="open"
        x-transition.opacity.duration.120ms
        class="absolute z-50 mt-2 w-full rounded-xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-xl overflow-hidden"
    >
        <ul class="max-h-64 overflow-auto py-1" role="listbox">
            <template x-for="time in times" :key="time">
                <li
                    role="option"
                    :aria-selected="time === value"
                    x-on:click="choose(time)"
                    class="px-4 py-2.5 text-sm cursor-pointer transition-colors duration-150 text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-zinc-800"
                    :class="time === value ? 'bg-gray-100 dark:bg-zinc-800 font-semibold' : ''"
                    x-text="time"
                ></li>
            </template>
        </ul>
    </div>
</div>
