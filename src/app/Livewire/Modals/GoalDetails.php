<?php

namespace App\Livewire\Modals;

use App\Models\Goal;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GoalDetails extends Component
{
    public bool $isOpen = false;

    public $goalDetails;

    protected $listeners = ['openGoalsDetailsModal' => 'openModal'];

    public function mount () : void {
        $this->goalDetails = null;
    }

    public function openModal($goalId) : void {
        $this->goalDetails = Goal::where('id', $goalId)->first();
        $this->isOpen = true;
    }

    public function closeModal () : void {
        $this->isOpen = false;
    }


    public function render(): Factory|View
    {
        return view('livewire.modals.goal-details');
    }
}
