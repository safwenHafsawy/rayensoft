<x-modal x-cloak title="{{ $isEditing ? 'Update Lead' : 'Add New Lead' }}" for="lead" record_id="{{ $lead_id }}"
    isEditing="{{ $isEditing }}">
    <form class="px-6 py-5 space-y-6" wire:submit.prevent="submit">

        <!-- Basic Information -->
        <div>
            <h4 class="text-xs uppercase tracking-widest font-semibold text-gray-400 dark:text-gray-500 mb-4">
                Contact
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <x-input-label for="leadname" value="Name" />
                    <x-text-input type="text" wire:model.live.debounce.350ms="leadData.name" id="leadname"
                        placeholder="Full name" />
                    <x-input-error :messages="$errors->get('leadData.name')" />
                </div>
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input type="email" wire:model.live.debounce.350ms="leadData.email" id="email"
                        placeholder="email@example.com" />
                    <x-input-error :messages="$errors->get('leadData.email')" />
                </div>
                <div>
                    <x-input-label for="phone" value="Phone" />
                    <x-text-input type="text" wire:model.live.debounce.350ms="leadData.phone" id="phone"
                        placeholder="+1 555 000 0000" />
                    <x-input-error :messages="$errors->get('leadData.phone')" />
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100 dark:border-white/5"></div>

        <!-- Details -->
        <div>
            <h4 class="text-xs uppercase tracking-widest font-semibold text-gray-400 dark:text-gray-500 mb-4">
                Details
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-{{ $isEditing ? '3' : '2' }} gap-4">
                @if ($isEditing)
                    <div>
                        <x-input-label for="status" value="Status" />
                        <x-dropdown :options="$lead_statues" placeholder="Select Status" model="leadData.status" />
                        <x-input-error :messages="$errors->get('leadData.status')" />
                    </div>
                @endif
                <div>
                    <x-input-label for="industry" value="Industry" />
                    <x-dropdown :options="$industries" placeholder="Select Industry" model="leadData.industry" />
                    <x-input-error :messages="$errors->get('leadData.industry')" />
                </div>
                <div>
                    <x-input-label for="lead_source" value="Source" />
                    <x-dropdown :options="$leadSources" placeholder="Select Source" model="leadData.lead_source" />
                    <x-input-error :messages="$errors->get('leadData.lead_source')" />
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100 dark:border-white/5"></div>

        <!-- Social -->
        <div>
            <h4 class="text-xs uppercase tracking-widest font-semibold text-gray-400 dark:text-gray-500 mb-4">
                Social
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <x-input-label for="instagram" value="Instagram" />
                    <x-text-input wire:model.live.debounce.350ms="leadData.instagram" id="instagram"
                        placeholder="@username" />
                    <x-input-error :messages="$errors->get('leadData.instagram')" />
                </div>
                <div>
                    <x-input-label for="linkedin" value="LinkedIn" />
                    <x-text-input wire:model.live.debounce.350ms="leadData.linkedin" id="linkedin"
                        placeholder="linkedin.com/in/..." />
                    <x-input-error :messages="$errors->get('leadData.linkedin')" />
                </div>
                <div>
                    <x-input-label for="facebook" value="Facebook" />
                    <x-text-input wire:model.live.debounce.350ms="leadData.facebook" id="facebook"
                        placeholder="facebook.com/..." />
                    <x-input-error :messages="$errors->get('leadData.facebook')" />
                </div>
            </div>
        </div>

    </form>
</x-modal>
