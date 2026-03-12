<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lead Details') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="sm:px-6 lg:px-8 space-y-6">

            {{-- Header / Breadcrumbs Area --}}
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('client-management') }}"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center gap-2 mb-2 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Back to Leads
                    </a>
                    <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Lead Profile</h1>
                </div>
            </div>
            {{-- Main Layout Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column: Lead Info Card --}}
                <livewire:client-management.lead-info-card :lead="$lead" />

                {{-- Right Column: Activity Timeline & Actions --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Action Bar --}}
                    <livewire:client-management.lead-activity-form :lead="$lead"/>

                    {{-- Timeline --}}
                    <livewire:client-management.lead-activity-timeline :lead="$lead"/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
