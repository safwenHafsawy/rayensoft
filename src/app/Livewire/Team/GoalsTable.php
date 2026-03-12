<?php

namespace App\Livewire\Team;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GoalsTable extends Component
{
    protected $listeners = ['refreshGoalTable' => '$refresh'];

    public object $currentGoals;
    public object $pastGoals;
    public object $goals;

    public $users;

    public array $filters = [
        'user' => '',
        'status' => '',
        'area' => '',
    ];
    public array $areas = ['Technical & Creative Work', 'Marketing & Branding', 'Client Acquisition & Delivery', 'Executive & Administrative', 'Strategy & Growth'];

    public array $statuses = ['Pending', 'In Progress', 'Achieved', 'Failed'];

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

    public function updatedFilters(): void
    {
        $this->applyFilters();
    }

    public function applyFilters () : void {

        $filteredGoals = $this->currentGoals;

        if ($this->filters['user']) {
            $filteredGoals = $filteredGoals->filter(fn($goal) => $goal->user_id == $this->filters['user']);
        }

        if ($this->filters['status']) {
            $filteredGoals = $filteredGoals->filter(fn($goal) => $goal->status == $this->filters['status']);
        }

        if ($this->filters['area']) {
            $filteredGoals = $filteredGoals->filter(fn($goal) => $goal->area == $this->filters['area']);
        }

        $this->goals  = $filteredGoals;
    }

    public function mount(): void
    {
        $usersAll = User::all();

        foreach ($usersAll as $user) {
            $this->users[$user->id] = $user->name;
        }

        // Single query to get all goals at once
        $allGoals = Goal::all();

        $this->currentGoals = $allGoals->filter(fn($goal) => $goal->end_date >= now()->format('Y-m-d'));
        $this->pastGoals = $allGoals->filter(fn($goal) => $goal->end_date < now()->format('Y-m-d'));

        $this->filters['user'] = Auth()->user()->id;

        $this->applyFilters();
    }

    public function refreshGoalsTable ($goal) : void
    {

        // find the goal in the goals collection
        $existingGoal = $this->goals->firstWhere('id', $goal['id']);
        // replace the goal with the updated goal
        if($existingGoal){
            $this->goals = $this->goals->map(fn($g) => $g->id == $goal['id'] ? (object)$goal : $g);
        }else {
            // add the new goal to the goals collection
            $this->goals->push((object)$goal);
        }
    }

    public function openGoalsHistoryModal (): void
    {
        $this->dispatch('openGoalsHistoryModal', pastGoals : $this->pastGoals, users: $this->users);
    }

    public function openCreateGoalModal($goalId = null): void
    {
        $this->dispatch('openCreateGoalModal', goalId : $goalId);
    }

    public function showDetails ($goalId) : void {
        $this->dispatch('openGoalsDetailsModal', goalId : $goalId);
    }

    public function render(): Factory|View
    {
        return view('livewire.team.goals-table');
    }
}
