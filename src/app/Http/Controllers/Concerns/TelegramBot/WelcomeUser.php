<?php

namespace App\Http\Controllers\Concerns\TelegramBot;

trait WelcomeUser
{
    public function isGreetingIntent(string $text): bool
    {
        $greetingPattrens = [
            '/^(hello|hi|greetings|what\'s up|whats up|good morning|good afternoon|good evening)(\S|\s)*$/i',
        ];

        $t = $this->normalizeText($text);
        $t = str_replace(['/', '\\'], '', $t);
        $t = $this->correctTypos($t) ?? $t;

        foreach ($greetingPattrens as $pattern) {
            if (preg_match($pattern, $t)) {
                return true;
            }
        }

        return false;
    }

    public function introduceYourself(string $text): bool
    {
        $t = $this->normalizeText($text);
        $t = str_replace(['/', '\\'], '', $t);
        $t = $this->correctTypos($t) ?? $t;

        $patterns = [
            '/who are you/i',
            '/introduce yourself/i',
        ];

        foreach ($patterns as $pattern) {

            if (preg_match($pattern, $t)) {
                return true;
            }
        }

        return false;
    }


    public function welcomeUser($chatId, $message, $userName): void
    {
        $responseMessage = '';
        $responseMessage = "Hello $userName! 👋 I'm ready to help. What can I assist you with today?";
        $this->sendMessage($chatId, $responseMessage, SELF::DEFAULT_KEYBOARD);
    }
}
