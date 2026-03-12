<?php

namespace App\Livewire\Team;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class FailedGoalsChart extends Component
{
    public array $failedGoalsChart = [];

    public function loadFailedGoals () : array {
        $users = User::withCount([
            'goals as failed_goals_count' => function ($query) {
                $query->where('status', 'failed');
            }
        ])->get();

        return [
            'labels' => $users->pluck('name')->toArray(),
            'data' => $users->pluck('failed_goals_count')->toArray(),
        ];
    }

    public function mount () : void {
        $this->failedGoalsChart = $this->loadFailedGoals();
    }

    public function render(): Factory|View
    {
        return view('livewire.team.failed-goals-chart');
    }
}
