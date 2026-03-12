@props([
    'options' => [],
    'placeholder' => false,
    'model' => null,
    'associative' => false,
])

@php
    $normalizedOptions = [];

    foreach ($options as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $subValue => $subLabel) {
                $normalizedOptions[] = [
                    'value' => (string) $subLabel,
                    'label' => (string) $subLabel,
                ];
            }

            continue;
        }

        $normalizedOptions[] = [
            'value' => $associative ? (string) $key : (string) $value,
            'label' => (string) $value,
        ];
    }
@endphp

<div
    class="relative mt-2"
    x-data="{
        open: false,
        options: @js($normalizedOptions),
        value: @entangle($model).live,
        placeholder: @js($placeholder ?: 'Select an option'),
        selectedLabel() {
            const selected = this.options.find((option) => String(option.value) === String(this.value));
            return selected ? selected.label : this.placeholder;
        },
        choose(optionValue) {
            this.value = optionValue;
            this.open = false;
        }
    }"
    x-on:keydown.escape.window="open = false"
    x-on:click.outside="open = false"
>
    <button
        type="button"
        x-on:click="open = !open"
        :aria-expanded="open"
        aria-haspopup="listbox"
        {{ $attributes->merge([
            'class' => '
                w-full px-4 py-3 rounded-2xl font-body text-base
                transition-all duration-300 ease-out text-left
                text-gray-900 dark:text-gray-100
                bg-white/80 border border-gray-300/70
                shadow-sm hover:border-gray-400
                focus:outline-none focus:border-black focus:ring-4 focus:ring-black/10
                dark:bg-zinc-900/70 dark:border-gray-700/60
                dark:hover:border-gray-500 dark:focus:border-white
                dark:focus:ring-4 dark:focus:ring-white/10 dark:shadow-inner
                backdrop-blur-xl
                disabled:opacity-60 disabled:cursor-not-allowed
            ',
        ]) }}
    >
        <span class="truncate block" :class="value ? '' : 'text-gray-400 dark:text-gray-500'" x-text="selectedLabel()"></span>
        <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-500 dark:text-gray-400">
            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
        </span>
    </button>

    <div
        x-cloak
        x-show="open"
        x-transition.opacity.duration.100ms
        class="absolute z-50 mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-zinc-900 shadow-xl overflow-hidden"
    >
        <ul class="max-h-60 overflow-auto py-1" role="listbox">
            <template x-for="option in options" :key="option.value">
                <li
                    role="option"
                    :aria-selected="String(option.value) === String(value)"
                    x-on:click="choose(option.value)"
                    class="px-4 py-2.5 text-sm cursor-pointer transition-colors duration-150 text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-zinc-800"
                    :class="String(option.value) === String(value) ? 'bg-gray-100 dark:bg-zinc-800 font-semibold' : ''"
                    x-text="option.label"
                ></li>
            </template>
        </ul>
    </div>
</div>
