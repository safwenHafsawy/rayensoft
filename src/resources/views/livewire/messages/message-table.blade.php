<div class="relative glass-card rounded-3xl p-4 sm:p-8 overflow-hidden">
    {{-- Decorative background --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-primaryColor/5 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Header --}}
    <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl premium-gradient flex items-center justify-center shadow-premium">
                <i class="fa-solid fa-envelope text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-2xl font-heading font-black text-gray-900 dark:text-white tracking-tight">Messages</h1>
                <p class="text-sm text-gray-400 dark:text-gray-500 font-body mt-0.5">Manage and respond to client
                    inquiries</p>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="relative z-10 mb-8 grid md:grid-cols-4 xl:grid-cols-7 gap-4">
        <div class="col-span-6 xl:col-span-3">
            <x-input-label for="search" value="Search By Key Word" />
            <x-text-input type="text" id="search" wire:model.live="search" placeholder="Search by name" />
        </div>
    </div>

    {{-- Table --}}
    <div class="relative w-full overflow-x-auto rounded-2xl border border-gray-100/50 dark:border-white/5">
        <table class="w-full table-auto min-w-[1000px] border-collapse">
            <thead>
                <x-table.table-row :header="true">
                    <x-table.table-header>Client Name</x-table.table-header>
                    <x-table.table-header>Email</x-table.table-header>
                    <x-table.table-header>Subject</x-table.table-header>
                    <x-table.table-header>Message</x-table.table-header>
                    <x-table.table-header>Date</x-table.table-header>
                    <x-table.table-header></x-table.table-header>
                </x-table.table-row>
            </thead>
            <tbody>
                @if ($messages->isEmpty())
                    <x-table.table-row>
                        <x-table.table-data colspan="6"
                            class="text-center text-gray-400 dark:text-gray-500 text-lg py-20 font-body">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-white/5 flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-inbox text-2xl text-gray-300 dark:text-gray-600"></i>
                                </div>
                                <span class="font-heading font-bold">No messages yet</span>
                                <span class="text-sm mt-1 text-gray-400">Your inbox is empty</span>
                            </div>
                        </x-table.table-data>
                    </x-table.table-row>
                @else
                    @foreach ($messages as $message)
                        <x-table.table-row>
                            <x-table.table-data>
                                <div class="flex items-center space-x-3">
                                    <div class="relative flex-shrink-0">
                                        <div
                                            class="w-9 h-9 rounded-full bg-primaryColor/10 dark:bg-primaryColor/20 text-primaryColor flex items-center justify-center font-bold text-sm">
                                            {{ substr($message->fullname, 0, 1) }}
                                        </div>
                                        @if ($message->status === 'unread')
                                            <span
                                                class="absolute -top-0.5 -right-0.5 block h-2.5 w-2.5 rounded-full bg-green-500 ring-2 ring-white dark:ring-[#212121]"></span>
                                        @endif
                                    </div>
                                    <span
                                        class="font-bold text-gray-900 dark:text-white">{{ $message->fullname }}</span>
                                </div>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span class="text-gray-600 dark:text-gray-400">{{ $message->email }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span
                                    class="text-gray-600 dark:text-gray-400">{{ $message->subject ? Str::limit($message->subject, 40) : '-' }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span
                                    class="text-gray-500 dark:text-gray-400">{{ $message->message ? Str::limit($message->message, 50) : '-' }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <span
                                    class="text-xs text-gray-500">{{ $message->created_at->format('Y-m-d , H:i A') }}</span>
                            </x-table.table-data>
                            <x-table.table-data>
                                <div class="flex items-center space-x-1">
                                    <a href="{{ route('messages.details', $message) }}"
                                        class="p-2 rounded-xl text-gray-400 hover:text-primaryColor hover:bg-primaryColor/5 transition-all duration-200">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    {{-- <button wire:click="confirmDeleteMessage('{{ $message->id }}')"
                                        class="p-2 rounded-xl text-gray-400 hover:text-red-500 hover:bg-red-500/5 transition-all duration-200">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button> --}}
                                </div>
                            </x-table.table-data>
                        </x-table.table-row>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="mt-6 px-2">
            {{ $messages->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
@if ($messageIdToDelete)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="w-full max-w-md glass-card rounded-2xl shadow-premium-lg overflow-hidden animate-fade-up">
            <div class="flex justify-between items-center px-6 py-4 rounded-t-2xl premium-gradient text-white">
                <h5 class="text-lg font-heading font-bold">Delete Message</h5>
                <button wire:click="closeModal" class="hover:text-white/70 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="px-6 py-6 text-gray-700 dark:text-gray-200 font-body">
                Are you sure you want to delete this message? This action cannot be undone.
            </div>
            <div
                class="flex justify-end space-x-3 px-6 py-4 bg-gray-50 dark:bg-white/5 border-t border-gray-100 dark:border-white/5">
                <button wire:click="closeModal"
                    class="px-4 py-2 text-sm font-bold text-gray-600 dark:text-gray-300
                               bg-gray-100 dark:bg-white/5 rounded-xl hover:bg-gray-200 dark:hover:bg-white/10 transition-colors border border-gray-200 dark:border-white/10">
                    Cancel
                </button>
                <button wire:click="destroyMessage"
                    class="px-4 py-2 text-sm font-bold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors shadow-md">
                    Delete
                </button>
            </div>
        </div>
    </div>
@endif
