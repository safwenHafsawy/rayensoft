<div x-data="{
    open: false,
    unreadCount: {{ auth()->user()->unreadNotifications()->count() }},
    notifications: {{ auth()->user()->unreadNotifications()->take(10)->get() }},

    async fetchFresh() {
        if (this.open) {
            try {
                let res = await fetch('/api/notifications');
                if (res.ok) {
                    let data = await res.json();
                    this.notifications = data.notifications;
                    this.unreadCount = data.unreadCount;
                }
            } catch (e) {
                console.error('Failed to fetch notifications', e);
            }
        }
    },

    async markAsRead(id) {
        try {
            let res = await fetch(`/api/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            if (res.ok) {
                this.notifications = this.notifications.filter(n => n.id !== id);
                this.unreadCount = Math.max(0, this.unreadCount - 1);
            }
        } catch (e) {
            console.error('Failed to mark as read', e);
        }
    },

    async markAllRead() {
        try {
            let res = await fetch('/api/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            if (res.ok) {
                this.notifications = [];
                this.unreadCount = 0;
            }
        } catch (e) {
            console.error('Failed to mark all as read', e);
        }
    },

    formatTime(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }
}" @click.away="open = false" class="relative">

    <!-- Trigger Button -->
    <button @click="open = !open; if(open) fetchFresh()"
        class="relative w-9 h-9 flex items-center justify-center rounded-lg text-gray-400 hover:text-primaryColor hover:bg-white dark:hover:bg-white/10 transition-all duration-300 group">
        <i class="fa-solid fa-bell text-xs group-hover:rotate-12 transition-transform"></i>

        <template x-if="unreadCount > 0">
            <span class="absolute top-2 right-2 flex h-2 w-2">
                <span
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primaryColor opacity-75"></span>
                <span
                    class="relative inline-flex rounded-full h-2 w-2 bg-primaryColor border border-white dark:border-[#1a1a1a]"></span>
            </span>
        </template>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        class="absolute right-0 mt-4 w-80 sm:w-96 bg-light dark:bg-dark border border-gray-200 dark:border-light/30 rounded-xl shadow-premium-lg overflow-hidden origin-top-right z-50">

        <!-- Header -->
        <div class="p-4 border-b dark:border-light/5 flex items-center justify-between bg-gray-50 dark:bg-dark">
            <div class="flex items-center gap-2">
                <h3 class="font-bold text-dark dark:text-light uppercase tracking-wider text-xs">Notifications</h3>
                <span x-show="unreadCount > 0"
                    class="px-2 py-0.5 rounded-full premium-gradient text-[10px] font-black text-light shadow-sm"
                    x-text="unreadCount"></span>
            </div>
            <button @click="markAllRead()"
                class="text-[10px] font-bold text-primaryColor hover:underline uppercase tracking-tight">
                Mark all
            </button>
        </div>

        <!-- Scrollable content -->
        <div class="max-h-[28rem] overflow-y-auto">
            <template x-for="note in notifications" :key="note.id">
                <div
                    class="p-4 border-b dark:border-light/5 hover:bg-primaryColor/5 transition-colors group flex gap-4">
                    <!-- Icon placeholder based on type -->
                    <div
                        class="w-10 h-10 rounded-xl bg-primaryColor/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i :class="{
                            'fa-solid fa-comment': note.type && note.type.includes('Message'),
                            'fa-solid fa-bell': !note.type || (!note.type.includes('Message') && !note.type.includes(
                                'Alert')),
                            'fa-solid fa-triangle-exclamation text-yellow-500': note.type && note.type.includes(
                                'Warning'),
                            'fa-solid fa-circle-check text-green-500': note.type && note.type.includes('Success'),
                        }"
                            class="text-primaryColor"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-dark dark:text-light line-clamp-2 leading-relaxed"
                            x-text="note.data.message || 'New notification'"></p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1.5 flex items-center gap-1">
                            <i class="fa-regular fa-clock text-[9px]"></i>
                            <span x-text="formatTime(note.created_at)"></span>
                        </p>

                        <!-- Actions Logic -->
                        <div class="mt-3 flex items-center gap-2">
                            <template x-if="note.data.url">
                                <a :href="note.data.url" @click="markAsRead(note.id)"
                                    class="px-3 py-1 bg-primaryColor text-white text-[10px] font-bold rounded-lg hover:opacity-90 transition-all uppercase tracking-tight">
                                    Go to
                                </a>
                            </template>

                            <template x-if="!note.data.url">
                                <button @click="markAsRead(note.id)"
                                    class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-dark dark:text-light text-[10px] font-bold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors uppercase tracking-tight">
                                    Mark as read
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Unread indicator -->
                    <div x-show="!note.read_at"
                        class="w-1.5 h-1.5 rounded-full bg-primaryColor self-start mt-1 flex-shrink-0"></div>
                </div>
            </template>

            <!-- Empty State -->
            <template x-if="notifications.length === 0">
                <div class="py-12 px-4 text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-gray-50 dark:bg-light/5 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-bell-slash text-gray-300 dark:text-gray-600 text-2xl"></i>
                    </div>
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">All caught
                        up!</p>
                    <p class="text-[11px] text-gray-500 dark:text-gray-600 mt-2">No new notifications for you.</p>
                </div>
            </template>
        </div>
    </div>
</div>
