<?php

namespace App\Http\Controllers;

use App\Enums\ServiceStatus;
use App\Services\TelegramBotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Concerns\TelegramBot\HelpMenu;
use App\Http\Controllers\Concerns\TelegramBot\WelcomeUser;
use App\Http\Controllers\Concerns\TelegramBot\CreateTransactions;
use App\Http\Controllers\Concerns\TelegramBot\ManageMeetings;

class TelegramBotController extends Controller
{
    use HelpMenu, WelcomeUser, CreateTransactions, ManageMeetings;

    public const DEFAULT_KEYBOARD = [
        'keyboard' => [
            [['text' => 'Check Balance'], ['text' => 'Add Transaction']],
            [['text' => 'Check Meetings'], ['text' => 'Check Client Data']]
        ],
        'resize_keyboard' => true, // Makes buttons smaller/cleaner
        'one_time_keyboard' => true // Hides the keyboard after they click one
    ];

    public const AVAILABLE_COMMANDS = [
        'Check Meetings' => '/meetings',
        'Add Transaction' => '/transaction',
        // 'Add Expense' => '/expense',
        'Check Client Data' => '/client',
        // 'Check Messages' => '/messages',
        'Get Balance' => '/balance'
    ];
    private TelegramBotService $telegramBotService;

    public function __construct(
        TelegramBotService $telegramBotService
    ) {
        $this->telegramBotService = $telegramBotService;
    }

    public function handle(Request $request): void
    {
        $allowedUsers = [
            1901283043,
            1014470775
        ];

        Log::info('Telegram Update:', $request->all());

        $chatId = $request->input('message.chat.id');
        $rawInput = $request->input('message.text');
        $userName = $request->input('message.from.first_name');

        // check if the user is allowed to communicate with the bot 
        if (!in_array($chatId, $allowedUsers)) {
            return;
        }

        // check if the user is already in the middle of a conversation
        $activeSession = $this->telegramBotService->getBotSession($chatId);

        // resolve user intent
        $intent = $this->resolveIntent($rawInput);

        // Global Commands 
        if (preg_match('/\/?(cancel|abort|restart|quit)/', $intent)) {
            $this->cancelCurrentAction($chatId);
            return;
        }

        // greetings 
        if ($this->isGreetingIntent($rawInput)) {
            $this->welcomeUser($chatId, $rawInput, $userName);
            return;
        }

        // introduction
        if ($this->introduceYourself($rawInput)) {
            $responseMessage = "Hello $userName! 👋 I'm Rayen Soft's assistant bot. I can help manage meetings, store transactions, and check client data. What would you like to do today?";
            $this->sendMessage($chatId, $responseMessage, SELF::DEFAULT_KEYBOARD);
            return;
        }

        // show menu if user types "menu" or "help"
        if ($this->showMenu($rawInput)) {

            $responseMessage = "Here's the menu of things I can help you with: 🍽️\n\n";

            foreach (self::AVAILABLE_COMMANDS as $label => $command) {
                $responseMessage .= "🔹 $label: $command\n";
            }
            $responseMessage .= "\nJust tap on any option to get started!";
            $this->sendMessage($chatId, $responseMessage, SELF::DEFAULT_KEYBOARD);
            return;
        }


        // switching flows mid-session : user confirmation to pivot to the new flow, while keeping the session data in case they want to switch back without losing progress
        if ($activeSession && str_contains($activeSession->step, '_switch_confirm')) {
            $this->switchFlow($chatId, $activeSession, $rawInput);
            return;
        }

        // If user has active session, continue the flow based on that, otherwise use the resolved intent
        if ($activeSession && $activeSession->step !== 'idle') {
            $currentFlow = explode('_', $activeSession->step)[0] ?? null;
            $targetFlow = explode('_', $intent)[0] ?? null;

            if ($currentFlow && $targetFlow && $currentFlow !== $targetFlow) {
                $this->sendMessage($chatId, 'I noticed we were talking about ' . $currentFlow . ', but it sounds like you\'d rather switch to ' . $targetFlow . '. Should we pivot to that?', $this->yesOrNoKeyboard());
                $this->telegramBotService->updateSessionData($chatId, $activeSession->step . '_switch_confirm', ['target_intent' => $intent]);
                return;
            } else {
                $this->handleActiveSession($activeSession, $chatId, $rawInput);
                return;
            }
        }

        // if user has no active session, start a new flow based on the resolved intent
        if ($intent) {
            $this->dispatchByIntent($intent, $activeSession, $chatId, $rawInput);
            return;
        }

        $this->sendMessage($chatId, 'I\'m sorry, I didn\'t quite understand that. Could you please choose one of the options from the menu?', SELF::DEFAULT_KEYBOARD);
    }


    private function switchFlow($chatId, $currentSession, $rawInput): void
    {
        $t = $this->normalizeText($rawInput);

        $isYes = preg_match('/^(yes|y|yup|sure|ok|sure|okay)$/i', $t);
        $isNo = preg_match('/^(no|n|nope|nah)$/i', $t);

        $targetIntent = $currentSession->data['target_intent'] ?? null;
        $previousStep = str_replace('_switch_confirm', '', $currentSession->step);

        if (!$isYes && !$isNo) {
            $this->sendMessage($chatId, 'I didn\'t quite catch that. Do you want to switch to the new topic?', $this->yesOrNoKeyboard());
            return;
        }

        if ($isYes) {

            $sessionReset = $this->telegramBotService->clearSession($chatId);

            if ($sessionReset['status'] === ServiceStatus::SUCCESS) {
                $this->sendMessage($chatId, 'Great! Pivoting to the new topic now.');
                $this->dispatchByIntent($targetIntent, $sessionReset['session'], $chatId, '');
            } else {
                $this->sendMessage($chatId, 'I ran into an issue while trying to switch topics. Please try again.');
            }
        }

        if ($isNo) {
            $this->sendMessage($chatId, 'No problem! Let\'s continue with what we were discussing.');
            $this->telegramBotService->updateSessionData($chatId, $previousStep, []);
        }
    }

    private function handleActiveSession($activeSession, $chatId, $message)
    {
        if (str_starts_with($activeSession->step, '/transaction')) {
            $this->addTransaction($activeSession, $chatId, $message);
        } else if (str_starts_with($activeSession->step, '/meetings')) {
            $this->getMeetings($activeSession, $chatId, $message);
        } else if (str_starts_with($activeSession->step, '/client')) {
            $this->getClientsData($activeSession, $chatId, $message);
        }
    }

    private function dispatchByIntent($intent, $activeSession, $chatId, $rawText)
    {
        switch ($intent) {
            case '/meetings':
                $this->getMeetings($activeSession, $chatId, $rawText);
                break;
            case '/transaction':
                $this->addTransaction($activeSession, $chatId, $rawText);
                break;
            case '/client':
                $this->getClientsData($activeSession, $chatId, $rawText);
                break;
            case '/balance':
                $this->getBalance($activeSession, $chatId);
                break;
        }
    }

    public function getBalance($activeSession, $chatId)
    {
        $responseMessage = "";
        $keyboard = [];

        if ($activeSession->step === 'idle') {
            $balance = $this->telegramBotService->updateSessionData($chatId, '/balance_check', [])['balance'] ?? 0;
            $responseMessage = "Your current bank balance is: " . number_format($balance / 1000, 2) . " TND 💰. Anything else I can help you with? ";
            $keyboard = SELF::DEFAULT_KEYBOARD;
        } else {
            $responseMessage = "I’m sorry, I got a little lost there! Let’s start over—what would you like to do?";
            $keyboard = SELF::DEFAULT_KEYBOARD;
        }

        $this->sendMessage($chatId, $responseMessage, $keyboard);
    }

    public function getClientsData($activeSession, $chatId, $rawInput)
    {
        $prefix = "/client_";
        $responseMessage = "";
        $newStep = "";
        $data = [];
        $keyboard = [];

        if ($this->isCancel($rawInput)) {
            $this->cancelCurrentAction($chatId);
            return;
        }

        switch ($activeSession->step) {
            case "idle":
                $responseMessage = "Sure! What client are you looking for? Please enter their name.";
                $newStep = $prefix . "name";
                $keyboard = ['remove_keyboard' => true];
                break;

            case $prefix . "name":
                $newStep = $prefix . "get";
                $data = ['name' => $rawInput];
                break;
        }

        $result = $this->telegramBotService->updateSessionData($chatId, $newStep, $data);

        if ($result['status'] === ServiceStatus::SUCCESS) {
            if ($newStep === $prefix . 'get') {
                if (empty($result['clients'])) {
                    $responseMessage = "I'm sorry, I couldn't find any clients matching \"{$data['name']}\". 🔍 Would you like to try a different name?";

                    $this->sendMessage($chatId, $responseMessage, $this->clientsKeyboard());
                    return;
                }
                $responseMessage = $this->renderClientDataMessage($data['name'], $result);
                $responseMessage .= "Anything else I can help you with? 😊";
                $this->telegramBotService->clearSession($chatId);

                $this->sendMessage($chatId, $responseMessage, SELF::DEFAULT_KEYBOARD);
                return;
            }
            $this->sendMessage($chatId, $responseMessage, $keyboard);
        } else {
            $this->sendMessage($chatId, 'Oops! I ran into a little trouble processing that. Could you try one more time for me?', ['remove_keyboard' => true]);
        }
    }

    private function normalizeText(string $text): string
    {
        $t = trim(mb_strtolower($text));
        return preg_replace('/\s+/', ' ', $t) ?? '';
    }

    private function isCancel(string $text): bool
    {
        $t = $this->normalizeText($text);

        $t = str_replace(['/', '\\'], '', $t);

        // typo correction
        $t = $this->correctTypos($t) ?? $t;

        // tokenize sentence
        $tokens = preg_split('/\s+/', $t) ?: [];

        $cancelKeywords = ['cancel', 'abort', 'stop', 'restart', 'quit', 'exit'];

        foreach ($tokens as $token) {
            if (in_array($token, $cancelKeywords, true)) {
                return true;
            }
        }

        return false;
    }

    private function resolveIntent(string $rawInput): ?string
    {
        $normarlisedInput = $this->normalizeText($rawInput);

        // check if the input is a key label command 
        if (array_key_exists($rawInput, SELF::AVAILABLE_COMMANDS)) {
            return SELF::AVAILABLE_COMMANDS[$rawInput];
        }

        // check if the input is a command
        if (str_starts_with($normarlisedInput, '/')) {
            return $normarlisedInput;
        }

        // keyword based intent recognition
        // tokenize the input
        $tokens = preg_split('/\s+/', $this->correctTypos($normarlisedInput)) ?? [];

        // check for keywords in the tokens

        if (in_array('meeting', $tokens, true) || in_array('meetings', $tokens, true)) {
            return '/meetings';
        }
        if (in_array('transaction', $tokens, true) || in_array('income', $tokens, true) || in_array('expense', $tokens, true)) {
            return '/transaction';
        }
        if (in_array('client', $tokens, true) || in_array('data', $tokens, true)) {
            return '/client';
        }
        if (in_array('balance', $tokens, true) || in_array('bank', $tokens, true)) {
            return '/balance';
        }
        if (in_array('quit', $tokens, true) || in_array('abort', $tokens, true) || in_array('cancel', $tokens, true) || in_array('restart', $tokens, true)) {
            return '/cancel';
        }
        if (in_array('help', $tokens, true) || in_array('menu', $tokens, true)) {
            return '/menu';
        }

        return null;
    }

    private function correctTypos(string $text): ?string
    {
        $tokens = preg_split('/\s+/', $text) ?: [];

        $dictionary = [
            'meetings',
            'meeting',
            'balance',
            'clients',
            'client',
            'transaction',
            'income',
            'expense',
            'cancel',
            'today',
            'week',
            'tomorrow',
            'next',
            'abort',
            'restart',
            'quit',
        ];

        $correctedTokens = array_map(function ($token) use ($dictionary) {
            $closest = null;
            $shortestDistance = PHP_INT_MAX;

            if (strlen($token) < 4) return $token;
            foreach ($dictionary as $word) {
                $distance = levenshtein($token, $word);

                if ($distance < $shortestDistance) {
                    $closest = $word;
                    $shortestDistance = $distance;
                }
            }

            // If the closest word is reasonably similar, correct it
            return $shortestDistance <= 2 ? $closest : $token;
        }, $tokens);

        return implode(' ', $correctedTokens);
    }

    private function cancelCurrentAction($chatId)
    {
        $this->telegramBotService->clearSession($chatId);
        $this->sendMessage($chatId, 'No problem! Let’s start fresh. ✨ How can I help you today', SELF::DEFAULT_KEYBOARD);
    }

    private function renderClientDataMessage($clientName, $result)
    {
        $responseMessage = '';
        if (count($result['clients']) > 1) {
            $count = count($result['clients']);
            $responseMessage = "I found $count matches for \"{$clientName}\". Here are the details for each:\n\n";
            foreach ($result['clients'] as $index => $clientData) {
                $responseMessage .= "👤 Client " . ($index + 1) . "\n";
                $responseMessage .= "Name: {$clientData['name']}\n";
                $responseMessage .= "Phone: {$clientData['phone']}\n";
                $responseMessage .= "Email: {$clientData['email']}\n\n";
                $responseMessage .= "status: {$clientData['status']}\n";
                $responseMessage .= "-------------------------\n\n";
            }
        } else if (!empty($result['clients'])) {
            $responseMessage = "I've pulled up the records for {$clientName}. Here is what I have: \n\n";
            $clientData = $result['clients'][0];
            $responseMessage .= "👤 Name: {$clientData['name']}\n";
            $responseMessage .= "📞 Phone: {$clientData['phone']}\n";
            $responseMessage .= "✉️ Email: {$clientData['email']}\n";
            $responseMessage .= "status: {$clientData['status']}\n";
        } else {
            $responseMessage .= "I couldn't find any information for that client. 😕";
        }

        return $responseMessage;
    }

    /**
     * Keyboards
     */


    private function clientsKeyboard()
    {
        return [
            'keyboard' => [
                [['text' => 'Cancel']],
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ];
    }

    private function yesOrNoKeyboard()
    {
        return [
            'keyboard' => [
                [['text' => 'Yes'], ['text' => 'No']],
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ];
    }


    public function sendMessage($chatId, $response, $keyboard = [])
    {
        $params = [
            'chat_id' => $chatId,
            'text' => $response,
        ];

        if (!empty($keyboard)) {
            $params['reply_markup'] = json_encode($keyboard);
        }

         Http::post("https://api.telegram.org/bot" . config('services.telegram.bot_key') . "/sendMessage", $params);
    }
}
