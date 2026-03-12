<?php

namespace App\Livewire\Modals;

use App\Services\GoogleAnalyticsService;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\WithPagination;
use RuntimeException;

class DetailedAnalytics extends Component
{

    use WithPagination;

    public bool $isOpen = false;
    public string $dimension;
    public string $timeFrame;

    public int $perPage = 7;

    public array $reportData = [];

    protected $listeners = ['openDetailedAnalytics' => 'openDetailedAnalytics'];

    public array $metrics = [
        'Total Visits' => 'sessions',
        'Active Users' => 'activeUsers',
        'New Users' => 'newUsers',
        'Event Count' => 'eventCount',
        'Average Session Duration' => 'averageSessionDuration',
        'Engagement Rate ' => 'engagementRate',
        'Number of Visited Pages' => 'screenPageViews',
    ];

    #[Session]
    public string $propertyId = '';


    private ?BetaAnalyticsDataClient $gaClient = null;

    public function openDetailedAnalytics($dimension, $timeFrame): void
    {
        // Setting the property ID
        $this->propertyId = env('GA4_PROPERTY', '');

        if (!$this->propertyId) {
            throw new RuntimeException('GA4 Property ID not configured in .env');
        }

        $this->dimension = $dimension;
        $this->gaClient = $this->client();
        $this->timeFrame = $timeFrame;
        $this->fetchAndPrepareDimensionData();
        $this->resetPage(pageName: 'detailed-page');
        $this->isOpen = true;
    }

    public function closeModal(): void
    {
        $this->reportData = [];
        $this->dimension = '';
        $this->timeFrame = '';
        $this->resetPage(pageName: 'detailed-page');
        $this->isOpen = false;
    }

    private function fetchAndPrepareDimensionData(): void
    {
        $this->reportData = [];
        $cacheKey = 'detailed_analytics_' . $this->dimension . '_' . md5($this->timeFrame);
        $request = $this->generateReportRequest([$this->dimension]);

        $response = $this->runSingleAnalyticsReport($cacheKey, $request);

        if (!$response) return;

        foreach ($response->getRows() as $row) {
            $dimensionValue = $row->getDimensionValues()[0]->getValue();
            $totalVisits = $row->getMetricValues()[0]->getValue();
            $activeUsers = $row->getMetricValues()[1]->getValue();
            $newUsers = $row->getMetricValues()[2]->getValue();
            $eventCount = $row->getMetricValues()[3]->getValue();
            $averageSessionDuration = round($row->getMetricValues()[4]->getValue() / 60, 0) . " minutes";
            $engagementRate = round($row->getMetricValues()[5]->getValue() * 100, 2) . '%';
            $numberOfVisitedPages = $row->getMetricValues()[6]->getValue();

            if($dimensionValue === '(not set)' || $dimensionValue === '') $dimensionValue = 'Unknown';

            $this->reportData [$dimensionValue] = [
                'totalVisits' => $totalVisits,
                'activeUsers' => $activeUsers,
                'newUsers' => $newUsers,
                'eventCount' => $eventCount,
                'averageSessionDuration' => $averageSessionDuration,
                'engagementRate' => $engagementRate,
                'numberOfVisitedPages' => $numberOfVisitedPages,
            ];
        }
        $this->resetPage(pageName: 'detailed-page');
    }


    private function runSingleAnalyticsReport($cacheKey, $request)
    {
        return Cache::remember($cacheKey, now()->addHours(3), function () use ($cacheKey, $request) {
            try {
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
    }

    private function generateReportRequest(array $dimensions): RunReportRequest
    {
        return new RunReportRequest([
            'property' => "properties/$this->propertyId",
            'date_ranges' => [
                new DateRange([
                    'start_date' => $this->timeFrame,
                    'end_date' => 'today',
                ])
            ],
            'metrics' => array_map(fn($m) => new Metric(['name' => $m]), array_values($this->metrics)),
            'dimensions' => array_map(fn($d) => new Dimension(['name' => $d]), $dimensions),

        ]);
    }

    public function paginateTableData(): LengthAwarePaginator
    {
        $collectedData = collect($this->reportData);

        // Explicitly resolve the current page
        $currentPage = Paginator::resolveCurrentPage('detailed-page');

        // Calculate the offset and slice the collection to get items for the current page
        $offset = ($currentPage - 1) * $this->perPage;
        $paginatedData = $collectedData->slice($offset, $this->perPage)->all();

        // Create a LengthAwarePaginator instance for proper pagination
        return new LengthAwarePaginator(
            $paginatedData,
            $collectedData->count(),
            $this->perPage,
            $currentPage,
            [
                'path' => url()->current(),
                'pageName' => 'detailed-page',
            ]
        );
    }

    private function client(): BetaAnalyticsDataClient
    {
        return $this->gaClient ??= GoogleAnalyticsService::getInstance();
    }

    public function render(): Factory|View
    {
        return view('livewire.modals.detailed-analytics', [
            'paginatedData' => $this->paginateTableData(),
        ]);
    }
}
