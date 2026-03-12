<x-app-layout>
    <div class="space-y-6">

        {{-- Header / Breadcrumbs Area --}}
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('messages') }}"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center gap-2 mb-2 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i> Back to Messages
                </a>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Message Details</h1>
            </div>
        </div>

        {{-- Main Layout Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left Column: Sender Info Card --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="relative glass-card rounded-3xl p-6 overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-primaryColor/5 rounded-full blur-3xl pointer-events-none">
                    </div>

                    <div class="relative z-10">
                        {{-- Avatar & Name --}}
                        <div class="flex items-center space-x-4 mb-6">
                            <div
                                class="w-14 h-14 rounded-2xl premium-gradient flex items-center justify-center shadow-premium text-white font-black text-xl">
                                {{ substr($message->fullname, 0, 1) }}
                            </div>
                            <div>
                                <h2 class="text-lg font-heading font-black text-gray-900 dark:text-white">
                                    {{ $message->fullname }}</h2>
                                <a href="mailto:{{ $message->email }}"
                                    class="text-sm text-primaryColor hover:underline font-body">{{ $message->email }}</a>
                            </div>
                        </div>

                        <div class="section-divider my-4"></div>

                        {{-- Details List --}}
                        <div class="space-y-4 mt-5">
                            @if ($message->businessName)
                                <div>
                                    <span
                                        class="text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 dark:text-gray-500">Company</span>
                                    <p class="font-bold text-gray-900 dark:text-white mt-0.5">
                                        {{ $message->businessName }}</p>
                                </div>
                            @endif

                            @if ($message->chosenPlan)
                                <div>
                                    <span
                                        class="text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 dark:text-gray-500">Interested
                                        Plan</span>
                                    <p class="mt-1">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-primaryColor/10 text-primaryColor">
                                            <i class="fa-solid fa-briefcase text-[10px]"></i>
                                            {{ $message->chosenPlan }}
                                        </span>
                                    </p>
                                </div>
                            @endif

                            <div>
                                <span
                                    class="text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 dark:text-gray-500">Status</span>
                                <p class="mt-1">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider
                                        {{ $message->status === 'unread' ? 'bg-green-500/10 text-green-600' : 'bg-gray-100 dark:bg-white/5 text-gray-500' }}">
                                        <i class="fa-solid fa-circle text-[6px]"></i>
                                        {{ $message->status ?? 'Read' }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <span
                                    class="text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 dark:text-gray-500">Received</span>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-0.5">
                                    {{ $message->created_at->format('Y-m-d , H:i A') }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $message->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="glass-card rounded-3xl p-6">
                    <h3
                        class="text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 dark:text-gray-500 mb-4">
                        Quick Actions</h3>
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}"
                        class="flex items-center space-x-3 p-3 rounded-xl hover:bg-primaryColor/5 transition-all duration-200 group cursor-pointer">
                        <div
                            class="w-10 h-10 rounded-xl bg-primaryColor/10 flex items-center justify-center text-primaryColor group-hover:scale-105 transition-transform">
                            <i class="fa-solid fa-reply"></i>
                        </div>
                        <div>
                            <span class="font-bold text-sm text-gray-900 dark:text-white">Reply via Email</span>
                            <span class="block text-xs text-gray-400">Open in your email client</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Right Column: Message Content --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="relative glass-card rounded-3xl p-6 sm:p-8 overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-48 h-48 bg-primaryColor/5 rounded-full blur-3xl pointer-events-none">
                    </div>

                    <div class="relative z-10">
                        {{-- Subject --}}
                        <div class="mb-6">
                            <span
                                class="text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 dark:text-gray-500">Subject</span>
                            <h2
                                class="text-2xl font-heading font-black text-gray-900 dark:text-white tracking-tight mt-1">
                                {{ $message->subject }}</h2>
                        </div>

                        <div class="section-divider my-6"></div>

                        {{-- Message Body --}}
                        <div>
                            <span
                                class="text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 dark:text-gray-500">Message</span>
                            <div
                                class="mt-3 p-6 rounded-2xl bg-gray-50/50 dark:bg-white/[0.02] border border-gray-100/50 dark:border-white/5 font-body text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                {{ $message->message }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
