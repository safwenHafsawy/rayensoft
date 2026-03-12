<?php

namespace App\Livewire\Meetings;

use App\Models\ExternalMeeting;
use App\Models\Meeting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Overview extends Component
{
    public array $monthlyMeetings = [];
    public array $weeklyMeetings = [];

    public function getMonthlyMeetingData(): array
    {
        // Fetch meetings for this and previous month in one query
        $start = now()->subMonth()->startOfMonth();
        $end = now()->endOfMonth();

        $meetings = ExternalMeeting::whereBetween('date', [$start, $end])->get();

        $thisMonth = now()->format('Y-m');
        $prevMonth = now()->subMonth()->format('Y-m');

        $this_month_data = $meetings->filter(fn($m) => $m->date === $thisMonth);
        $previous_month_data = $meetings->filter(fn($m) => $m->date === $prevMonth);

        return [
            'monthly_meetings' => $this_month_data->count(),
            'previous_month_meetings' => $previous_month_data->count(),
            'this_month_pending' => $this_month_data->where('status', 'pending')->count(),
            'previous_month_pending' => $previous_month_data->where('status', 'pending')->count(),
            'monthly_change' => calculateChange(
                $this_month_data->count(),
                $previous_month_data->count()
            ),
            'monthly_pending_change' => calculateChange(
                $this_month_data->where('status', 'pending')->count(),
                $previous_month_data->where('status', 'pending')->count()
            )
        ];
    }

    public function getWeeklyMeetingData(): array
    {
        // Fetch meetings for this and previous week in one query
        $start = now()->subWeek()->startOfWeek();
        $end = now()->endOfWeek();

        $meetings = ExternalMeeting::whereBetween('date', [$start, $end])->get();

        $thisWeek = now()->format('Y-W');
        $prevWeek = now()->subWeek()->format('Y-W');

        $this_week_data = $meetings->filter(fn($m) => $m->date === $thisWeek);
        $previous_week_data = $meetings->filter(fn($m) => $m->date === $prevWeek);

        return [
            'weekly_meetings' => $this_week_data->count(),
            'previous_week_meetings' => $previous_week_data->count(),
            'this_week_pending' => $this_week_data->where('status', 'pending')->count(),
            'previous_week_pending' => $previous_week_data->where('status', 'pending')->count(),
            'weekly_change' => calculateChange(
                $this_week_data->count(),
                $previous_week_data->count()
            ),
            'weekly_pending_change' => calculateChange(
                $this_week_data->where('status', 'pending')->count(),
                $previous_week_data->where('status', 'pending')->count()
            )
        ];
    }

    public function mount() :void {
        $this->monthlyMeetings = $this->getMonthlyMeetingData();
        $this->weeklyMeetings = $this->getWeeklyMeetingData();
    }

    public function render(): Factory|View
    {
        return view('livewire.meetings.overview');
    }
}
