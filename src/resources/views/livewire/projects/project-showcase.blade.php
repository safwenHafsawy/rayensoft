<div class="space-y-8 animate-fade-up">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">
                Project <span class="gradient-text">Showcase</span>
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manage and monitor all active Rayen Soft projects.</p>
        </div>
        <div class="flex items-center gap-3">
            <button
                class="px-5 py-2.5 rounded-2xl bg-white/50 dark:bg-white/5 border border-white/20 dark:border-white/10 text-sm font-semibold hover:bg-white/80 dark:hover:bg-white/10 transition-all flex items-center gap-2">
                <i class="fa-solid fa-arrow-down-wide-short opacity-60"></i>
                Sort By
            </button>
            <button
                class="px-5 py-2.5 rounded-2xl premium-gradient text-white text-sm font-bold shadow-premium-glow hover:scale-105 transition-all flex items-center gap-3">
                <i class="fa-solid fa-plus"></i>
                New Project
            </button>
        </div>
    </div>

    {{-- Project Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects as $project)
            <div
                class="glass-card hover-lift p-6 rounded-[2.5rem] relative overflow-hidden noise-overlay flex flex-col group">
                {{-- Status & Phase --}}
                <div class="flex items-center justify-between mb-4">
                    <span class="font-mono text-[10px] font-bold tracking-widest opacity-50 uppercase">
                        PHASE: {{ $project->phase }}
                    </span>
                    <span @class([
                        'px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter',
                        'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' =>
                            $project->status === 'Completed',
                        'bg-blue-500/10 text-blue-500 border border-blue-500/20' =>
                            $project->status === 'In Progress',
                        'bg-amber-500/10 text-amber-500 border border-amber-500/20' =>
                            $project->status === 'Pending',
                    ])>
                        {{ $project->status }}
                    </span>
                </div>

                {{-- Title & Client --}}
                <div class="mb-4">
                    <h3
                        class="text-xl font-bold text-gray-900 dark:text-white group-hover:gradient-text transition-all duration-300">
                        {{ $project->name }}
                    </h3>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="w-5 h-5 rounded-full bg-blue-500/10 flex items-center justify-center">
                            <i class="fa-solid fa-user text-[10px] text-blue-500"></i>
                        </div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            {{ $project->client->lead->name ?? 'Unknown Client' }}
                        </span>
                    </div>
                </div>

                {{-- Description --}}
                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 mb-6 leading-relaxed">
                    {{ $project->description }}
                </p>

                {{-- Progress Bar --}}
                <div class="mt-auto">
                    <div class="flex items-center justify-between text-[10px] font-bold uppercase mb-2">
                        <span
                            class="opacity-50 text-gray-500 dark:text-gray-400 font-mono tracking-wider">Progress</span>
                        <span class="text-blue-500">
                            @if ($project->status === 'Completed')
                                100%
                            @elseif($project->status === 'In Progress')
                                65%
                            @else
                                0%
                            @endif
                        </span>
                    </div>
                    <div class="w-full h-1.5 bg-gray-200 dark:bg-white/5 rounded-full overflow-hidden">
                        <div @class([
                            'h-full rounded-full transition-all duration-1000',
                            'bg-emerald-500 w-full' => $project->status === 'Completed',
                            'premium-gradient w-[65%]' => $project->status === 'In Progress',
                            'bg-gray-400 w-0' => $project->status === 'Pending',
                        ])></div>
                    </div>
                </div>

                {{-- Footer Info --}}
                <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100 dark:border-white/5">
                    <div class="flex items-center gap-2 text-gray-500">
                        <i class="fa-regular fa-calendar-check text-xs"></i>
                        <span
                            class="text-[10px] font-bold uppercase font-mono tracking-tight">{{ \Carbon\Carbon::parse($project->start_date)->format('M d, Y') }}</span>
                    </div>
                    <span
                        class="px-2 py-0.5 rounded text-[10px] font-black bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-600 dark:text-gray-400 uppercase tracking-tighter">
                        {{ $project->plan }} Plan
                    </span>
                </div>
            </div>
        @empty
            <div
                class="col-span-full py-24 flex flex-col items-center justify-center text-center glass-card rounded-[3rem] border-dashed border-2 border-white/20">
                <div class="w-20 h-20 rounded-3xl bg-blue-500/10 flex items-center justify-center mb-6 animate-float">
                    <i class="fa-solid fa-folder-open text-3xl text-blue-500"></i>
                </div>
                <h3 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white">No Projects Yet</h3>
                <p class="text-gray-500 max-w-sm mx-auto mt-2 px-6">Your projects workspace is currently empty. Start by
                    initializing a new project for one of your clients.</p>
                <button
                    class="mt-8 px-8 py-3 rounded-2xl premium-gradient text-white font-black shadow-premium-glow hover:scale-105 transition-all flex items-center gap-3">
                    <i class="fa-solid fa-rocket"></i>
                    Initialize First Project
                </button>
            </div>
        @endforelse
    </div>
</div>
