<?php

namespace App\Livewire\Performance;

use App\Services\GoogleAnalyticsService;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Session;
use Livewire\Component;

class Overview extends Component
{

    public ?array $currentMonthData = [
        'daysCounted' => 0,
        'totalVisits' => 0,
        'uniqueUsers' => 0,
        'AvgBounceRate' => 0.0,
        'avgPagePerSession' => 0,
        'avgVisitDuration' => 0,
        'engagementRate' => 0.0,
        'newUsers' => 0,
        'engagedSessions' => 0,

    ];

    public array $previousMonthData = [
        'daysCounted' => 0,
        'totalVisits' => 0,
        'uniqueUsers' => 0,
        'AvgBounceRate' => 0.0,
        'avgPagePerSession' => 0,
        'avgVisitDuration' => 0,
        'engagementRate' => 0.0,
        'newUsers' => 0,
        'engagedSessions' => 0,

    ];

    #[Session]
    public ?string $propertyId = '';

    private ?BetaAnalyticsDataClient $gaClient = null;

    public function mount(): void
    {
        $this->propertyId = env('GA4_PROPERTY', '');

        if (!$this->propertyId) {
            throw new \RuntimeException('GA4 Property ID not configured in ..env');
        }

        $this->gaClient ??= GoogleAnalyticsService::getInstance();

        $this->fetchOverviewData();
    }

    public function fetchOverviewData(): void
    {

        $thisMonthStart = date('Y-m-d', strtotime('first day of this month'));
        $previousMonthStart = date('Y-m-01', strtotime('-1 month'));
        $previousMonthEnd = date('Y-m-t', strtotime('-1 month'));

        $cacheKey = 'analytics_overview_data_' . md5($thisMonthStart) . '_' . md5($previousMonthEnd);

        $response = Cache::remember($cacheKey, now()->addHour(3), function () use ($thisMonthStart, $previousMonthEnd, $previousMonthStart, $cacheKey) {
            try {
                $request = new  RunReportRequest([
                    'property' => "properties/{$this->propertyId}",
                    'date_ranges' => [
                        new DateRange([
                            'start_date' => $thisMonthStart,
                            'end_date' => 'today',
                        ]),

                        new DateRange([
                            'start_date' => $previousMonthStart,
                            'end_date' => $previousMonthEnd,
                        ]),
                    ],
                    'metrics' => [
                        new Metric(['name' => 'sessions']),
                        new Metric(['name' => 'totalUsers']),
                        new Metric(['name' => 'bounceRate']),
                        new Metric(['name' => 'screenPageViews']),
                        new Metric(['name' => 'averageSessionDuration']),
                        new Metric(['name' => 'engagementRate']),
                        new Metric(['name' => 'newUsers']),
                    ],
                    'dimensions' => [
                        new Dimension(['name' => 'date']),
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
                $date = $row->getDimensionValues()[0]->getValue();
                $metrics = [
                    'sessions' => (int)$row->getMetricValues()[0]->getValue(),
                    'totalUsers' => (int)$row->getMetricValues()[1]->getValue(),
                    'bounceRate' => (float)$row->getMetricValues()[2]->getValue(),
                    'screenPageViews' => (int)$row->getMetricValues()[3]->getValue(),
                    'averageSessionDuration' => (float)$row->getMetricValues()[4]->getValue(),
                    'engagementRate' => (float)$row->getMetricValues()[5]->getValue(),
                    'newUsers' => (int)$row->getMetricValues()[6]->getValue(),
                ];

                $target = strtotime($date) >= strtotime($thisMonthStart)
                    ? $this->currentMonthData
                    : $this->previousMonthData;

                // Aggregate
                $target['totalVisits'] += $metrics['sessions'];
                $target['uniqueUsers'] += $metrics['totalUsers'];
                $target['newUsers'] += $metrics['newUsers'];
                $target['AvgBounceRate'] += $metrics['bounceRate'] * $metrics['sessions'];
                $target['engagementRate'] += $metrics['engagementRate'] * $metrics['sessions'];
                $target['avgPagePerSession'] += $metrics['screenPageViews'];
                $target['avgVisitDuration'] += ($metrics['averageSessionDuration'] * $metrics['sessions']) / 60;

                // Update back to correct month
                if (strtotime($date) >= strtotime($thisMonthStart)) {
                    $this->currentMonthData = $target;
                } else {
                    $this->previousMonthData = $target;
                }
            }

        }

//        Log::info(print_r($this->previousMonthData, true));

        $this->currentMonthData = $this->prepareData($this->currentMonthData);
        $this->previousMonthData = $this->prepareData($this->previousMonthData);
    }


    public function prepareData(array $monthlyData): array
    {
        if ($monthlyData['totalVisits'] === 0) {
            return $monthlyData;
        }
//            dd($monthlyData);

        $monthlyData['engagementRate'] =
            round(($monthlyData['engagementRate'] / $monthlyData['totalVisits']) * 100, 2);
        $monthlyData['AvgBounceRate'] = round(($monthlyData['AvgBounceRate'] / $monthlyData['totalVisits']) * 100, 2);
        $monthlyData['avgVisitDuration'] = round($monthlyData['avgVisitDuration'] / $monthlyData['totalVisits'], 2);
        $monthlyData['avgPagePerSession'] = round($monthlyData['avgPagePerSession'] / $monthlyData['totalVisits'], 2);


        return $monthlyData;
    }

    public function calculatePercentageChange($current, $previous): float|int
    {
        if ($previous == 0) {
            return $current == 0 ? 0 : 100;
        }
        return round((($current - $previous) / $previous) * 100, 0);
    }

    public function render(): Factory|View
    {
        return view('livewire.performance.overview');
    }
}
