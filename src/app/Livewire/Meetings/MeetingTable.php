<?php

namespace App\Livewire\Meetings;

use App\Models\ExternalMeeting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class MeetingTable extends Component
{

    public $meetings;

    protected  $listeners = ['refreshMeetingsTable' => '$refresh'];

    public function getStatusColor($status): string {
        return match ($status) {
            'concluded' => 'text-green-700 bg-green-300',
            'pending' => 'text-yellow-900 bg-yellow-500',
            'confirmed' => 'text-blue-600 bg-blue-100',
            'cancelled' => 'text-red-900 bg-red-300',
            default => 'text-gray-500',
        };
    }

    public function getMeetingTypeColor ($meetingType): string
    {
        // Define colors for different meeting types
        $colors = [
            'internal' => 'bg-yellow-500',
            'external' => 'bg-green-500',
            'discovery' => 'bg-blue-500',
        ];

        return $colors[$meetingType] ?? 'bg-gray-500'; // Default color if type not found
    }

    public function getMeetingsData(): Collection
    {
        // Fetch meetings for the current month and week in one query
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        return ExternalMeeting::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orWhereBetween('date', [$startOfWeek, $endOfWeek])
            ->With('lead')
            ->get();
    }

    public function mount(): void
    {
        $this->meetings = $this->getMeetingsData();
    }

    public function openUpsertMeeting($meetingId): void
    {
        // Emit an event to open the meeting modal with the selected meeting ID
            $this->dispatch('openUpsertMeetingModal', $meetingId);
    }

    public function render(): Factory|View
    {
        return view('livewire.meetings.meeting-table');
    }
}
