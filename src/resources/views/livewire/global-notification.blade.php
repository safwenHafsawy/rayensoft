<div
    id="globalNotification"
    x-cloak
    x-data="{
        isDisplayed: @entangle('isDisplayed'),
        displayLoading: @entangle('displayLoading'),
        displaySuccessMessage: @entangle('displaySuccessMessage'),
        displayErrorMessage: @entangle('displayErrorMessage'),
        title: @entangle('title'),
        message: @entangle('message'),
        close() {
            this.isDisplayed = false;
            Livewire.dispatch('closeNotification');
        }
    }"
    x-show="isDisplayed"
    x-trap="isDisplayed"
    @keydown.escape.window="close()"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="fixed inset-0 z-[9999] flex items-center justify-center p-4 backdrop-blur-sm bg-black/40"
    role="dialog"
    aria-modal="true"
>
    <div
        class="relative bg-white rounded-3xl w-full max-w-md mx-auto shadow-[0_10px_60px_-15px_rgba(0,0,0,0.2)] border border-gray-100 overflow-hidden transition-all duration-300"
    >
        <!-- Close -->
        <button
            @click="close()"
            type="button"
            class="absolute top-4 right-4 p-2 rounded-full hover:bg-gray-100 focus:outline-none transition"
            aria-label="Close"
        >
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Loading State -->
        <div
            x-show="displayLoading"
            x-transition
            class="flex flex-col items-center justify-center py-16 px-10 space-y-5"
        >
            <div class="relative w-16 h-16">
                <div class="absolute inset-0 rounded-full border-[3px] border-darkColor/20"></div>
                <div class="absolute inset-0 rounded-full border-[3px] border-darkColor border-t-transparent animate-spin"></div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 tracking-tight" x-text="title"></h3>
            <p class="text-sm text-darkColor/40 text-center leading-relaxed" x-text="message"></p>
        </div>

        <!-- Success State -->
        <div
            x-show="!displayLoading && displaySuccessMessage"
            x-transition
            class="flex flex-col items-center text-center py-14 px-10 space-y-6"
        >
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-green-600 text-lightColor shadow-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h4 class="text-2xl font-semibold text-primaryColor tracking-tight" x-text="title"></h4>
            <p class="text-darkColor/50 text-sm leading-relaxed max-w-sm" x-text="message"></p>
        </div>

        <!-- Error State -->
        <div
            x-show="!displayLoading && displayErrorMessage"
            x-transition
            class="flex flex-col items-center text-center py-14 px-10 space-y-6"
        >
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-red-50 text-red-600 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h4 class="text-2xl font-semibold text-gray-900 tracking-tight" x-text="title"></h4>
            <p class="text-gray-500 text-sm leading-relaxed max-w-sm" x-text="message"></p>
            <p class="text-xs text-gray-400">If it persists, <a href="/contact" class="underline hover:text-gray-600">contact us</a>.</p>
            <button
                @click="close()"
                class="mt-4 px-6 py-2.5 bg-white border border-gray-200 text-sm font-medium rounded-full hover:bg-gray-50 transition-colors"
            >
                Okay
            </button>
        </div>
    </div>
</div>
