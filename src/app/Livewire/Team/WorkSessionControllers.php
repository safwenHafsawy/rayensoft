<?php

namespace App\Livewire\Team;

use App\Models\WorkSession;
use App\Models\WorkSessionBreaks;
use App\Services\WorkSessionService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class WorkSessionControllers extends Component
{

    public $workSession;
    public $workSessionBreak;
    protected $service;

    public bool $openWorkSessionSummaryModal = false;

    protected $listeners = [ 'workSessionEnded' => 'endWorkSession'];

    public function boot(WorkSessionService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $this->workSession = WorkSession::where('user_id', auth()->id())
            ->where(function ($q) {
                $q->where('status', 'active')
                    ->orWhere('status', 'paused');
            })
            ->first();


        if ($this->workSession) {
            $this->workSessionBreak = WorkSessionBreaks::where('work_session_id', $this->workSession->id)
                ->whereNull('ended_at')
                ->first();
        }
    }

    public function checkIn(): void
    {

        $this->workSession = WorkSession::create([
            'user_id' => auth()->user()->id,
            'check_in_time' => now(),
            'last_check_at' => now(),
            'status' => 'active',
        ]);

        $this->workSession->refresh();

        $this->dispatch('refreshActiveSessions');

        // Log the activity
        log_activity(auth()->user()->name . ' has started a work session at ' . now()->format('H:i:s'));
    }

    public function checkOut(): void
    {
        $this->openWorkSessionSummaryModal();
    }

    public function pause(): void
    {
        if ($this->workSession && $this->workSession->status === 'active') {

            $this->workSessionBreak = $this->service->pauseSession($this->workSession);

            $this->dispatch('refreshActiveSessions');
            // Log the activity
            log_activity(auth()->user()->name . ' has paused the work session at ' . now()->format('H:i:s'));
        }
    }

    public function resume(): void
    {
        if ($this->workSession && $this->workSession->status === 'paused') {

            $this->workSession->update(['status' => 'active', 'notification_confirmed' => true]);

            $this->workSessionBreak->update([
                'ended_at' => now(),
            ]);

            $this->workSession->refresh();

            $this->workSessionBreak = null;

            $this->dispatch('refreshActiveSessions');

            // Log the activity
            log_activity(auth()->user()->name . ' has resumed the work session at '. now()->format('H:i:s'));
        }
    }

    public function openWorkSessionSummaryModal (): void
    {

        $this->dispatch('openWorkSessionSummaryModal', workSessionId: $this->workSession->id);
    }

    public function endWorkSession(): void
    {
        $this->workSession = null;
        $this->workSessionBreak = null;
        $this->dispatch('refreshActiveSessions');
    }


    public function render(): Factory|View
    {
        return view('livewire.team.work-session-controllers');
    }
}
