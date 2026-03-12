<?php

namespace App\Livewire\Team;

use App\Models\User;
use App\Models\WorkSession;
use App\Models\WorkSessionBreaks;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TeamWorkloadDistribution extends Component
{
    public array $chartData = [];

    public function mount(): void
    {
        $this->loadMonthlyWorkData();
    }

    public function loadMonthlyWorkData(): void
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $users = User::all();

        foreach ($users as $user) {
            $totalWorkedSeconds = WorkSession::where('user_id', $user->id)
                ->whereBetween('check_in_time', [$startOfMonth, $endOfMonth])
                ->whereNotNull('check_out_time')
                ->get()
                ->sum(function ($session) {
                    return Carbon::parse($session->check_in_time)->diffInSeconds(Carbon::parse($session->check_out_time));
                });

            $totalPausedSeconds = WorkSessionBreaks::whereHas('workSession', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
                ->whereBetween('started_at', [$startOfMonth, $endOfMonth])
                ->whereNotNull('ended_at')
                ->get()
                ->sum(function ($break) {
                    return Carbon::parse($break->started_at)->diffInSeconds(Carbon::parse($break->ended_at));
                });

            // Net worked time in seconds
            $netSeconds = $totalWorkedSeconds - $totalPausedSeconds;

            // Convert to minutes (rounded)
            $totalMinutes = round($netSeconds / 60, 0);


            $this->chartData[] = [
                'user' => $user->name,
                'hours' => $totalMinutes,
            ];

        }
    }

    public function render(): Factory|View
    {
        return view('livewire.team.team-workload-distribution');
    }
}
