<?php

namespace App\Livewire\Finances;

use App\Models\FinancialTransaction;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionTable extends Component
{
    use WithPagination;


    public function getTransactionsProperty(): LengthAwarePaginator {
        return FinancialTransaction::paginate(10);
    }

    public function openTransactionUpsertModal() : void
    {
        $this->dispatch('openTransactionUpsertModal');
    }

    public function render(): View
    {
        return view('livewire.finances.transaction-table',
            ['transactions' => $this->transactions]);
    }
}
