<form class="w-full py-10 px-4 lg:px-6 md:px-8 bg-lightColor/5" wire:submit.prevent="save">
    <div class="max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Full Name -->
            <div>
                <x-site.input-label for="fullName" value="Full Name" />
                <x-site.text-input type="text" wire:model.defer="fullName" id="fullName" required />
                <x-site.input-error :messages="$errors->get('fullName')" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <x-site.input-label for="email" value="Email" />
                <x-site.text-input type="email" wire:model.defer="email" id="email" required />
                <x-site.input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Subject (span full width on small) -->
            <div class="sm:col-span-2">
                <x-site.input-label for="subject" value="Subject" />
                <x-site.text-input type="text" wire:model.defer="subject" id="subject" required />
                <x-site.input-error :messages="$errors->get('subject')" class="mt-2" />
            </div>

            <input type="text" name="service" wire:model="service" class="sr-only" tabindex="-1" aria-hidden="true"
                autocomplete="new-service" />

            <!-- Message (full width) -->
            <div class="sm:col-span-2">
                <x-site.input-label for="message" value="Message" />
                <textarea wire:model.defer="message" id="message" rows="6"
                    class="mt-2 w-full rounded-xl border border-darkColor/15 focus:border-primaryColor focus:ring-0 {$textSize} py-3 px-4 placeholder-gray-400 shadow-sm transition resize-none"
                    required></textarea>
                <x-site.input-error :messages="$errors->get('message')" class="mt-2" />
            </div>

            <!-- Submit (center on small, left on larger) -->
            <div class="sm:col-span-2 flex justify-center sm:justify-start">
                <button type="submit" wire:loading.attr="disabled" wire:target="save"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                    class="relative w-full sm:w-auto flex items-center justify-center min-w-[10rem] px-6 py-3 rounded-2xl font-semibold text-sm uppercase tracking-wide text-white bg-primaryColor shadow-lg hover:shadow-2xl transition-all duration-200 ease-out overflow-hidden
                 before:absolute before:inset-0 before:bg-accentColor before:opacity-0 before:scale-95 hover:before:opacity-15 before:transition-all before:duration-400">
                    <!-- spinner -->
                    <svg wire:loading wire:target="save" class="w-5 h-5 animate-spin mr-2 text-white"
                        viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 01-8 8z">
                        </path>
                    </svg>

                    <span wire:loading.remove wire:target="save">Send Message</span>
                    <span wire:loading wire:target="save">Sending...</span>
                </button>
            </div>
        </div>
    </div>
</form>
