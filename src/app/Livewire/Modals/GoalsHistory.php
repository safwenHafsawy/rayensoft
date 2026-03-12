<?php

namespace App\Livewire\Modals;


use App\Models\Goal;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GoalsHistory extends Component
{
    public $pastGoals;
    public $users;
    public $filteredGoals;
    public $goals;
    public bool $isOpen = false;
    public array $filters = [
        'date' => ['start' => '', 'end' => ''],
        'user' => '',
        'status' => ''
    ];
    public string $activeDateFilter = '-1'; // for design purpose

    protected $listeners = ['openGoalsHistoryModal' => 'openModal'];


    public function setStatusColor($status): string
    {
        return match ($status) {
            'Achieved' => ' bg-green-500 text-green-100',
            'In Progress' => 'bg-blue-300 text-blue-900',
            'Pending' => 'bg-yellow-400 text-yellow-900',
            'Failed' => 'bg-red-400',
            default => 'text-gray-500',
        };
    }


    public function applyFilters () : void {

        $filteredGoals = $this->pastGoals;


        if ($this->filters['date']['start'] && $this->filters['date']['end']) {
            $start = $this->filters['date']['start'];
            $end   = $this->filters['date']['end'];

            $filteredGoals = $filteredGoals->filter(function ($goal) use ($start, $end) {
                return $goal['start_date'] >= $start && $goal['end_date'] <= $end;
            });
        }

        if ($this->filters['user']) {
            $filteredGoals = $filteredGoals->filter(fn($goal) => $goal['user_id'] == $this->filters['user']);
        }

        if ($this->filters['status']) {
            $filteredGoals = $filteredGoals->filter(fn($goal) => $goal['status'] == $this->filters['status']);
        }

        $this->goals = $filteredGoals;
    }

    public function mount() : void {
        $this->goals = collect();
        $this->users = collect();

        // Set default date filter to last week
        $this->filters['date']['start'] = Carbon::now()->startOfWeek()->addWeeks(-1)->format('Y-m-d');
        $this->filters['date']['end']   = Carbon::now()->endOfWeek()->addWeeks(-1)->format('Y-m-d');

        // Set default user filter to current user
        $this->filters['user'] = auth()->user()->id;

    }

    public function openModal ($pastGoals, $users): void
    {
        $this->pastGoals = collect($pastGoals); // Convert array to Collection
        $this->users = $users;
        $this->applyFilters();
        $this->isOpen = true;
    }

    public function closeModal (): void
    {
        $this->isOpen = false;
    }

    public function filterByDate ($filter) : void {
        $this->activeDateFilter = $filter;
        $range = ['start' => '', 'end' => ''];
        switch ($filter) {
            case 'this_month' :
                $range['start'] = Carbon::now()->startOfMonth()->format('Y-m-d');
                $range['end'] = Carbon::now()->endOfMonth()->format('Y-m-d');
                break;
            case 'prev_month' :
                $range['start'] = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
                $range['end'] = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
                break;
            case '3_month' :
                $range['start'] = Carbon::now()->subMonths(2)->startOfMonth()->format('Y-m-d');
                $range['end'] = Carbon::now()->endOfMonth()->format('Y-m-d');
                break;
            default :
                $range['start'] = Carbon::now()->startOfWeek()->addWeeks((int)$filter)->format('Y-m-d');
                $range['end'] = Carbon::now()->endOfWeek()->addWeeks((int)$filter)->format('Y-m-d');
        }

        $this->filters['date'] = $range;

        $this->applyFilters();
    }

    public function updatedFilters(): void
    {
        $this->applyFilters();
    }

    public function showDetails ($goalId) : void {
        $this->dispatch('openGoalsDetailsModal', goalId : $goalId);
    }

    public function recreatedGoal($goalId) : void
    {
        $goal = Goal::find($goalId);


        // Get the next Monday
        $new_start_date = Carbon::now()->next(Carbon::MONDAY);

        // Calculate duration in days from original goal
        $duration = Carbon::parse($goal->start_date)
            ->diffInDays(Carbon::parse($goal->end_date));

        // Calculate new end date based on next Monday + duration
        $new_end_date = $new_start_date->copy()->addDays($duration);

        $goal->start_date = $new_start_date;
        $goal->end_date = $new_end_date;
        $goal->status = 'Pending';
        $goal->save();
    }


    public function render(): Factory|View
    {
        return view('livewire.modals.goals-history');
    }
}
