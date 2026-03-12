<?php

namespace App\Services;

use App\Enums\ServiceStatus;
use App\Models\TelegramBotSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TelegramBotService
{

    private TransactionsServices $transactionsServices;
    private MeetingsServices $meetingsServices;
    private LeadesService $leadesService;

    public function __construct(
        TransactionsServices $transactionsServices,
        MeetingsServices $meetingsServices,
        LeadesService $leadesService
    ) {
        $this->transactionsServices = $transactionsServices;
        $this->meetingsServices = $meetingsServices;
        $this->leadesService = $leadesService;
    }

    public function getBotSession($chatId)
    {
        return TelegramBotSession::firstOrCreate(['chat_id' => $chatId]);
    }

    public function startBotSession($chatId, $step): array
    {
        try {
            return DB::transaction(function () use ($chatId, $step) {
                $session = TelegramBotSession::create([
                    'chat_id' => $chatId,
                    'step' => $step,
                ]);

                return ['status' => ServiceStatus::SUCCESS, 'payload' => $session];
            }, 3);
        } catch (\Throwable $e) {
            Log::critical("System error: " . $e->getMessage());
            return ['status' => ServiceStatus::FAILURE];
        }
    }

    public function updateSessionData($chatId, $step, $data)
    {
        if ($step === '/transaction_save') {
            $storedData = $this->getBotSession($chatId);

            $transactionData = [
                'type' => $storedData->data['type'],
                'amount' => $storedData->data['amount'],
                'category' => $storedData->data['category'],
                'date' => now(),
                'notes' => $storedData->data['notes']
            ];
            return $this->transactionsServices->registerTransaction($transactionData);
        }

        if ($step === '/balance_check') {
            $balance = $this->transactionsServices->getCurrentBankBalance();
            return ['status' => ServiceStatus::SUCCESS, 'balance' => $balance];
        }

        if ($step === '/client_get') {
            $name = $data['name'] ?? '';
            return ['status' => ServiceStatus::SUCCESS, 'clients' => $this->leadesService->getLeadsByName($name)];
        }

        if ($step === '/meetings_get') {
            $startDate = null;
            $endDate = null;
            switch ($data['dateRange']) {
                case "today":
                    $startDate = now()->startOfDay();
                    $endDate = now()->endOfDay();
                    break;
                case "week":
                    $startDate = now()->startOfWeek();
                    $endDate = now()->endOfWeek();
                    break;
                case "next_week":
                    $startDate = now()->addWeek()->startOfWeek();
                    $endDate = now()->addWeek()->endOfWeek();
                    break;
                default:
                    return ['status' => ServiceStatus::FAILURE, 'message' => 'Invalid date range selection.'];
            }

            return ['status' => ServiceStatus::SUCCESS, 'meetings' => $this->meetingsServices->getMeetingsInDateRange($startDate, $endDate)];
        }

        try {
            return DB::transaction(function () use ($chatId, $step, $data) {
                $session = TelegramBotSession::query()
                    ->where('chat_id', $chatId)
                    ->lockForUpdate()
                    ->first();

                $session->update([
                    'step' => $step,
                    'data' => array_merge($session->data ?? [], $data)
                ]);

                return ['status' => ServiceStatus::SUCCESS, 'session' => $session];
            }, 3);
        } catch (\Throwable $e) {
            Log::critical("System error: " . $e->getMessage());
            return ['status' => ServiceStatus::FAILURE];
        }
    }

    public function clearSession($chatId): array
    {
        try {
            return DB::transaction(function () use ($chatId) {
                $session = TelegramBotSession::query()
                    ->where('chat_id', $chatId)
                    ->lockForUpdate()
                    ->first();

                $session->update([
                    'step' => 'idle',
                    'data' => null
                ]);

                return ['status' => ServiceStatus::SUCCESS, 'session' => $session];
            }, 3);
        } catch (\Throwable $e) {
            Log::critical("System error: " . $e->getMessage());
            return ['status' => ServiceStatus::FAILURE];
        }
    }
}
