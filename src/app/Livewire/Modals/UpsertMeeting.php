<?php

namespace App\Livewire\Modals;

use App\Models\ExternalMeeting;
use App\Models\Leads;
use App\Models\Meeting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UpsertMeeting extends Component
{
    public bool $isOpen = false;

    public array $leads = [];
    public string $meetingId = '';
    public string $isEditing = '';
    public array $meetingData = [
        'title' => '',
        'date'=>'',
        'hour'=>'',
        'status'=>'',
        'link'=>'',
        'lead_id' => '',
        'notes'=>''
    ];

    protected $listeners = ['openUpsertMeetingModal' => 'openModal'];

    public array $statuses = ['pending', 'confirmed', 'cancelled', 'concluded'];

    public function mount() {
        $leads = Leads::all();
        foreach ($leads as $lead) {
            $this->leads[$lead->id] = $lead->name;
        }
    }

    public function openModal($meetingId = null, $date = null): void {

        if($meetingId){
            $this->meetingId = $meetingId;

            $meeting = ExternalMeeting::where('id', $meetingId)->first();

            $this->meetingData['title'] = $meeting->title;
            $this->meetingData['date'] = $date ?? $meeting->date;
            $this->meetingData['hour'] = $meeting->hour;
            $this->meetingData['status'] = $meeting->status;
            $this->meetingData['link'] = $meeting->link;
            $this->meetingData['lead_id'] = $meeting->lead_id;
            $this->meetingData['notes'] = $meeting->notes;

            $this->isEditing = true;
        }

        if($date) $this->meetingData['date'] = $date;

        $this->isOpen = true;
    }

    public function closeModal(): void {
        $this->meetingData = [
            'title' => '',
            'date'=>'',
            'hour'=>'',
            'status'=>'',
            'link'=>'',
            'notes'=>'',
            'lead_id' => '',
        ];
        $this->resetErrorBag();
        $this->resetValidation();
        $this->isEditing = false;
        $this->meetingId = '';
        $this->isOpen = false;


    }

    protected array $rules = [
        'meetingData.title' => 'required',
        'meetingData.date' => 'required',
        'meetingData.hour' => 'required',
        'meetingData.status' => 'required',
    ];

    protected array $messages = [
        'meetingData.title.required' => 'The title field is required.',
        'meetingData.date.required' => 'The date field is required.',
        'meetingData.hour.required' => 'The hour field is required.',
        'meetingData.status.required' => 'The status field is required.',
    ];

    public function submit(): void
    {

        $this->validate();

        try {
            if($this->isEditing){
                ExternalMeeting::where('id', $this->meetingId)->update([
                    'title' => $this->meetingData['title'],
                    'date' => $this->meetingData['date'],
                    'hour' => $this->meetingData['hour'],
                    'status' => $this->meetingData['status'],
                    'link' => $this->meetingData['link'],
                    'lead_id' => $this->meetingData['lead_id'],
                    'notes' => $this->meetingData['notes'],
                ]);
            }else {
                ExternalMeeting::create([
                    'title' => $this->meetingData['title'],
                    'date' => $this->meetingData['date'],
                    'hour' => $this->meetingData['hour'],
                    'status' => $this->meetingData['status'],
                    'link' => $this->meetingData['link'],
                    'lead_id' => $this->meetingData['lead_id'],
                    'notes' => $this->meetingData['notes'],
                ]);
            }

            $this->dispatch('refreshMeetingsTable');
            $this->closeModal();
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }
    }

    public function render(): Factory|View
    {
        return view('livewire.modals.upsert-meeting');
    }
}
