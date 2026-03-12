<?php

namespace App\Livewire\Team;

use App\Models\WorkSession;
use App\Models\WorkSessionBreaks;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class WorkSessionTimer extends Component
{
    public array $activeSessions = [];

    protected $listeners = ['refreshActiveSessions' => 'loadActiveSessions'];

    public function mount(): void
    {
        $this->loadActiveSessions();
    }

    public function loadActiveSessions(): void
    {
        $sessions = WorkSession::whereNull('check_out_time')->get();

        $this->activeSessions = $sessions->map(function ($session) {
            $start = Carbon::parse($session->check_in_time);

            //calculate break duration in minutes
            $breaks = WorkSessionBreaks::where('work_session_id', $session->id)->get();
            $breakDuration = $breaks->sum(function ($break) {
                return Carbon::parse($break->started_at)->diffInMinutes(Carbon::parse($break->ended_at));
            });

            $duration = ($start->diffInMinutes(now())) - $breakDuration;

            return [
                'user_image' => $session->user->photo,
                'user' => $session->user->name,
                'duration' => $duration, // in minutes
                'status' => $session->status,
                'formatted' => sprintf('%02d:%02d', intdiv($duration, 60), $duration % 60),
            ];
        })->toArray();


    }

    public function refreshSessions(): void
    {
        $this->loadActiveSessions();
    }

    public function render(): Factory|View
    {
        return view('livewire.team.work-session-timer');
    }
}
