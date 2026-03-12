@props([
    'model',
    'id' => null,
    'placeholder' => 'Select date',
    'disabled' => false,
])

<div
    {{ $attributes->merge(['class' => 'relative mt-2']) }}
    x-data="{
        open: false,
        value: @entangle($model).live,
        monthDate: null,
        init() {
            this.monthDate = this.parseIso(this.value) ?? this.startOfMonth(new Date());
        },
        parseIso(isoValue) {
            if (!isoValue || !/^\\d{4}-\\d{2}-\\d{2}$/.test(isoValue)) return null;
            const [year, month, day] = isoValue.split('-').map(Number);
            const parsed = new Date(year, month - 1, day);
            return Number.isNaN(parsed.getTime()) ? null : parsed;
        },
        startOfMonth(date) {
            return new Date(date.getFullYear(), date.getMonth(), 1);
        },
        monthLabel() {
            return this.monthDate.toLocaleDateString(undefined, { month: 'long', year: 'numeric' });
        },
        calendarDays() {
            const year = this.monthDate.getFullYear();
            const month = this.monthDate.getMonth();
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const items = [];

            for (let i = 0; i < firstDay; i++) items.push(null);
            for (let day = 1; day <= daysInMonth; day++) items.push(day);

            return items;
        },
        isSelected(day) {
            if (!day || !this.value) return false;
            const candidate = this.toIso(this.monthDate.getFullYear(), this.monthDate.getMonth() + 1, day);
            return candidate === this.value;
        },
        prevMonth() {
            this.monthDate = new Date(this.monthDate.getFullYear(), this.monthDate.getMonth() - 1, 1);
        },
        nextMonth() {
            this.monthDate = new Date(this.monthDate.getFullYear(), this.monthDate.getMonth() + 1, 1);
        },
        toIso(year, month, day) {
            return `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        },
        pick(day) {
            this.value = this.toIso(this.monthDate.getFullYear(), this.monthDate.getMonth() + 1, day);
            this.open = false;
        },
        setToday() {
            const today = new Date();
            this.monthDate = this.startOfMonth(today);
            this.value = this.toIso(today.getFullYear(), today.getMonth() + 1, today.getDate());
            this.open = false;
        },
        clear() {
            this.value = '';
            this.open = false;
        },
        display() {
            const parsed = this.parseIso(this.value);
            if (!parsed) return @js($placeholder);
            return parsed.toLocaleDateString(undefined, {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
            });
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
        aria-haspopup="dialog"
    >
        <span :class="value ? '' : 'text-gray-400 dark:text-gray-500'" x-text="display()"></span>
        <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-500 dark:text-gray-400">
            <i class="fa-solid fa-calendar-days"></i>
        </span>
    </button>

    <div
        x-cloak
        x-show="open"
        x-transition.opacity.duration.120ms
        class="absolute z-50 mt-2 w-full rounded-xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-xl p-3"
    >
        <div class="flex items-center justify-between mb-3">
            <button type="button" class="px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-zinc-800" x-on:click="prevMonth()">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </button>
            <span class="text-sm font-semibold text-gray-800 dark:text-gray-100" x-text="monthLabel()"></span>
            <button type="button" class="px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-zinc-800" x-on:click="nextMonth()">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </button>
        </div>

        <div class="grid grid-cols-7 gap-1 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">
            <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
        </div>

        <div class="grid grid-cols-7 gap-1">
            <template x-for="(day, idx) in calendarDays()" :key="idx">
                <button
                    type="button"
                    x-bind:disabled="day === null"
                    x-on:click="day && pick(day)"
                    class="h-9 rounded-md text-sm transition-colors duration-150 disabled:cursor-default"
                    :class="day === null
                        ? 'opacity-0'
                        : (isSelected(day)
                            ? 'bg-primaryColor text-white font-semibold'
                            : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-zinc-800')"
                    x-text="day"
                ></button>
            </template>
        </div>

        <div class="flex items-center justify-between mt-3 pt-2 border-t border-gray-100 dark:border-white/10">
            <button type="button" class="text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300" x-on:click="clear()">Clear</button>
            <button type="button" class="text-xs font-semibold text-primaryColor hover:opacity-80" x-on:click="setToday()">Today</button>
        </div>
    </div>
</div>
