<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\ApiCore\ValidationException;
use Illuminate\Support\Facades\Log;

class GoogleAnalyticsService {
    private static ?BetaAnalyticsDataClient $client = null;

    public static function getInstance(): BetaAnalyticsDataClient {
        if (!isset(self::$client)) {

            try {
                self::$client = new BetaAnalyticsDataClient([
                    'credentials' => storage_path('app/ga4/rayensoft-analytics.json')
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to initialize Google Analytics client: ' . $e->getMessage());
                throw new \RuntimeException('Failed to initialize Google Analytics client');
            }

        }

        return self::$client;
    }
}
