<?php

namespace App\Livewire\Performance;

use App\Services\GoogleAnalyticsService;
use Exception;
use Google\Analytics\Data\V1beta\BatchRunReportsRequest;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\StringFilter;
use Google\Analytics\Data\V1beta\FilterExpression;
use Google\Analytics\Data\V1beta\FilterExpressionList;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Session;
use Livewire\Component;
use Throwable;
use function Pest\Laravel\json;

class EventsInsights extends Component
{
    public array $funnelData = [
        'Visited Booking Page' => [
            'eventCount' => 0,
            'userCount' => 0,

        ],
        'Selected Date' => [
            'eventCount' => 0,
            'userCount' => 0,

        ],
        'Selected Time' => [
            'eventCount' => 0,
            'userCount' => 0,

        ],
        'Attempted Booking' => [
            'eventCount' => 0,
            'userCount' => 0,

        ],
        'Completed Booking' => [
            'eventCount' => 0,
            'userCount' => 0,

        ],
    ];

    public array $funnelSteps = [
        'begin_booking_consultation' => 'Visited Booking Page',
        'booking_step1_complete' => 'Selected Date',
        'booking_step2_complete' => 'Selected Time',
        'booking_step3_attempt' => 'Attempted Booking',
        'booking_step3_complete' => 'Completed Booking',
    ];

    public string $eventsDataTimeFrame = '7daysAgo';

    public array $linkClicksData = [];
    public array $scrollDepthData = [];

    public string $cacheKey = '';

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


        $this->fetchAllAnalytics();

    }

    public function processBookingFunnelData($response): void
    {
        foreach ($response->getRows() as $row) {
            $eventName = $row->getDimensionValues()[0]->getValue();
            $eventCount = (int)$row->getMetricValues()[0]->getValue() ?? 0;
            $userCount = (int)$row->getMetricValues()[1]->getValue() ?? 0;

            $this->funnelData[$this->funnelSteps[$eventName] ?? $eventName] = [
                'eventCount' => $eventCount,
                'userCount' => $userCount,
            ];
        }
    }

    public function processClickedLinksData($response): void
    {
        foreach ($response->getRows() as $row) {
            $linkText = strtolower($row->getDimensionValues()[0]->getValue());

            if ($linkText == 'dashboard' || $linkText == 'team') continue;
            if(!$linkText) $linkText = '__EMPTY__';

            $this->linkClicksData[$linkText] = (int)$row->getMetricValues()[0]->getValue();
        }

        arsort($this->linkClicksData);
        $this->linkClicksData = array_slice($this->linkClicksData, 0, 5, true);
    }

    public function processScrollDepthData($response): void
    {

        foreach ($response->getRows() as $row) {
            $rawThreshold = $row->getDimensionValues()[0]->getValue();

            $threshold = (int)substr($rawThreshold, 0, strlen($rawThreshold) / 2);
            $userCount = (int)$row->getMetricValues()[0]->getValue();

            $this->scrollDepthData[$threshold] = $userCount;

        }

        ksort($this->scrollDepthData);
    }

    private function fetchAllAnalytics(): void
    {
        $this->gaClient = $this->client();
        $requests = $this->prepareRequests();
        $this->cacheKey = 'analytics_events_insights_' . md5($this->eventsDataTimeFrame);
        $response = $this->runBatchAnalyticsReport($this->cacheKey, $requests);

        if (!$response) return;

        $this->processBookingFunnelData($response->getReports()[0]);
        $this->processClickedLinksData($response->getReports()[1]);
        $this->processScrollDepthData($response->getReports()[2]);

    }

    private function runBatchAnalyticsReport(string $cacheKey, array $requests)
    {
        return cache::remember($cacheKey, now()->addHour(3), function () use ($cacheKey, $requests) {
            try {
                $batchRequests = new BatchRunReportsRequest([
                    'property' => 'properties/' . $this->propertyId,
                    'requests' => $requests,
                ]);
                return $this->gaClient->batchRunReports($batchRequests);
            } catch (Exception $e) {
                Log::warning('Google Analytics device data exception', [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]);
                return Cache::get($cacheKey);
            } catch (Throwable $e) {
                Log::error('Unexpected error fetching device data', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                return Cache::get($cacheKey);
            }
        });
    }

    private function createFilters(): array
    {
        $filters['funnelFilter'] = new FilterExpression([
            'or_group' => new FilterExpressionList(
                ['expressions' => array_map(fn($event) => new FilterExpression([
                    'filter' => new Filter([
                        'field_name' => 'eventName',
                        'string_filter' => new StringFilter([
                            'match_type' => StringFilter\MatchType::EXACT,
                            'value' => $event,
                        ]),
                    ]),
                ]), array_keys($this->funnelSteps))]
            )]);

        $filters['linkClicksFilter'] = new FilterExpression([
            'filter' => new Filter([
                'field_name' => 'eventName',
                'string_filter' => new StringFilter([
                    'match_type' => StringFilter\MatchType::EXACT,
                    'value' => 'track_link-clicks',
                ]),
            ]),
        ]);

        $filters['scrollDepthFilter'] = new FilterExpression([
            'filter' => new Filter([
                'field_name' => 'eventName',
                'string_filter' => new StringFilter([
                    'match_type' => StringFilter\MatchType::EXACT,
                    'value' => 'scroll_depth',
                ]),
            ]),
        ]);

        return $filters;
    }

    private function prepareRequests(): array
    {

        $filters = $this->createFilters();

        $funnelRequest = $this->generateReportRequest(['eventName'], $filters['funnelFilter']);
        $linkClicksRequest = $this->generateReportRequest(['linkText'], $filters['linkClicksFilter']);
        $scrollDepthRequest = $this->generateReportRequest(['customEvent:scroll_percentage'], $filters['scrollDepthFilter']);

        return [$funnelRequest, $linkClicksRequest, $scrollDepthRequest];
    }

    private function generateReportRequest(array $dimensions, FilterExpression $filter): RunReportRequest
    {
        $metrics = ['eventCount', 'totalUsers'];
        $request = new RunReportRequest([
            'property' => "properties/{$this->propertyId}",
            'date_ranges' => [new DateRange([
                'start_date' => $this->eventsDataTimeFrame,
                'end_date' => 'today',
            ])],
            'dimensions' => array_map(fn($d) => new Dimension(['name' => $d]), $dimensions),
            'metrics' => array_map(fn($m) => new Metric(['name' => $m]), $metrics),
        ]);

        $request->setDimensionFilter($filter);

        return $request;
    }

    public function clearData(): void
    {
        $this->funnelData = [
            'Visited Booking Page' => [
                'eventCount' => 0,
                'userCount' => 0,

            ],
            'Selected Date' => [
                'eventCount' => 0,
                'userCount' => 0,

            ],
            'Selected Time' => [
                'eventCount' => 0,
                'userCount' => 0,

            ],
            'Attempted Booking' => [
                'eventCount' => 0,
                'userCount' => 0,

            ],
            'Completed Booking' => [
                'eventCount' => 0,
                'userCount' => 0,

            ],
        ];
        $this->linkClicksData = [];
        $this->scrollDepthData = [];
    }

    public function updatedEventsDataTimeFrame(): void
    {
        $this->clearData();
        $this->fetchAllAnalytics();
    }

    public function openDetailedAnalyticsModal($dimension, $filtered): void
    {
        $filters = $this->createFilters();
        $this->dispatch(
            'openDetailedAnalytics',
            dimension: $dimension,
            timeFrame: $this->eventsDataTimeFrame,
            type: 'Event',
            filtered: $filtered,
        );
    }

    public function render(): Factory|View
    {
        return view('livewire.performance.events-insights');
    }
}
