<?php

namespace App\Livewire\Modals;

use App\Models\Goal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UpsertGoal extends Component
{

    // Indicates whether the modal is open or closed
    public bool $isOpen = false;

    public bool $isEditing = false;
    public string $goalId = '';
    public $users;
    public array $listOfDates = [];

    public array $statuses = ['Pending', 'In Progress', 'Achieved', 'Failed'];

    public array $areas = ['Technical & Creative Work', 'Marketing & Branding', 'Client Acquisition & Delivery', 'Executive & Administrative', 'Strategy & Growth'];


    // Form data structure for project creation
    public array $goalData = [
        'title' => '',
        'start_date' => '',
        'duration' => '',
        'description' => '',
        'status' => 'Pending',
        'area' => '',
        'user_id' => ''
    ];

    // Event listeners for opening and closing the modal
    protected $listeners = [
        'openCreateGoalModal' => 'openModal',
        'closeModal' => 'closeModal'
    ];

    // Validation rules for the form data
    protected function rules(): array
    {
        return [
            'goalData.title' => 'required',
            'goalData.description' => 'required',
            'goalData.start_date' => 'required',
            'goalData.duration' => 'required',
            'goalData.status' => ['required', Rule::in($this->statuses)],
            'goalData.user_id' => 'required',
            'goalData.area' =>   ['required', Rule::in($this->areas)]
        ];
    }

    protected function messages(): array
    {
        $statusOptions = implode(', ', $this->statuses);
        $areaOptions = implode(', ', $this->areas);

        return [
            'goalData.title.required' => 'The goal title is required.',
            'goalData.description.required' => 'Please provide a goal description.',
            'goalData.start_date.required' => 'A start date is required.',
            'goalData.duration.required' => 'A duration is required',
            'goalData.status.required' => 'Please select a status.',
            'goalData.status.in' => "Invalid status. Please choose from: $statusOptions",
            'goalData.user_id.required' => 'Please assign this goal to a member.',
            'goalData.area.required' => 'Please select an area for this goal.',
            'goalData.area.in' => "Invalid area. Please choose from: $areaOptions",
        ];
    }

    // Opens the modal and populates the client's list
    public function openModal($goalId): void
    {
        $this->listOfDates = $this->generateListOfDates();
        //fetching users data
        $usersAll = User::all();

        foreach ($usersAll as $user) {
            $this->users[$user->id] = $user->name;
        }

        if($goalId){
            $this->isEditing = true;
            $this->goalId = $goalId;
            $currentGoalData = Goal::where('id',$goalId)->first();

            $this->date_range_to_duration($currentGoalData->start_date, $currentGoalData->end_date);
            $this->goalData = [
                'title' => $currentGoalData->title,
                'start_date' => $this->date_range_to_duration($currentGoalData->start_date, $currentGoalData->end_date)[0],
                'duration' => $this->date_range_to_duration($currentGoalData->start_date, $currentGoalData->end_date)[1],
                'description' => $currentGoalData->description,
                'status' => $currentGoalData->status ?? 'Pending',
                'area' => $currentGoalData->area,
                'user_id' => $currentGoalData->user_id
            ];
        }

        $this->isOpen = true;
    }

    // Closes the modal and resets the form data
    public function closeModal(): void
    {
        $this->resetData();
        $this->isOpen = false;
    }

    // Validates the form data, creates a new project, and closes the modal
    public function submit() : void
    {
        // Validate the data
        $this->validate();

        try {
            $goal = [];
            if($this->goalId){
                $goal = Goal::find($this->goalId);
                $goal->update([
                    'title' => $this->goalData['title'],
                    'start_date' => $this->duration_to_date_range($this->goalData['start_date'], $this->goalData['duration'])[0],
                    'end_date' => $this->duration_to_date_range($this->goalData['start_date'], $this->goalData['duration'])[1],
                    'description' => $this->goalData['description'],
                    'status' => $this->goalData['status'],
                    'area' => $this->goalData['area'],
                    'user_id' => $this->goalData['user_id'],
                ]);

                // Log the activity
                log_activity("Goal '{$goal->title}' has been updated by " . auth()->user()->name);
            }else {
                $goal = Goal::create([
                    'title' => $this->goalData['title'],
                    'start_date' => $this->duration_to_date_range($this->goalData['start_date'], $this->goalData['duration'])[0],
                    'end_date' => $this->duration_to_date_range($this->goalData['start_date'], $this->goalData['duration'])[1],
                    'description' => $this->goalData['description'],
                    'status' => 'Pending',
                    'area' => $this->goalData['area'],
                    'user_id' => $this->goalData['user_id'],
                ]);

                // Log the activity
                log_activity("New goal '{$goal->title}' has been created by " . auth()->user()->name);
            }

            $this->dispatch('refreshGoalTable', $goal);
            $this->closeModal();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function resetData(): void
    {
        $this->goalData = [
            'title' => '',
            'start_date' => '',
            'duration' => '',
            'description' => '',
            'status' => 'Pending',
            'user_id' => '',
            'area' => ''
        ];
        $this->isEditing = false;
        $this->goalId = '';
    }

    public function generateListOfDates() : array {
        $start = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $list = [];

        for($i=0; $i<8; $i++) {
            $list[] = $start->copy()->addWeeks($i)->format('d-M');
        }

        return $list;
    }

    public function duration_to_date_range($start_date, $duration): array
    {
        // Parse the date string into a Carbon instance
        $start = Carbon::createFromFormat('d-M', $start_date)->startOfDay();

        // Clone start to avoid mutating it
        $end = (clone $start)
            ->addWeeks($duration - 1)
            ->endOfWeek();

        return [
            $start->format('Y-m-d'),
            $end->format('Y-m-d'),
        ];
    }

    public function date_range_to_duration ($start_date, $end_date) : array {
        $currentStartDate = Carbon::parse($start_date);
        $currentEndDate = Carbon::parse($end_date);
        $duration = round($currentStartDate->diffInDays($currentEndDate) / 7);

        return[$currentStartDate->format('d-M'), $duration ];
    }

    public function getUsername ($user_id) : string {
        return collect($this->users)->firstWhere('id', $this->goalData['user_id'])['name'] ?? 'Unknown';
    }


    public function render(): Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.modals.upsert-goal');
    }
}
