<?php

namespace App\Livewire\Performance;

use Carbon\Carbon;
use Exception;
use Google\Analytics\Data\V1beta\BatchRunReportsRequest;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Services\GoogleAnalyticsService;
use Livewire\Attributes\Session;
use RuntimeException;
use Throwable;

class UserInsights extends Component
{
    public string $userDataTimeframe = '7daysAgo';

    public array $visitByCountries = [];
    public array $visitByRegions = [];

    public array $visitByCities = [];

    public array $returningVsNewByDatesLabels = [];

    public array $returningVisitorsByDates = [];
    public array $newVisitorsByDates = [];

    public array $totalVisitorsComp = [
        'New' => 0,
        'Returning' => 0,
        'Unknown' => 0
    ];

    public array $userByDevice = [];
    public array $userByOS = [];
    public array $userByScreenResolution = [];
    public array $userByBrowserLanguage = [];

    public string $cacheKey = '';

    #[Session]
    public ?string $propertyId = '';

    private ?BetaAnalyticsDataClient $gaClient = null;

    public function mount(): void
    {

        // Setting the property ID
        $this->propertyId = env('GA4_PROPERTY', '');

        if (!$this->propertyId) {
            throw new RuntimeException('GA4 Property ID not configured in ..env');
        }

        $this->fetchAllAnalytics();
    }

    public function processGeoLocData($response): void
    {

        foreach ($response->getRows() as $row) {
            $country = $row->getDimensionValues()[0]->getValue();
            $region = $row->getDimensionValues()[1]->getValue();
            $city = $row->getDimensionValues()[2]->getValue();
            $totalVisits = (int) $row->getMetricValues()[0]->getValue();

            if ($country === '(not set)') $country = 'Unknown';
            if ($region === '(not set)' || $region === '') $region = 'Unknown';
            if ($city === '(not set)' || $city === '') $city = 'Unknown';

            $this->visitByCountries = $this->sumValueByKey($this->visitByCountries, $country, $totalVisits);
            $this->visitByRegions = $this->sumValueByKey($this->visitByRegions, $region, $totalVisits);
            $this->visitByCities = $this->sumValueByKey($this->visitByCities, $city, $totalVisits);
        }

        if ($this->userDataTimeframe !== 'yesterday') {

            $this->visitByCountries = $this->mergeSmallValues($this->visitByCountries, 5);

            $this->visitByRegions = $this->mergeSmallValues($this->visitByRegions, 3);

            $this->visitByCities = $this->mergeSmallValues($this->visitByCities, 3);

        }

    }

    public function processUserCategoryData($response): void
    {
        $labelsSet = [];
        foreach ($response->getRows() as $row) {
            $date = Carbon::parse($row->getDimensionValues()[0]->getValue())->format('Y-m-d');
            $returnNew = ucfirst(trim($row->getDimensionValues()[1]->getValue()));
            if ($returnNew === '(not set)' || $returnNew === '') $returnNew = 'Unknown';
            $visitCount = (int)$row->getMetricValues()[0]->getValue();

            // Increment totals
            $this->totalVisitorsComp[$returnNew] += $visitCount;

            // Add date to labels set
            $labelsSet[$date] = true;

            // Increment by date
            if ($returnNew === 'New') {
                $this->newVisitorsByDates = $this->sumValueByKey($this->newVisitorsByDates, $date, $visitCount);
            } elseif ($returnNew === 'Returning') {
                $this->returningVisitorsByDates = $this->sumValueByKey($this->returningVisitorsByDates, $date, $visitCount);
            }
        }

        $this->returningVsNewByDatesLabels = array_keys($labelsSet);
        sort($this->returningVsNewByDatesLabels);

        $this->fillDateLabels();
    }


    public function processDevicesData($response): void
    {

        foreach ($response->getRows() as $row) {
            $device = $row->getDimensionValues()[0]->getValue();
            $operatingSystem = $row->getDimensionValues()[1]->getValue();
            $screenResolution = $row->getDimensionValues()[2]->getValue();
            $deviceLanguage = $row->getDimensionValues()[3]->getValue();

            $userCount = (int)$row->getMetricValues()[0]->getValue();

            $this->userByDevice = $this->sumValueByKey($this->userByDevice, $device, $userCount);
            $this->userByOS = $this->sumValueByKey($this->userByOS, $operatingSystem, $userCount);
            $this->userByScreenResolution = $this->sumValueByKey($this->userByScreenResolution, $screenResolution, $userCount);
            $this->userByBrowserLanguage = $this->sumValueByKey($this->userByBrowserLanguage, $deviceLanguage, $userCount);

        }

        $this->userByScreenResolution = $this->mergeSmallValues($this->userByScreenResolution, 2);
    }

    /**
     * HELPER FUNCTIONS
     */


    private function prepareRequests(): array
    {
        $devicesReportRequest = $this->generateReportRequest(
            ['deviceCategory', 'operatingSystem', 'screenResolution', 'language'], ['totalUsers']
        );

        $behaviorReportRequest = $this->generateReportRequest(
            ['date', 'newVsReturning'] , ['totalUsers']
        );

        $geoLocationReportRequest = $this->generateReportRequest(
            ['country', 'region', 'city'], ['sessions']
        );

        return [
            $devicesReportRequest, $behaviorReportRequest, $geoLocationReportRequest
        ];

    }

    private function client(): BetaAnalyticsDataClient
    {
        return $this->gaClient ??= GoogleAnalyticsService::getInstance();
    }

    private function fetchAllAnalytics (): void  {
        $this->gaClient = $this->client();
        $requests = $this->prepareRequests();
        $this->cacheKey = 'analytics_user_insights_' . md5($this->userDataTimeframe);
        $response = $this->runBatchAnalyticsReport($this->cacheKey, $requests);
        $this->processGeoLocData($response->getReports()[2]);
        $this->processUserCategoryData($response->getReports()[1]);
        $this->processDevicesData($response->getReports()[0]);
    }

    private function generateReportRequest(array $dimensions, array $metrics): RunReportRequest
    {
        return new RunReportRequest([
            'property' => "properties/$this->propertyId",
            'date_ranges' => [
                new DateRange([
                    'start_date' => $this->userDataTimeframe,
                    'end_date' => 'today',
                ])
            ],
            'metrics' => array_map(fn($m) => new Metric(['name' => $m]), $metrics),
            'dimensions' => array_map(fn($d) => new Dimension(['name' => $d]), $dimensions),
        ]);
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

    public function fillDateLabels(): void
    {
        $startDate = Carbon::parse($this->userDataTimeframe);
        $endDate = Carbon::today();

        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $dateKey = $currentDate->format('Y-m-d');

            if (!in_array($dateKey, $this->returningVsNewByDatesLabels, true)) {
                $this->returningVsNewByDatesLabels[] = $dateKey;
            }

            $this->returningVisitorsByDates[$dateKey] = $this->returningVisitorsByDates[$dateKey] ?? 0;
            $this->newVisitorsByDates[$dateKey] = $this->newVisitorsByDates[$dateKey] ?? 0;


            $currentDate->addDay();
        }

        //sorting arrays to match date order
        sort($this->returningVsNewByDatesLabels);
        ksort($this->returningVisitorsByDates);
        ksort($this->newVisitorsByDates);
    }

    public function mergeSmallValues($dataArr, $limit): array
    {
        foreach ($dataArr as $key => $value) {
            if ($value <= $limit) {
                $dataArr = $this->sumValueByKey($dataArr, 'Other', $value);
                unset($dataArr[$key]);
            }
        }

        return $dataArr;
    }

    public function sumValueByKey($dataArr, $key, $value): array
    {
        if (array_key_exists($key, $dataArr)) {
            $dataArr[$key] += $value;
        } else {
            $dataArr[$key] = $value;
        }

        return $dataArr;
    }

    public function clearData(): void
    {
        $this->visitByCountries = [];
        $this->visitByRegions = [];
        $this->visitByCities = [];
        $this->returningVsNewByDatesLabels = [];
        $this->returningVisitorsByDates = [];
        $this->newVisitorsByDates = [];
        $this->totalVisitorsComp = [
            'New' => 0,
            'Returning' => 0,
            'Unknown' => 0
        ];
        $this->userByDevice = [];
        $this->userByOS = [];
        $this->userByScreenResolution = [];
        $this->userByBrowserLanguage = [];
    }

    public function updatedUserDataTimeframe(): void
    {
        $this->clearData();
        $this->fetchAllAnalytics();
        $this->dispatch('update-audience-charts');
    }

    public function openDetailedAnalyticsModal($dimension): void
    {
        $this->dispatch('openDetailedAnalytics', dimension: $dimension , timeFrame: $this->userDataTimeframe);
    }


    public function render(): Factory|View
    {
        return view('livewire.performance.user-insights');
    }
}
