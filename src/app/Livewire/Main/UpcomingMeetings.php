<?php

namespace App\Livewire\Main;

use App\Models\Meeting;
use App\Models\ExternalMeeting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UpcomingMeetings extends Component
{
    public $meetings;

    public function mount(): void
    {
        $this->meetings = ExternalMeeting::where('date', '>=', now()->format('Y-m-d'))
            ->orderBy('date', 'asc')
            ->get();
    }

    public function render(): Factory|View
    {
        return view('livewire.main.upcoming-meetings');
    }
}
