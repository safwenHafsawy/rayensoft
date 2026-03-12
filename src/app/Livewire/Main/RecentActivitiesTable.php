<?php

namespace App\Livewire\Main;

use App\Models\RecentActivities;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RecentActivitiesTable extends Component
{
    public $activities;

    public function refresh(): void
    {
        $this->activities = RecentActivities::orderBy('created_at', 'desc')->take(10)->get();
    }

    public function mount(): void
    {
        $this->activities = RecentActivities::orderBy('created_at', 'desc')->take(10)->get();
    }


    public function render(): Factory|View
    {
        return view('livewire.main.recent-activities-table');
    }
}
