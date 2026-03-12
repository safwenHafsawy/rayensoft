<?php

namespace App\Livewire\Team;

use App\Models\User;
use Livewire\Component;

class AchievedGoalsChart extends Component
{

    public array $achievedGoalsChart = [];
    public $leaderboard; // holds leaderboard data

    /**
     * Load raw goals data for chart usage
     */
    public function loadGoals() : array
    {
        $users = User::withCount([
            'goals as achieved_goals_count' => function ($query) {
                $query->where('status', 'Achieved');
            }
        ])->get();

        return [
            'labels' => $users->pluck('name')->toArray(),
            'data'   => $users->pluck('achieved_goals_count')->toArray(),
        ];
    }

    /**
     * Prepare leaderboard data (sorted by goals desc)
     */
    public function loadLeaderboard()
    {
        return collect($this->achievedGoalsChart['labels'])
            ->zip($this->achievedGoalsChart['data']) // pair [name, goals]
            ->sortByDesc(fn($item) => $item[1])      // sort by goals desc
            ->values();                              // reset keys
    }

    public function mount() : void
    {
        $this->achievedGoalsChart = $this->loadGoals();
        $this->leaderboard = $this->loadLeaderboard();
    }



    public function render()
    {
        return view('livewire.team.achieved-goals-chart');
    }
}
