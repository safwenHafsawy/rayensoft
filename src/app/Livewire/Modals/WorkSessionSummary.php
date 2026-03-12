<?php

namespace App\Livewire\Modals;

use App\Models\Goal;
use App\Models\WorkSession;
use App\Models\WorkSessionBreaks;
use App\Services\WorkSessionService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class WorkSessionSummary extends Component
{
    public $workSession;

    public bool $isWorkSessionSummaryOpen = false;
    public $totalWorkedTime;
    public $workSessionBreak;
    protected ?WorkSessionService $service;

    public $userGoals;

    protected $listeners = ['openWorkSessionSummaryModal' => 'openModal'];

    public array $summaryData = [
        'goalsWorkedOn' => [],
        'summary' => '',
    ];

    public function boot(WorkSessionService $service): void
    {
        $this->service = $service;
    }

    public function mount() : void
    {
        $this->userGoals = Goal::where('user_id', auth()->user()->id)
            ->where(function($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'in progress');
            })
            ->get();
    }

    public function openModal($workSessionId) : void {
        // getting the data

        $this->workSession = WorkSession::where('id', $workSessionId)->first();
        $this->totalWorkedTime = $this->calculateWorkingTime();

        $this->isWorkSessionSummaryOpen = true;
    }

    public function closeModal(): void
    {
        $this->reset('summaryData');
        $this->workSession = null;
        $this->workSessionBreak = null;
        $this->isWorkSessionSummaryOpen = false;
    }

    protected array $rules = [
        'summaryData.goalsWorkedOn' => 'required|array|min:1',
        'summaryData.summary' => 'required|max:1000|min:30',
    ];

    protected array $messages = [
        'summaryData.goalsWorkedOn.required' => 'Please select at least one goal you worked on.',
        'summaryData.goalsWorkedOn.min' => 'Please select at least one goal you worked on.',
        'summaryData.summary.required' => 'Please provide a summary of your work session.',
        'summaryData.summary.max' => 'The summary is too long.',
        'summaryData.summary.min' => 'Your summary is too short.',
    ];

    public function saveSummary(): void
    {

        $this->validate();

        try {
            [$this->workSession, $this->workSessionBreak] = $this->service->sessionCheckOut($this->workSession,  $this->workSessionBreak, $this->summaryData, $this->totalWorkedTime);

            $this->dispatch('workSessionEnded');

        } catch (\Exception $e) {
            Log::error('Error saving work session summary: ' . $e->getMessage());
        }finally {
            $this->closeModal();
        }
    }

    public function calculateWorkingTime (): float|int
    {
        // Calculate total worked time excluding breaks
        Log::info('-----------------------------------------------');
        $start = $this->workSession->check_in_time;
        $end = now();
        // Log::info('Start: ' . $start);
        // Log::info('End: ' . $end);
        $totalBreaksDuration = 0;
        $breaks = WorkSessionBreaks::where('work_session_id', $this->workSession->id)->get();
        Log::info($breaks);
        if($breaks->isEmpty()) return abs($end->diffInMinutes($start));

        foreach($breaks as $break) {
            // Log::info('-----------------------------------------------');
            // Log::info('Break ID: ' . $break->id);
            // Log::info('Break started at: ' . $break->started_at);
            // Log::info('Break ended at: ' . $break->ended_at);
            // Log::info('Break duration: ' . abs(Carbon::parse($break->started_at)->diffInMinutes(Carbon::parse($break->ended_at))));
            if(!$break->ended_at) $break->ended_at = now(); // Skip ongoing breaks
            $totalBreaksDuration += abs(Carbon::parse($break->started_at)->diffInMinutes(Carbon::parse($break->ended_at)));
            // Log::info('-----------------------------------------------');
            // Log::info('Total breaks duration: ' . $totalBreaksDuration);
        }

        Log::info('Total breaks duration: ' . $totalBreaksDuration);
        Log::info('Total worked time: ' . abs($end->diffInMinutes($start)));
        return abs($end->diffInMinutes($start)) - $totalBreaksDuration;
    }

    public function render(): Factory|View
    {
        return view('livewire.modals.work-session-summary');
    }
}
