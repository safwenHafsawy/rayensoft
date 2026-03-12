<?php

namespace App\Livewire\Performance;

use Livewire\Component;
use App\Services\GoogleAnalyticsService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\ValidationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Session;

class TrafficTrends extends Component
{
    public array $totalVisits = [];
    public array $engagementVisits = [];
    public array $trafficMonthLabels = [];
    public array $sessionSource = [];
    public array $sessionMedium = [];

    public string $trafficTimeframe = '30daysAgo';

    public array $sessionLandingPages = [];

    #[Session]
    public ?string $propertyId = '';

    private ?BetaAnalyticsDataClient $gaClient = null;

    private function client(): BetaAnalyticsDataClient
    {
        return $this->gaClient ??= GoogleAnalyticsService::getInstance();
    }


    /**
     * @throws ValidationException
     * @throws ApiException
     */
    public function mount(): void
    {
        $this->propertyId = env('GA4_PROPERTY', '');
        if (!$this->propertyId) {
            throw new \RuntimeException('GA4 Property ID not configured in .env');
        }

        $this->gaClient = $this->client();

        $this->fetchTrafficTrendsData();
    }

    /**
     * @return void
     * @throws ValidationException|ApiException
     */
    public function fetchTrafficTrendsData(): void
    {
        $this->generateTimePeriod();

        $cacheKey = 'traffic_trends_data' . md5($this->trafficTimeframe);

        $response = Cache::remember($cacheKey, now()->addHour(3), function () use ($cacheKey) {
            try {
                $request = new RunReportRequest([
                    'property' => "properties/$this->propertyId",
                    'date_ranges' => [
                        new DateRange([
                            'start_date' => $this->trafficTimeframe,
                            'end_date' => 'today'
                        ]),
                    ],
                    'metrics' => [
                        new Metric(['name' => 'sessions']),
                        new Metric(['name' => 'engagedSessions']),
                    ],
                    'dimensions' => [
                        new Dimension(['name' => 'date']),
                        new Dimension(['name' => 'sessionSource']),
                        new Dimension(['name' => 'landingPage']),
                        new Dimension(['name' => 'sessionMedium']),
                    ]
                ]);


                return $this->gaClient->runReport($request);
            } catch (\Exception $e) {
                Log::warning('Google Analytics API exception', [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]);

                // try and get old data
                $oldData = Cache::get($cacheKey);

                if ($oldData) {
                    return $oldData;
                }
                return null;
            } catch (\Throwable $e) {
                Log::error('Unexpected error in Google Analytics fetch', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                // try and get old data
                $oldData = Cache::get($cacheKey);

                if ($oldData) {
                    return $oldData;
                }
                return null;
            }
        });


        if ($response) {
            foreach ($response->getRows() as $row) {
                $date = Carbon::parse($row->getDimensionValues()[0]->getValue());
                $this->totalVisits[$date->format('d-m')] += (int)$row->getMetricValues()[0]->getValue();
                $this->engagementVisits[$date->format('d-m')] += (int)$row->getMetricValues()[1]->getValue();

                $this->sessionLandingPages = $this->sumValueByKey($this->sessionLandingPages, $row->getDimensionValues()[2]->getValue(), (int)$row->getMetricValues()[0]->getValue());

                $this->sessionSource = $this->sumValueByKey($this->sessionSource, $row->getDimensionValues()[1]->getValue(), (int)$row->getMetricValues()[0]->getValue());

                $this->sessionMedium = $this->sumValueByKey($this->sessionMedium, $row->getDimensionValues()[3]->getValue(), (int)$row->getMetricValues()[0]->getValue());
            }

            $this->sessionLandingPages = array_filter(
                $this->sessionLandingPages,
                fn($value, $key) => !preg_match('/^\/dashboard(?:\/.*)?$/', $key) && $key !== '',
                ARRAY_FILTER_USE_BOTH
            );

            $limit = 5;
            if ($this->trafficTimeframe === '7daysAgo') {
                $limit = 3;
            } else if ($this->trafficTimeframe === 'yesterday') {
                $limit = 1;
            }

            $this->sessionSource = $this->mergeSmallValues($this->sessionSource, $limit);
            $this->sessionMedium = $this->mergeSmallValues($this->sessionMedium, $limit);
            $this->sessionLandingPages = $this->mergeSmallValues($this->sessionLandingPages, $limit);

        }

    }

    private function mergeSmallValues($dataArr, $limit): array
    {
        foreach ($dataArr as $key => $value) {
            if ($value <= $limit) {
                $dataArr = $this->sumValueByKey($dataArr, 'Other', $value);
                unset($dataArr[$key]);
            }
        }

        return $dataArr;
    }

    private function sumValueByKey($dataArr, $key, $value): array
    {
        if (array_key_exists($key, $dataArr)) {
            $dataArr[$key] += $value;
        } else {
            $dataArr[$key] = $value;
        }

        return $dataArr;
    }

    public function generateTimePeriod(): void
    {
        $start = null;
        $end = null;
        switch ($this->trafficTimeframe) {
            case 'yesterday':
                $start = Carbon::now()->subDays(1)->startOfDay();
                $end = Carbon::today();
                break;
            case '7daysAgo':
                $start = Carbon::now()->subDays(7)->startOfDay();
                $end = Carbon::today();
                break;
            case '30daysAgo':
                $start = Carbon::now()->subDays(30)->startOfDay();
                $end = Carbon::today();
                break;
            case '60daysAgo':
                $start = Carbon::now()->subDays(60)->startOfDay();
                $end = Carbon::today();
                break;
        }

        $period = CarbonPeriod::create($start, $end);

        foreach ($period as $date) {
            $this->trafficMonthLabels[] = $date->format('d-m');
            $this->totalVisits[$date->format('d-m')] = 0;
            $this->engagementVisits[$date->format('d-m')] = 0;
        }
    }

    public function clearData(): void
    {
        $this->totalVisits = [];
        $this->engagementVisits = [];
        $this->trafficMonthLabels = [];
        $this->sessionSource = [];
        $this->sessionMedium = [];
        $this->sessionLandingPages = [];
    }

    /**
     * @throws ValidationException
     * @throws ApiException
     */
    public function updatedTrafficTimeframe(): void
    {
        $this->clearData();
        $this->client();
        $this->fetchTrafficTrendsData();

        $this->dispatch('update-traffic-charts');
    }

    public function openDetailedAnalyticsModal($dimension): void
    {
        $this->dispatch('openDetailedAnalytics', dimension: $dimension , timeFrame: $this->trafficTimeframe);
    }

    public function render(): Factory|View
    {
        return view('livewire.performance.traffic-trends');
    }
}
