<?php

namespace App\Http\Controllers\Concerns\TelegramBot;

use App\Enums\ServiceStatus;

trait CreateTransactions
{
    public function addTransaction($activeSession, int $chatId, string $message): void
    {
        $prefix = "/transaction_";
        $responseMessage = "";
        $newStep = "";
        $data = [];
        $keyboard = [];

        if ($this->isCancel($message)) {
            $this->cancelCurrentAction($chatId);
            return;
        }

        switch ($activeSession->step) {
            case 'idle':
                $newStep = $prefix . 'type';
                $responseMessage = 'Let\'s log a new transaction! 📝 Is this for an income or an expense?';
                $data = [];

                $keyboard = $this->transactionsKeyboard('type');
                break;

            case $prefix . 'type':
                $type = strtolower(trim($message));

                if (!in_array($type, ['income', 'expense'], true)) {
                    $newStep = $prefix . 'type';
                    $responseMessage = 'Oops! Please pick one of the options below so I know which direction the money is moving. 💸';

                    $keyboard = $this->transactionsKeyboard('type');
                    $data = [];
                    break;
                }
                $newStep = $prefix . 'amount';
                $data = ['type' => $type];

                $responseMessage = $type === 'income'
                    ? 'That’s great! ✨ How much did you receive?'
                    : 'Got it. How much was the total for this expense? 💳';

                $keyboard = ['remove_keyboard' => true];
                break;

            case $prefix . 'amount':
                $newStep = $prefix . 'category';

                if ($this->validateAmount($message)) {
                    $data = ['amount' => str_replace(',', '.', $message)];
                } else {
                    $responseMessage = "Hmm, I couldn't quite catch that. Could you enter an amount between 100 and 99,999,999 Millimes? 🧐";
                    $newStep = $prefix . 'amount';
                    $keyboard = ['remove_keyboard' => true];
                    break;
                }

                $data = ['amount' => $message];

                $isIncome = ($activeSession->data['type'] ?? null) === 'income';

                $responseMessage = $isIncome
                    ? 'That’s great! What was the source of this revenue?'
                    : 'Understood. What category does this expense fall under?';

                $keyboard = $isIncome
                    ? $this->transactionsKeyboard('income')
                    : $this->transactionsKeyboard('expense');
                break;

            case $prefix . 'category':
                $newStep = $prefix . 'method';
                $data = ['category' => $message];

                $responseMessage = 'How was this handled? (Cash, card, or transfer?)';

                $keyboard = $this->transactionsKeyboard('method');
                break;

            case $prefix . 'method':
                $newStep = $prefix . 'notes';
                $data = ['method' => $message];

                $responseMessage = 'Almost done! Any extra details you\'d like to add? (Or just say no to skip)';
                $keyboard = ['remove_keyboard' => true];
                break;

            case $prefix . 'notes':
                $notes = trim($message);
                if (strtolower($notes) === 'no') $notes = null;

                $newStep = $prefix . 'save_confirm';
                $data = ['notes' => $notes];

                $responseMessage = 'Does everything look correct? Shall I save this for you? ✅';

                $keyboard = $this->yesOrNoKeyboard();
                break;

            case $prefix . 'save_confirm':
                $answer = strtolower(trim($message));

                if ($answer === 'no') {
                    $this->cancelCurrentAction($chatId);
                    return;
                }

                $newStep = $prefix . 'save';
                $data = [];

                $type = $activeSession->data['type'] ?? 'transaction';
                $responseMessage = $type === 'income'
                    ? 'All set! Your income has been logged. 💰'
                    : 'Done! I\'ve recorded that expense for you. 📉';

                break;

            case $prefix . 'save':
                $newStep = 'idle';
                $data = [];
                $responseMessage = 'We\'re all caught up! 🌟 What can I help you with next?';
                break;
        }

        $result = $this->telegramBotService->updateSessionData($chatId, $newStep, $data);

        if ($result['status'] === ServiceStatus::SUCCESS) {
            if ($newStep === $prefix . 'save') $this->telegramBotService->clearSession($chatId);
            $this->sendMessage($chatId, $responseMessage, $keyboard);
        } else {
            $this->sendMessage($chatId, 'I\'ve encountered an error when processing your input! Please try again.', []);
        }
    }

    private function validateAmount($amount): bool
    {
        $normalized = str_replace(',', '.', $amount);
        return is_numeric($normalized) && (float)$normalized > 0 && preg_match('/^\d{3,8}$/', $normalized);
    }

    private function transactionsKeyboard($step)
    {
        $keyboard = match ($step) {
            'type' => [
                [['text' => 'Income'], ['text' => 'Expense']],
                [['text' => 'Cancel']],
            ],
            'income' => [
                [['text' => 'Web Development'], ['text' => 'Media Buyer']],
                [['text' => 'Small Gig'], ['text' => 'Cash Injection']],
                [['text' => 'Cancel']],
            ],
            'expense' => [
                [['text' => 'Rent'], ['text' => 'Fourniture']],
                [['text' => 'Software Subscription'], ['text' => 'Marketing']],
                [['text' => 'Tax'], ['text' => 'Phone Bill']],
                [['text' => 'Other'], ['text' => 'Cancel']],
            ],
            'method' => [
                [['text' => 'Cash'], ['text' => 'D17'], ['text' => 'Deposit']],
                [['text' => 'Transfer'], ['text' => 'CTI']],
                [['text' => 'Cancel']],
            ],
            'save_confirm' => [
                [['text' => 'Yes'], ['text' => 'No']],
            ],
            default => null,
        };

        return [
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ];
    }
}
