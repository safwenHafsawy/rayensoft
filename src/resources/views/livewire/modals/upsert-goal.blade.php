<x-modal x-cloak title="{{ $isEditing ? 'Update Goal' : 'Add New Goal' }}" for="Goals" record_id="{{ $goalId }}" isEditing="{{ $isEditing }}">
    <form class="p-6 md:p-10 space-y-10" wire:submit.prevent="submit">

        <!-- Goal Info -->
        <section class="space-y-6">
            <h4 class="text-sm uppercase tracking-wide font-semibold text-gray-600 dark:text-gray-400 border-b border-gray-200/50 dark:border-gray-700/50 pb-2">
                Goal Details
            </h4>

            <div class="grid gap-6 sm:{{ !$isEditing ? 'grid-cols-[1fr_25%_20%]' : 'grid-cols-[1fr_20%]' }}">
                <!-- Title -->
                <div >
                    <x-input-label for="goalTitle" value="Goal Title" />
                    <x-text-input type="text" wire:model="goalData.title" id="goalTitle"
                                  class="{{ $isEditing ? 'bg-gray-100 border-none' : 'bg-white/80 dark:bg-dark/50 border border-gray-300/40 dark:border-gray-700/60 backdrop-blur-sm' }} rounded-2xl px-4 py-3 w-full shadow-sm focus:ring-2 focus:ring-primaryColor/20 focus:border-primaryColor"
                                   />
                    <x-input-error :messages="$errors->get('goalData.title')" />
                </div>


                @if (!$isEditing)
                    <!-- Assigned To -->
                    <div>
                        <x-input-label for="user_id" value="Assigned To" />
                        <x-dropdown :options="$users" placeholder="-- Select Member --" model="goalData.user_id" associative="true"/>
                        <x-input-error :messages="$errors->get('goalData.user_id')" />
                    </div>

                    <!-- Area -->
                    <div>
                        <x-input-label for="area" value="Area" />
                        <x-dropdown :options="$areas" placeholder="-- Select Area --" model="goalData.area" />
                        <x-input-error :messages="$errors->get('goalData.area')" />
                    </div>
                @else
                    <div>
                        <x-input-label for="area" value="Area" />
                        <x-text-input type="text" value="{{ $goalData['area'] }}" id="area"
                                      class="bg-gray-100 border-none rounded-2xl px-4 py-3 w-full shadow-sm" disabled />
                    </div>
                @endif
            </div>
        </section>

        <!-- Description -->
        <section>
            <x-input-label for="description" value="Description" />
            <textarea
                wire:model="goalData.description"
                id="notes"
                rows="5"
                placeholder="Add any relevant details or comments..."
                class="w-full rounded-2xl px-4 py-3 bg-white/70 dark:bg-dark/50 border border-gray-300/40 dark:border-gray-700/60
                       focus:border-primaryColor focus:ring-2 focus:ring-primaryColor/20
                       text-gray-800 dark:text-gray-100 font-body placeholder-gray-400 dark:placeholder-gray-500
                       shadow-sm backdrop-blur-sm transition-all duration-200 resize-none"
            ></textarea>
            <x-input-error :messages="$errors->get('goalData.description')" class="mt-2"/>
        </section>

        <!-- Dates & Status -->
        <section class="grid gap-6 sm:{{ $isEditing ? 'grid-cols-3' : 'grid-cols-2' }}">
            @if (!$isEditing)
                <div class="w-full">
                    <x-input-label for="start_date" value="Goal Start Date" />
                    <x-dropdown :options="$listOfDates" placeholder="-- Select Start Date --" model="goalData.start_date" />
                    <x-input-error :messages="$errors->get('goalData.start_date')" />
                </div>

                <div class="w-full">
                    <x-input-label for="duration" value="Goal Duration" />
                    <x-dropdown :options="['1' => '1 Week', '2' => '2 Weeks']" placeholder="-- Select Duration --" model="goalData.duration" associative="true"/>
                    <x-input-error :messages="$errors->get('goalData.duration')" />
                </div>
            @else
                <div class="w-full">
                    <x-input-label for="start_date" value="Goal Start Date" />
                    <x-text-input type="text" wire:model="goalData.start_date" id="start_date"
                                  class="bg-gray-100 border-none rounded-2xl px-4 py-3 w-full shadow-sm" disabled />
                </div>

                <div class="w-full">
                    <x-input-label for="duration" value="Goal Duration" />
                    <x-text-input type="text" value="{{ $goalData['duration'] }} weeks" id="duration"
                                  class="bg-gray-100 border-none rounded-2xl px-4 py-3 w-full shadow-sm" disabled />
                </div>

                <div class="w-full">
                    <x-input-label for="status" value="Status" />
                    <x-dropdown :options="$statuses" placeholder="-- Select Status --" model="goalData.status" />
                    <x-input-error :messages="$errors->get('goalData.status')" />
                </div>
            @endif
        </section>
    </form>
</x-modal>

