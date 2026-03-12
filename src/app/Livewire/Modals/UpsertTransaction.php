<?php

namespace App\Livewire\Modals;

use App\Enums\ServiceStatus;
use App\Enums\TransactionTypes;
use App\Services\TransactionsServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class UpsertTransaction extends Component
{

    protected TransactionsServices $transactions_services;

    public bool $isEditing = false;
    public bool $isOpen = false;

    public string $transactionId = '';

    protected $listeners = ['openTransactionUpsertModal' => 'openModal'];

    public array $types = [];
    public array $incomeCategory = [
        'Income : Website Development',
        'Income : Media Buyer',
        'Income : Small Gig',
        'Income : Cash Injection',
    ];

    public array $expenseCategory = [
        'Rent',
        'Furniture',
        'Software',
        'Marketing',
        'Tax',
        'Phone'
    ];

    public array $methods = [
        'cash',
        'd17',
        'transfer'
    ];

    public array $transactionData = [
        'amount' => '',
        'date' => '',
        'type' => '',
        'category' => '',
        'method' => '',
        'notes' => '',
    ];

    protected array $rules = [
        'transactionData.amount' => 'required',
        'transactionData.date' => 'required|before_or_equal:today',
        'transactionData.category' => 'required',
        'transactionData.type' => 'required',
        'transactionData.method' => 'required|in:cash,d17,transfer'
    ];

    public array $messages = [
        'transactionData.amount.required' => 'Please enter the transaction amount.',
        'transactionData.date.required' => 'Please select a transaction date.',
        'transactionData.date.before_or_equal' => 'The transaction date cannot be in the future.',
        'transactionData.category.required' => 'Please choose a transaction category.',
        'transactionData.type.required' => 'Please select the transaction type.',
        'transactionData.method.required' => 'Please choose a payment method.',
        'transactionData.method.in' => 'The selected payment method is not valid.',
        'transactionData.notes.required' => 'Please add a short note explaining the transaction.',
    ];

    public function boot(
        TransactionsServices $transactions_services
    ) {
        $this->transactions_services = $transactions_services;
    }

    public function mount(): void
    {
        $this->types = [TransactionTypes::INCOME->value, TransactionTypes::EXPENSE->value];
    }

    public function submit(): void
    {
        $this->validate();

        $return = $this->transactions_services->registerTransaction($this->transactionData);

        if ($return['status'] === ServiceStatus::SUCCESS) {
            Session::flash('status', 'transaction added successfully');
            $this->dispatch('lb-stop', key: 'saveForm');
        } else {
            Session::flash('status', 'Could ot add transaction');
        }
        $this->dispatch('updated-bank-balance');
        $this->closeModal();
    }

    public function openModal(): void
    {
        $this->isOpen = true;
        $this->dispatch('lb-stop', key: 'openModal');
    }

    public function closeModal(): void
    {
        $this->isOpen = false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->transactionId = '';
        $this->transactionData = [
            'amount' => '',
            'date' => '',
            'category' => '',
            'type' => '',
            'notes' => '',
        ];
    }

    public function updated() {
        $this->dispatch('lb-stop', key: 'saveForm');
    }

    public function render(): Factory|View
    {
        return view('livewire.modals.upsert-transaction');
    }
}
