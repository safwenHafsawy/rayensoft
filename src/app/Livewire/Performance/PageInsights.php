<?php

namespace App\Livewire\Performance;

use App\Services\GoogleAnalyticsService;
use Carbon\Carbon;
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

class PageInsights extends Component
{
    use WithPagination;

    public int $totalVisitors = 0;
    public array $VisitorsPerPage = [];
    public int $perPage = 7;
    public array $topPerformingPages = [];
    public array $engagementTimePerPage = [];
    public string $pageDataTimeframe = '7daysAgo';
    #[Session]
    public ?string $propertyId = '';
    private ?BetaAnalyticsDataClient $gaClient = null;

    private function client(): BetaAnalyticsDataClient
    {
        return $this->gaClient ??= GoogleAnalyticsService::getInstance();
    }

    public function mount(): void
    {
        $this->propertyId = env('GA4_PROPERTY', '');
        if (!$this->propertyId) {
            throw new \RuntimeException('GA4 Property ID not configured in .env');
        }

        $this->gaClient = $this->client();
        $this->PrepareVisitorsPerPageData();
    }

    public function PrepareVisitorsPerPageData(): void
    {
        $cacheKey = 'analytics_pages_data_' . md5($this->propertyId . $this->pageDataTimeframe);

        $response = Cache::remember($cacheKey, Carbon::now()->addHours(3), function () use ($cacheKey) {
            try {
                $request = new RunReportRequest([
                    'property' => "properties/{$this->propertyId}",
                    'date_ranges' => [
                        new DateRange([
                            'start_date' => $this->pageDataTimeframe,
                            'end_date' => 'today',
                        ]),
                    ],
                    'metrics' => [
                        new Metric(['name' => 'screenPageViews']),
                        new Metric(['name' => 'userEngagementDuration']),
                        new Metric(['name' => 'eventCount']),
                        new Metric(['name' => 'engagementRate']),
                        new Metric(['name' => 'activeUsers']),
                    ],
                    'dimensions' => [
                        new Dimension(['name' => 'pagePath']),
                    ]
                ]);

                return $this->gaClient->runReport($request);
            } catch (\Exception $e) {
                Log::warning('Google Analytics API exception', [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]);
                return Cache::get($cacheKey);
            } catch (\Throwable $e) {
                Log::error('Unexpected error in Google Analytics fetch', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                return Cache::get($cacheKey);
            }
        });

        if (!$response) return;

        $this->totalVisitors = 0;
        $this->VisitorsPerPage = [];
        $this->engagementTimePerPage = [];

        foreach ($response->getRows() as $row) {
            $value = $row->getDimensionValues()[0]->getValue();
            if (preg_match('/^\/dashboard(?:\/.*)?$/', $value)) {
                continue;
            }
            $ext = strtolower(pathinfo($value, PATHINFO_EXTENSION));

            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $value = 'imagePath';
            }
            $this->totalVisitors += (int)$row->getMetricValues()[0]->getValue();
            $this->VisitorsPerPage[$value] = [
                'numberOfVisits' => $row->getMetricValues()[0]->getValue(),
                'engagementTime' => $row->getMetricValues()[1]->getValue(),
                'eventCount' => $row->getMetricValues()[2]->getValue(),
                'engagementRate' => round(((float) $row->getMetricValues()[3]->getValue() * 100), 2),
                'activeUsers' => $row->getMetricValues()[4]->getValue(),
            ];

            if ((int)$row->getMetricValues()[1]->getValue() > 0) {
                $this->engagementTimePerPage[$row->getDimensionValues()[0]->getValue()] = (float)$row->getMetricValues()[1]->getValue();
            }
        }

        $this->topPerformingPages = array_slice(array_map(function ($value) {
            return $value['numberOfVisits'];
        }, $this->VisitorsPerPage), 0, 7);
        $this->engagementTimePerPage = array_slice($this->engagementTimePerPage, 0, 7);
    }

    public function paginateTableData(): LengthAwarePaginator
    {

        $collectedData = collect($this->VisitorsPerPage);

        // Explicitly resolve the current page
        $currentPage = Paginator::resolveCurrentPage('pages-data-table');

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
                'pageName' => 'pages-data-table',
            ]
        );
    }

    public function updatedPageDataTimeframe(): void
    {

        $this->clearData();
        $this->client();
        $this->PrepareVisitorsPerPageData();
        $this->dispatch('update-charts');
    }

    public function clearData(): void
    {
        $this->totalVisitors = 0;
        $this->VisitorsPerPage = [];
        $this->topPerformingPages = [];
        $this->engagementTimePerPage = [];
    }

    public function render(): Factory|View
    {
        $paginatedData = $this->paginateTableData();
        return view('livewire.performance.page-insights',compact('paginatedData'));
    }
}
