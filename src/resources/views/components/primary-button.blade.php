@props(['loadingKey' => ''])

<button x-data="{
    loading: false,
    key: @js($loadingKey),

    matches(detail) {
        if (this.key) return detail?.key === this.key;
    }
}" @click="loading = true" :disabled="loading"
    @lb-stop.window="if (matches($event.detail)) loading=false"
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
                    relative inline-flex items-center justify-center px-7 py-3 overflow-hidden
                    premium-gradient text-white font-bold text-sm font-heading uppercase tracking-wider
                    rounded-xl shadow-premium
                    hover:shadow-premium-glow hover:scale-[1.03]
                    active:scale-[0.97] active:shadow-sm
                    transition-all duration-300 ease-out
                    focus:outline-none focus:ring-4 focus:ring-primaryColor/25
                    disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100
                    group/btn
                ',
    ]) }}>
    {{-- Shimmer effect on hover --}}
    <span
        class="absolute inset-0 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-500 animate-shimmer pointer-events-none"></span>

    <span class="relative z-10 flex items-center">
        @if (isset($icon))
            <i class="{{ $icon }} mr-2 text-sm"></i>
        @endif
        <span x-show="!loading">{{ $slot }}</span>
        <span x-show="loading" class="flex items-center">
            <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            {{ $loadingText ?? 'Processing…' }}
        </span>
    </span>
</button>
