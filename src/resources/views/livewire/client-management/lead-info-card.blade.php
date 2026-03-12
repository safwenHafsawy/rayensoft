<div class="lg:col-span-1 space-y-6">
    <div class="glass-card rounded-3xl p-8 shadow-premium relative overflow-hidden group">
        {{-- Decorative --}}
        <div
            class="absolute top-0 right-0 w-32 h-32 bg-primaryColor/10 rounded-full blur-2xl pointer-events-none transition-all duration-500 group-hover:bg-primaryColor/20">
        </div>

        @if (!$isEditing)
            {{-- VIEW MODE --}}

            {{-- Avatar / Initials --}}
            <div class="flex flex-col items-center text-center relative z-10">
                <div
                    class="w-24 h-24 rounded-full premium-gradient flex items-center justify-center shadow-lg mb-4 ring-4 ring-white dark:ring-white/10">
                    <span
                        class="text-3xl font-black text-white tracking-widest">{{ substr($leadData['name'], 0, 2) }}</span>
                </div>
                <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">{{ $leadData['name'] }}</h2>

                {{-- Status Badge --}}
                <div
                    class="mt-3 inline-flex items-center gap-2 px-4 py-1.5 rounded-full {{ $this->getStatusClass($leadData['status']) }} border-0 text-xs font-bold uppercase tracking-wider shadow-sm transition-transform hover:scale-105">
                    <i class="{{ $this->getStatusIcon($leadData['status']) }}"></i>
                    {{ $leadData['status'] }}
                </div>
            </div>

            {{-- Contact Details --}}
            <div class="mt-8 space-y-4">
                {{-- Phone --}}
                <div
                    class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 hover:border-primaryColor/30 transition-colors group/item">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-lg bg-white dark:bg-white/10 flex items-center justify-center shrink-0 shadow-sm text-gray-500 dark:text-gray-400">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="flex flex-col text-left">
                            <span class="text-xs text-gray-400 font-bold uppercase">Phone</span>
                            <span
                                class="text-sm font-bold text-gray-900 dark:text-white">{{ $leadData['phone'] ?: 'N/A' }}</span>
                        </div>
                    </div>
                    @if ($leadData['phone'])
                        <button x-data="{ copied: false }"
                            @click="navigator.clipboard.writeText('{{ $leadData['phone'] }}'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="opacity-0 group-hover/item:opacity-100 transition-opacity text-gray-400 hover:text-primaryColor"
                            title="Copy">
                            <i x-show="!copied" class="fa-regular fa-copy"></i>
                            <i x-show="copied" class="fa-solid fa-check text-green-500" x-cloak></i>
                        </button>
                    @endif
                </div>

                {{-- Email --}}
                <div
                    class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 hover:border-primaryColor/30 transition-colors group/item">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div
                            class="w-10 h-10 rounded-lg bg-white dark:bg-white/10 flex items-center justify-center shrink-0 shadow-sm text-gray-500 dark:text-gray-400">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="flex flex-col text-left overflow-hidden">
                            <span class="text-xs text-gray-400 font-bold uppercase">Email</span>
                            <span
                                class="text-sm font-bold text-darkColor dark:text-white truncate">{{ $leadData['email'] ?: 'N/A' }}</span>
                        </div>
                    </div>
                    @if ($leadData['email'])
                        <button x-data="{ copied: false }"
                            @click="navigator.clipboard.writeText('{{ $leadData['email'] }}'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="opacity-0 group-hover/item:opacity-100 transition-opacity text-gray-400 hover:text-primaryColor"
                            title="Copy">
                            <i x-show="!copied" class="fa-regular fa-copy"></i>
                            <i x-show="copied" class="fa-solid fa-check text-green-500" x-cloak></i>
                        </button>
                    @endif
                </div>

                {{-- Socials Grid --}}
                <div class="grid grid-cols-3 gap-2 mt-4">
                    {{-- Instagram --}}
                    @php $instagram = $leadData['instagram']; @endphp
                    @if ($instagram)
                        <a href="https://instagram.com/{{ $instagram }}" target="_blank"
                            class="flex flex-col items-center justify-center p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 hover:bg-pink-50 hover:border-pink-200 hover:text-pink-600 transition-all">
                            <i class="fa-brands fa-instagram text-xl mb-1"></i>
                        </a>
                    @else
                        <div class="flex flex-col items-center justify-center p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 opacity-40 cursor-not-allowed"
                            title="Not provided">
                            <i class="fa-brands fa-instagram text-xl mb-1 text-gray-400"></i>
                        </div>
                    @endif

                    {{-- LinkedIn --}}
                    @php $linkedin = $leadData['linkedin']; @endphp
                    @if ($linkedin)
                        <a href="https://linkedin.com/in/{{ $linkedin }}" target="_blank"
                            class="flex flex-col items-center justify-center p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition-all">
                            <i class="fa-brands fa-linkedin text-xl mb-1"></i>
                        </a>
                    @else
                        <div class="flex flex-col items-center justify-center p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 opacity-40 cursor-not-allowed"
                            title="Not provided">
                            <i class="fa-brands fa-linkedin text-xl mb-1 text-gray-400"></i>
                        </div>
                    @endif

                    {{-- Facebook --}}
                    @php $facebook = $leadData['facebook']; @endphp
                    @if ($facebook)
                        <a href="https://facebook.com/{{ $facebook }}" target="_blank"
                            class="flex flex-col items-center justify-center p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition-all">
                            <i class="fa-brands fa-facebook text-xl mb-1"></i>
                        </a>
                    @else
                        <div class="flex flex-col items-center justify-center p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 opacity-40 cursor-not-allowed"
                            title="Not provided">
                            <i class="fa-brands fa-facebook text-xl mb-1 text-gray-400"></i>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Lead Metadata Card --}}
            <div class="glass-card rounded-3xl p-6 mt-6 shadow-sm border border-gray-100 dark:border-white/5">
                <h3
                    class="text-xs font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info"></i> Lead Metadata
                </h3>
                <div class="space-y-4">
                    <div
                        class="flex justify-between items-center pb-3 border-b border-gray-50 dark:border-white/5 last:border-0 last:pb-0">
                        <span class="text-sm text-gray-500 font-medium">Source</span>
                        <span
                            class="text-sm font-bold text-gray-900 dark:text-white px-3 py-1 rounded-lg bg-gray-100 dark:bg-white/10">{{ $lead->lead_source ?: 'N/A' }}</span>
                    </div>
                    <div
                        class="flex justify-between items-center pb-3 border-b border-gray-50 dark:border-white/5 last:border-0 last:pb-0">
                        <span class="text-sm text-gray-500 font-medium">Industry</span>
                        <span
                            class="text-sm font-bold text-gray-900 dark:text-white px-3 py-1 rounded-lg bg-gray-100 dark:bg-white/10">{{ $lead->industry ?: 'N/A' }}</span>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700/50 flex flex-col gap-3">
                <button wire:click="edit"
                    class="w-full py-3 rounded-xl bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Lead Profile
                </button>
            </div>
        @else
            {{-- EDIT MODE --}}
            <div class="space-y-4">
                <h2 class="text-xl font-black text-gray-900 dark:text-white">Edit Profile</h2>

                {{-- Name --}}
                <div>
                    <x-input-label for="leadData.name" value="Name" />
                    <x-text-input type="text" wire:model="leadData.name" />
                    <x-input-error :messages="$errors->get('leadData.name')" />
                </div>

                {{-- Phone --}}
                <div>
                    <x-input-label for="leadData.phone" value="Phone" />
                    <x-text-input type="text" wire:model="leadData.phone" />
                    <x-input-error :messages="$errors->get('leadData.phone')" />
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="leadData.email" value="Email" />
                    <x-text-input type="email" wire:model="leadData.email" />
                    <x-input-error :messages="$errors->get('leadData.email')" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- Source --}}
                    <div>
                        <x-input-label for="leadData.lead_source" value="Source" />
                        <x-dropdown :options="$leadSources" placeholder="Select Source" model="leadData.lead_source" />
                        <x-input-error :messages="$errors->get('leadData.lead_source')" />
                    </div>
                    {{-- Industry --}}
                    <div>
                        <x-input-label for="leadData.industry" value="Industry" />
                        <x-dropdown :options="$industries" placeholder="Select Industry" model="leadData.industry" />
                        <x-input-error :messages="$errors->get('leadData.industry')" />
                    </div>
                </div>

                {{-- Socials --}}
                <div class="space-y-3 pt-4 border-t border-gray-100">
                    <h3 class="text-xs font-black uppercase text-gray-400">Social Media</h3>
                    <div class="relative">
                        <i class="fa-brands fa-instagram absolute left-3 top-6 text-gray-400"></i>
                        <x-text-input class="pl-10" type="text" wire:model="leadData.instagram"
                            placeholder="Instagram Username" />
                        <x-input-error :messages="$errors->get('leadData.instagram')" />
                    </div>
                    <div class="relative">
                        <i class="fa-brands fa-linkedin absolute left-3 top-6 text-gray-400"></i>
                        <x-text-input class="pl-10" type="text" wire:model="leadData.linkedin"
                            placeholder="LinkedIn Username" />
                        <x-input-error :messages="$errors->get('leadData.linkedin')" />
                    </div>
                    <div class="relative">
                        <i class="fa-brands fa-facebook absolute left-3 top-6 text-gray-400"></i>
                        <x-text-input class="pl-10" type="text" wire:model="leadData.facebook"
                            placeholder="facebook.com/username" />
                        <x-input-error :messages="$errors->get('leadData.facebook')" />
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3 pt-4">
                    <button wire:click="cancel"
                        class="flex-1 py-2 rounded-xl bg-gray-100 text-gray-700 font-bold hover:bg-gray-200 transition-colors">Cancel</button>
                    <button wire:click="saveLeadData"
                        class="flex-1 py-2 rounded-xl bg-primaryColor text-white font-bold hover:bg-primaryColor-dark shadow-lg shadow-primaryColor/20 transition-all">Save
                        Changes</button>
                </div>
            </div>
        @endif
    </div>
</div>
