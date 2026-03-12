<?php

namespace App\Services;

use App\Enums\TransactionTypes;
use App\Enums\ServiceStatus;
use App\Models\BankBalance;
use App\Models\FinancialTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionsServices
{

    public function getFinancialSummary(): array
    {
        $expenses = 0;
        $income = 0;
        $transactionList =  FinancialTransaction::get();


        foreach ($transactionList as $transaction) {
            Log::info($transaction->type . ' ' . $transaction->amount);
            if ($transaction->type === TransactionTypes::INCOME->value) $income += (int) $transaction->amount;
            else if ($transaction->type === TransactionTypes::EXPENSE->value) $expenses += (int) $transaction->amount;
        };

        return [
            'expenses' => $expenses,
            'income' => $income
        ];
    }

    public function registerTransaction($data): array
    {
        try {
            return DB::transaction(function () use ($data) {
                // register new transaction
                Log::info($data);
                $transaction = FinancialTransaction::create([
                    'amount' => $data['amount'],
                    'date' => $data['date'],
                    'category' => $data['category'],
                    'type' => $data['type'],
                    'notes' => $data['notes'],
                ]);

                // update bank account
                $this->recordBankAccount($transaction->id, $data['type'], $data['amount']);

                return ['status' => ServiceStatus::SUCCESS, 'context' => $transaction];
            });
        } catch (\Throwable $error) {
            Log::error($error);
            return ['status' => ServiceStatus::FAILURE];
        }
    }

    private function recordBankAccount($transactionId, $type, $amount)
    {
        $prevBankBalance = BankBalance::query()
            ->latest()
            ->lockForUpdate()
            ->first();

        $prevAmount = (int) ($prevBankBalance?->amount ?? 0);
        $delta = (int) $amount;
        $newBalance = match ($type) {
            TransactionTypes::INCOME->value => $prevAmount + $delta,
            TransactionTypes::EXPENSE->value => $prevAmount - $delta,
            default => throw new \InvalidArgumentException("Unknown transaction type: {$type}"),
        };

        BankBalance::create([
            'amount' => $newBalance,
            'recorded_at' => now(),
            'notes' => 'recorded after transaction #' . $transactionId
        ]);
    }

    public function getCurrentBankBalance(): int
    {
        return (int) (BankBalance::query()->latest()->first()?->amount ?? 0);
    }
}
