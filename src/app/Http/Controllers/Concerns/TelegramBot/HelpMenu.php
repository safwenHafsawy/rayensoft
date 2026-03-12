<?php

namespace App\Http\Controllers\Concerns\TelegramBot;

use Pest\Mutate\Mutators\Logical\BooleanAndToBooleanOr;

trait HelpMenu
{
    public function showMenu($rawInput): bool
    {
        $t = $this->normalizeText($rawInput);
        $t = str_replace(['/', '\\'], '', $t);
        $t = $this->correctTypos($t) ?? $t;
       
        return $this->isHelpMenuIntent($t);
    }

    public function isHelpMenuIntent(string $text): bool
    {
        $exactPhrases = [
            'help',
            'menu',
            'commands',
            'command',
            'options',
            'what can you do',
            'what do you do',
            'how does this work',
            'show me the menu',
            'show menu',
            'show commands',
            'list commands',
            'list options',
            'start',
        ];

        if (in_array($text, $exactPhrases, true)) {
            return true;
        }

        $patterns = [
            '/\/?(help|menu|commands?|options?)/i',
            '/what can you do/i',
            '/what do you do/i',
            '/how can you assist/i',
            '/how does this work/i',
            '/show (me )?(the )?(menu|commands?)/i',
            '/list (the )?(commands?|options?)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text)) {
                return true;
            }
        }

        // keyword scoring

        $tokens = preg_split('/\s+/u', $text) ?: [];
        $tokens = array_values(array_filter($tokens));

        $keywords = [
            'help' => 3,
            'menu' => 3,
            'commands' => 3,
            'command' => 2,
            'option' => 2,
            'guide' => 1,
            'assist' => 1,
            'how' => 1
        ];

        $score = 0;
        foreach($tokens as $token) {
            if(isset($keywords[$token])) {
                $score += $keywords[$token];
            }
        }

        return $score >= 4;
    }
}
