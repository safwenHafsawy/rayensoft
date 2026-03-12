<?php

namespace App\Livewire\ClientManagement;

use App\Models\LeadActivity;
use App\Models\Leads;
use Livewire\Component;

class LeadActivityForm extends Component
{

    public Leads $lead;

    public string $activityType;
    public string $activityDescription;
    public ?string $newStatus = null;

    public array $leadStatuses = [
        'New',
        'Call Back',
        'Call Back Requested',
        'Inquiry',
        'Processing',
        'Proposition Sent',
        'Not Interested',
        'Won',
        'Junk'
    ];

    public function mount($lead)
    {
        $this->lead = $lead;
    }

    public function submit()
    {
        $this->validate();

        LeadActivity::create([
            'lead_id' => $this->lead->id,
            'user_id' => auth()->user()->id,
            'type' => $this->activityType,
            'description' => $this->activityDescription,
        ]);

        // if needed updated the status
        if ($this->newStatus) {
            $this->lead->update([
                'status' => $this->newStatus,
            ]);
        }

        // reset the form
        $this->reset(['activityType', 'activityDescription', 'newStatus']);


        // update the activity list
        $this->dispatch('activityUpdated');


        log_activity(auth()->user()->name . ' updated lead ' . $this->lead->name);

        $this->dispatch('lb-stop', key: 'saveForm');
    }

    public function rules()
    {
        return [
            'activityType' => 'required',
            'activityDescription' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'activityType.required' => 'Please select an activity type.',
            'activityDescription.required' => 'Please describe the activity.',
        ];
    }

    public function updated()
    {
        $this->dispatch('lb-stop', key: 'saveForm');


    }

    public function render()
    {
        return view('livewire.client-management.lead-activity-form');
    }
}
