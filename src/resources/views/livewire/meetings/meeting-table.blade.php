<div
    class="relative bg-gradient-to-br from-white/90 to-white dark:from-dark dark:to-dark/95 rounded-[1.2rem] p-4 sm:p-8 lg:p-10 shadow-2xl shadow-primaryColor/10 dark:shadow-dark border border-gray-100 dark:border-primaryColor-darker/30 transition-all duration-500 transform hover:shadow-primaryColor/20">
    <div
        class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 pb-4 border-b border-gray-200 dark:border-dark-600">
        <h1
            class="text-2xl sm:text-3xl font-heading font-extrabold text-gray-900 dark:text-light flex items-center mb-4 sm:mb-0 transition-colors duration-300">
            <i class="fa-solid fa-handshake-angle mr-3 text-primaryColor text-2xl"></i>
            Meetings List
        </h1>
    </div>
    <div class="w-full overflow-x-auto">
        <table class="table-fixed w-full min-w-[800px]">
            <x-table.table-row :header="true">
                <x-table.table-header>Title</x-table.table-header>
                <x-table.table-header>Date</x-table.table-header>
                <x-table.table-header>Time</x-table.table-header>
                <x-table.table-header>Name</x-table.table-header>
                <x-table.table-header>Phone</x-table.table-header>
                <x-table.table-header>Email</x-table.table-header>
                <x-table.table-header>Status</x-table.table-header>
            </x-table.table-row>
            @if ($meetings->isEmpty())
                <x-table.table-row>
                    <x-table.table-data colspan="6"
                        class="text-center text-gray-400 dark:text-gray-500 text-xl py-16 font-body italic">
                        <i class="fa-solid fa-mug-hot mr-2"></i>
                        It's quiet... no recent meetings to display.
                    </x-table.table-data>
                </x-table.table-row>
            @else
                @foreach ($meetings as $meeting)
                    <x-table.table-row :onClick="'openUpsertMeeting(' . $meeting->id . ')'">
                        <x-table.table-data>{{ $meeting->title }}</x-table.table-data>
                        <x-table.table-data>{{ $meeting->date }} </x-table.table-data>
                        <x-table.table-data>{{ $meeting->hour }}</x-table.table-data>
                        <x-table.table-data>{{ $meeting->lead->name }}</x-table.table-data>
                        <x-table.table-data>{{ $meeting->lead->phone }}</x-table.table-data>
                        <x-table.table-data>{{ $meeting->lead->email }}</x-table.table-data>
                        <x-table.table-data>
                            <span
                                class="{{ $this->getStatusColor($meeting->status) }} px-2 py-1 rounded-lg font-bold">{{ $meeting->status }}</span></x-table.table-data>
                    </x-table.table-row>
                @endforeach
            @endif
        </table>
    </div>
</div>
