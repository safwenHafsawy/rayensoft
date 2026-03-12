<?php

namespace App\Http\Controllers\Concerns\TelegramBot;
use App\Enums\ServiceStatus;


trait ManageMeetings
{
    public function getBookings() {
        return $this->telegramBotService->getBookings();
    }
    public function getMeetings($activeSession, $chatId, $rawInput)
    {

        $prefix = "/meetings_";
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
                $responseMessage = "I’d be happy to check the calendar! 🗓️ Would you like to see your meetings for today, this week, or next week?";
                $newStep = $prefix . "date";
                $keyboard = $this->meetingsKeyboard();
                break;

            case $prefix . "date":
                $dateRange = $this->processDateRange($rawInput);

                if (!$dateRange) {
                    $responseMessage = "Sorry, I didn't quite catch that! 😅 Could you please pick one of the date ranges from the menu below?";
                    $newStep = $prefix . "date";
                    $keyboard = $this->meetingsKeyboard();
                    break;
                }

                $data = ['dateRange' => $dateRange];
                $newStep = $prefix . "get";
                break;

            default:
                $responseMessage = "I’m sorry, I got a little lost there! Let’s start over—which dates are we looking for?";
                $newStep = $prefix . "date";
                $keyboard = $this->meetingsKeyboard();
                break;
        }
        $result = $this->telegramBotService->updateSessionData($chatId, $newStep, $data);

        // Log::info($result['meetings']);

        if ($result['status'] === ServiceStatus::SUCCESS) {
            if ($newStep === $prefix . 'get') {
                $this->renderMeetingsMessage($chatId, $data['dateRange'], $result);
                return;
            }
            $this->sendMessage($chatId, $responseMessage, $keyboard);
        } else {
            $this->sendMessage($chatId, 'Oops! I ran into a little trouble processing that. Could you try one more time for me?', $this->meetingsKeyboard());
        }
    }

    private function renderMeetingsMessage($chatId, $message, $result)
    {
        if (empty($result['meetings'])) {
            $responseMessage = "All clear! ☕ You don't have any meetings scheduled for $message. Enjoy the extra time!";
        } else {
            $responseMessage = "Here is what's on your schedule for $message: 📑\n\n";

            foreach ($result['meetings'] as $index => $meeting) {
                $leadName = $meeting->lead ? $meeting->lead->name : 'No contact linked';
                $leadPhone = $meeting->lead ? $meeting->lead->phone : 'N/A';
                $leadEmail = $meeting->lead ? $meeting->lead->email : 'N/A';

                $responseMessage .= "🔹 Meeting " . ($index + 1) . "\n";
                $responseMessage .= "⏰ {$meeting->hour} on {$meeting->date}\n";
                $responseMessage .= "👤 Contact: {$leadName}\n";
                $responseMessage .= "📞 {$leadPhone}  |  ✉️ {$leadEmail}\n\n";
            }

            $responseMessage .= "Anything else I can help you with? 😊";
        }

        $this->sendMessage($chatId, $responseMessage, SELF::DEFAULT_KEYBOARD);
        $this->telegramBotService->clearSession($chatId);
    }

    private function processDateRange(string $text): ?string
    {
        $t = $this->normalizeText($text);

        // remove common punctuation (keep spaces)
        $t = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $t) ?? $t;
        $t = preg_replace('/\s+/', ' ', trim($t)) ?? $t;

        // tokenize
        $tokens = preg_split('/\s+/', $t) ?: [];

        // handle "next week", "this week" even when inside long sentence
        if ($this->containsPhrase($tokens, ['next', 'week'])) {
            return 'next_week';
        }
        if ($this->containsPhrase($tokens, ['this', 'week']) || $this->containsPhrase($tokens, ['current', 'week'])) {
            return 'week';
        }
        // today / tomorrow 
        if (in_array('today', $tokens, true)) {
            return 'today';
        }

        // users type "tmr", "tod", "2day", "wk", etc.
        $synonyms = [
            'today' => ['tod', '2day', '2dayy', 'td', 'tday'],
            'week' => ['wk', 'thiswk', 'currentweek'],
            'next_week' => ['nextwk', 'nxtweek', 'nxtwk'],
            'tomorrow' => ['tmr', 'tmrw', 'tommorow', 'tomorow'],
        ];

        foreach ($synonyms as $range => $alts) {
            foreach ($alts as $alt) {
                if (in_array($alt, $tokens, true)) {
                    return $range;
                }
            }
        }

        $targets = ['today', 'tomorrow', 'this', 'next', 'week', 'current'];

        $corrected = [];
        foreach ($tokens as $tok) {
            $corrected[] = $this->fuzzyCorrectToken($tok, $targets, 2);
        }

        if ($this->containsPhrase($corrected, ['next', 'week'])) {
            return 'next_week';
        }
        if ($this->containsPhrase($corrected, ['this', 'week']) || $this->containsPhrase($corrected, ['current', 'week'])) {
            return 'week';
        }
        if (in_array('today', $corrected, true)) {
            return 'today';
        }
        if (in_array('tomorrow', $corrected, true)) {
            return 'tomorrow';
        }

        return null;
    }

    private function containsPhrase(array $tokens, array $phrase): bool
    {
        $n = count($phrase);
        if ($n === 0) return false;

        for ($i = 0; $i <= count($tokens) - $n; $i++) {
            $ok = true;
            for ($j = 0; $j < $n; $j++) {
                if ($tokens[$i + $j] !== $phrase[$j]) {
                    $ok = false;
                    break;
                }
            }
            if ($ok) return true;
        }
        return false;
    }


    private function fuzzyCorrectToken(string $token, array $targets, int $maxDistance = 2): string
    {
        if ($token === '') return $token;

        if (mb_strlen($token) < 3) return $token;

        $best = $token;
        $bestDist = PHP_INT_MAX;

        foreach ($targets as $target) {
            $dist = levenshtein($token, $target);
            if ($dist < $bestDist) {
                $bestDist = $dist;
                $best = $target;
            }
        }
        $len = max(1, mb_strlen($token));
        $ratio = $bestDist / $len;

        if ($bestDist <= $maxDistance && $ratio <= 0.4) {
            return $best;
        }

        return $token;
    }


    private function meetingsKeyboard()
    {
        return [
            'keyboard' => [
                [['text' => 'Today'], ['text' => 'This Week'], ['text' => 'Next Week']],
                [['text' => 'Cancel']],
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ];
    }
}
