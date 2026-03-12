<x-modal x-cloak title="{{ $isEditing ? 'Update Meeting' : 'Add New Meeting' }}" for="Goals"
         record_id="{{ $meetingId }}" isEditing="{{ $isEditing }}">
    <form class="grid grid-cols-[45%_1fr] gap-8" wire:submit.prevent="submit">

        <!-- Meeting Details -->
        <section class="space-y-8 w-full">
            <h4 class="text-sm uppercase tracking-widest font-bold text-gray-500 dark:text-gray-400 border-b border-gray-200/50 dark:border-gray-700/50 pb-3">
                Meeting Details
            </h4>
                <x-input-label for="title" value="Meeting Title"/>
                <x-text-input
                    type="text"
                    wire:model="meetingData.title"
                    id="title"
                    placeholder="Enter the meeting title"
                />
                <x-input-error :messages="$errors->get('meetingData.title')" class="mt-1"/>

                <div class="w-full">
                    <x-input-label for="date" value="Date"/>
                    <x-date-picker model="meetingData.date" id="date" placeholder="Select date" />
                    <x-input-error :messages="$errors->get('meetingData.date')" class="mt-1"/>
                </div>

                <div class="w-full">
                    <x-input-label for="hour" value="Hour"/>
                    <x-time-picker model="meetingData.hour" id="hour" placeholder="Select time" />
                    <x-input-error :messages="$errors->get('meetingData.hour')" class="mt-1"/>
                </div>

            <div class="flex gap-4">
                <div class="w-full">
                    <x-input-label for="status" value="Status"/>
                    <x-dropdown model="meetingData.status" placeholder="-- Select Status --" :options="$statuses" id="status">
                    </x-dropdown>
                    <x-input-error :messages="$errors->get('meetingData.status')" class="mt-1"/>
                </div>

                <div class="w-full">
                    <x-input-label for="link" value="Meeting Link"/>
                    <x-text-input
                        type="url"
                        wire:model="meetingData.link"
                        id="link"
                        placeholder="https://meet.example.com"
                    />
                    <x-input-error :messages="$errors->get('meetingData.link')" class="mt-1"/>
                </div>
            </div>

            <div>
                <x-input-label for="lead_id" value="Lead/Client"/>
                <x-dropdown :options="$leads" placeholder="-- Select Lead --" model="meetingData.lead_id" associative="true"/>
                <x-input-error :messages="$errors->get('meetingData.lead_id')"/>
            </div>
        </section>

        <!-- Meeting Notes -->
        <section class="space-y-8 w-full">
            <h4 class="text-sm uppercase tracking-widest font-bold text-gray-500 dark:text-gray-400 border-b border-gray-200/50 dark:border-gray-700/50 pb-3">
                Meeting Notes
            </h4>

            <div>
                <x-input-label for="notes" value="Notes"/>
                <textarea
                    wire:model="meetingData.notes"
                    id="notes"
                    rows="20"
                    placeholder="Add any relevant details or comments..."
                    class="w-full rounded-2xl px-5 py-4 bg-white/80 dark:bg-dark/60 border border-gray-300/40 dark:border-gray-700/60 focus:border-primaryColor focus:ring-2 focus:ring-primaryColor/20
                       text-gray-800 dark:text-gray-100 font-body placeholder-gray-400 dark:placeholder-gray-500
                       shadow-lg backdrop-blur-md transition-all duration-200 resize-none hover:shadow-xl"
                ></textarea>
                <x-input-error :messages="$errors->get('meetingData.notes')" class="mt-2"/>
            </div>
        </section>
    </form>
</x-modal>
