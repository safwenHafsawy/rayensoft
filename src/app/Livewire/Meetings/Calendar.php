<?php

namespace App\Livewire\Meetings;

use App\Models\ExternalMeeting;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Calendar extends Component
{
    public $currentYear;
    public $currentMonth;
    public array $chosenMonth = [
        'name' => '',
        'number' => 0,
    ];
    public array $daysInMonth = [];
    public int $blankDays = 0;
    public array $events = [];

    protected $listeners = [
        'meetingScheduled' => 'prepareCalendar',
    ];

    public function mount(): void
    {
        $now = now();
        $this->currentYear = $now->year;
        $this->currentMonth = $now->format('F');
        $this->chosenMonth = [
            'name' => $now->format('F'),
            'number' => $now->month,
        ];
        $this->prepareCalendar();
    }

    public function prepareCalendar(): void
    {
        // Calculate blank days for alignment
        $firstDayOfMonth = Carbon::create($this->currentYear, $this->chosenMonth['number'], 1);
        $this->blankDays = $firstDayOfMonth->dayOfWeek; // 0 (Sun) - 6 (Sat)

        // Prepare days in month
        $daysInMonthCount = $firstDayOfMonth->daysInMonth;
        $this->daysInMonth = [];
        for ($day = 1; $day <= $daysInMonthCount; $day++) {
            $date = Carbon::create($this->currentYear, $this->chosenMonth['number'], $day);
            $isPast = $date->isPast();
            $this->daysInMonth[] = [
                'number' => $day,
                'date' => $date->format('Y-m-d'),
                'day_name' => $date->format('D'),
                'class' => $isPast
                    ? 'text-gray-400 cursor-not-allowed'
                    : 'text-gray-600 bg-primaryColor-light text-white p-4 cursor-pointer hover:bg-primaryColor hover:text-white transition',
            ];
        }

        // Fetch events for this month, group by day
        $monthStart = $firstDayOfMonth->copy()->startOfMonth();
        $monthEnd = $firstDayOfMonth->copy()->endOfMonth();
        $meetings = ExternalMeeting::whereBetween('date', [$monthStart, $monthEnd])->get();

        $this->events = [];
        foreach ($meetings as $meeting) {
            $day = Carbon::parse($meeting->date)->day;
            $this->events[$day][] = [
                'id' => $meeting->id,
                'title' => $meeting->title ?? 'Meeting',
                'time' => Carbon::parse($meeting->hour)->format('H:i'),
                'background_color' => $meeting->type === 'internal' ? 'bg-yellow-500' : ($meeting->type === 'external' ? 'bg-green-500' : 'bg-blue-500'),            ];
        }
    }

    public function nextMonth(): void
    {
        $next = Carbon::create($this->currentYear, $this->chosenMonth['number'], 1)->addMonth();
        $this->currentYear = $next->year;
        $this->chosenMonth = [
            'name' => $next->format('F'),
            'number' => $next->month,
        ];
        $this->prepareCalendar();
    }

    public function previousMonth(): void
    {
        $prev = Carbon::create($this->currentYear, $this->chosenMonth['number'], 1)->subMonth();
        $this->currentYear = $prev->year;
        $this->chosenMonth = [
            'name' => $prev->format('F'),
            'number' => $prev->month,
        ];
        $this->prepareCalendar();
    }

    public function openCreateMeetingModal ($date): void
    {
        $this->dispatch('openUpsertMeetingModal', date: $date);
    }

    public function openMeetingDetailsModal($meetingId): void
    {
        $this->dispatch('openUpsertMeetingModal', meetingId: $meetingId);
    }
    public function render(): Factory|View
    {
        return view('livewire.meetings.calendar');
    }
}
