<?php

namespace App\Livewire\Finances;

use App\Models\BankBalance;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\On;

class BankBalanceDetails extends Component
{
    public $bankBalance;
    
    public function mount() : void
    {
        $this->getBankBalance();
    }

    #[On('updated-bank-balance')]
    public function getBankBalance() : void 
    {
        $this->bankBalance = BankBalance::latest()->first();
    }
    public function render(): Factory|View
    {
        return view('livewire.finances.bank-balance-details');
    }
}
