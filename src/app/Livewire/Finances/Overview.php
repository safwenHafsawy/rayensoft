<?php

namespace App\Livewire\Finances;

use App\Services\TransactionsServices;
use Livewire\Component;
use Livewire\Attributes\On;

class Overview extends Component
{

    protected TransactionsServices $transactionsServices;


    public int $totalExpense = 0;
    public int $totalIncome = 0;

    public function boot(
        TransactionsServices $transactionsServices
    ) : void
    {
        $this->transactionsServices = $transactionsServices;
    }

    public function mount(): void
    {
        $this->totalExpense = 0;
        $this->totalIncome = 0;

        $this->getTransactionsData();
    }

    #[On('updated-bank-balance')]
    public function getTransactionsData(): void {
        \Log::info('update overview_sss');
        $transactions = $this->transactionsServices->getFinancialSummary();
        \Log::info(print_r($transactions, true));
        $this->totalIncome  = $transactions['income'];
        $this->totalExpense = $transactions['expenses'];

        \Log::info($this->totalExpense);
    }
    public function render()
    {
        return view('livewire.finances.overview');
    }
}
