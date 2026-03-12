<div class="glass-card rounded-2xl p-6 shadow-sm space-y-4">
    {{-- Header: Status Selector --}}
    <div class="flex items-center justify-between gap-4">
        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Log Interaction</h3>
        <div class="min-w-[240px]">
            <x-dropdown :options="$leadStatuses" placeholder="Update Status (Optional)" model="newStatus" />
        </div>
    </div>

    {{-- Content Area --}}
    <textarea wire:model.live.debounce.500ms="activityDescription" placeholder="Describe what happened..." rows="8"
        class="w-full bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-primaryColor/50 focus:border-primaryColor text-gray-800 dark:text-white placeholder-gray-400 resize-none h-48 p-4 transition-all"></textarea>
    @error('activityDescription')
        <span class="text-red-500 text-xs">{{ $message }}</span>
    @enderror

    {{-- Footer: Activity Type & Action --}}
    <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
        {{-- Activity Types --}}
        <div
            class="flex items-center gap-2 p-1 bg-gray-100 dark:bg-white/5 rounded-xl border border-gray-200 dark:border-white/5">
            <button wire:click="$set('activityType', 'Phone Call')"
                class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase transition-all flex items-center gap-2 {{ $activityType === 'Phone Call' ? 'bg-white shadow text-primaryColor' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fa-solid fa-phone"></i> <span class="hidden sm:inline">Phone Call</span>
            </button>
            <button wire:click="$set('activityType', 'WhatsApp')"
                class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase transition-all flex items-center gap-2 {{ $activityType === 'WhatsApp' ? 'bg-white shadow text-green-600' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fa-brands fa-whatsapp"></i> <span class="hidden sm:inline">WhatsApp</span>
            </button>
            <button wire:click="$set('activityType', 'Email')"
                class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase transition-all flex items-center gap-2 {{ $activityType === 'Email' ? 'bg-white shadow text-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fa-solid fa-envelope"></i> <span class="hidden sm:inline">Email</span>
            </button>
            <button wire:click="$set('activityType', 'Note')"
                class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase transition-all flex items-center gap-2 {{ $activityType === 'Note' ? 'bg-white shadow text-orange-500' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fa-solid fa-note-sticky"></i> <span class="hidden sm:inline">Note</span>
            </button>
        </div>
        @error('activityType')
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror

        {{-- Submit --}}
        <x-primary-button loadingKey="saveForm" wire:click="submit">
          Post Activity
        </x-primary-button>
    </div>
</div>
