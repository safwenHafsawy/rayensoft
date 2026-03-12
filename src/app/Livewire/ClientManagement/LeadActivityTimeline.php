<?php

namespace App\Livewire\ClientManagement;

use App\Models\Leads;
use Livewire\Component;
use Livewire\Attributes\On;

class LeadActivityTimeline extends Component
{

    public Leads $lead;
    public array $activities = [];

    public function mount($lead) : void
    {
        $this->lead = $lead;
        $this->fetchLeadActivities();
        
    }

    #[On('activityUpdated')]
    public function fetchLeadActivities() : void
    {
        $this->activities = $this->lead->activities()->latest()->get()->toArray();
    }

    public function render()
    {
        return view('livewire.client-management.lead-activity-timeline');
    }
}
