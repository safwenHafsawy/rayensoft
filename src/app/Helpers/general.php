<?php

use Mews\Purifier\Facades\Purifier;

function cleanAndNormalizeText(string $text) : string
{
    // Step 1: Strip all HTML
    $clean = Purifier::clean($text, ['HTML.Allowed' => '']);

    // Step 2: Replace multiple spaces or tabs with a single space
    $clean = preg_replace('/[ \t]+/', ' ', $clean);

    // Step 3: Replace multiple newlines with a single newline
    $clean = preg_replace('/\s*\n\s*/', "\n", $clean);

    // Step 4: Trim leading/trailing whitespace
    return trim($clean);
}


function calculateChange(float|int $current, float|int $previous): float
{
    if ($previous == 0) {
        if ($current == 0) {
            return 0.0;
        }
        return $current;
    }
    $change = (($current - $previous) / $previous) * 100;
    return number_format($change, 0) ;
}
