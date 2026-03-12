<?php

namespace App\Livewire\ClientManagement;

use App\Models\Client;
use App\Models\Leads;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Overview extends Component
{

    public array $totalClientsData = [];
    public array $conversionRateData = [];
    public array $leadsData = [];

    public function mount(): void
    {
        $leads = Leads::with('client')->get()->toArray();
        $clients = Client::all()->toArray();

        $this->getClientsData($clients);
        $this->getConversionRate($leads, $clients);
        $this->getLeadsData($leads);
    }

    private function getClientsData($clients): void {
        $totalClients = count($clients);

        $filteredClients = count(array_filter($clients, fn ($client) => Carbon::parse($client['created_at'])->diffInDays(Carbon::now()) <= 30));

        $monthlyChangeInClients = $totalClients - $filteredClients;

        $this->totalClientsData = [
            'thisMonthClients' => $totalClients,
            'monthlyChangeInClients' => $monthlyChangeInClients,
        ];
    }

    private function getConversionRate($leads, $clients): void
    {
        if(count($leads) === 0) {
            $this->conversionRateData = [
                'ConversionRate' => 0,
                'ChangeInConversionRate' => 0,
            ];
            return;
        }
        $conversionRate = round(count($clients) / count($leads) * 100, 2);

        $filteredClientsCount = count(array_filter($clients, fn($client) => Carbon::parse($client['created_at'])->diffInDays(Carbon::now()) <= 30
        ));

        $changeInConversionRate = $conversionRate - round($filteredClientsCount / count($leads) * 100, 2);


        $this->conversionRateData = [
            'ConversionRate' => $conversionRate,
            'ChangeInConversionRate' => $changeInConversionRate,
        ];
    }

    private function getLeadsData($leads): void
    {
        $currMonthLeads = count(
            array_filter($leads, fn($lead) => Carbon::parse($lead['created_at'])->diffInDays(Carbon::now()) <= 30));
        $prevMonthLeads = count(
            array_filter($leads, fn($lead) => Carbon::parse($lead['created_at'])->diffInDays(Carbon::now()) >= 30 && Carbon::parse($lead['created_at'])->diffInDays(Carbon::now()) <= 60)
        );

        $oldFollowUps = 0;
        $totalFollowUps = 0;

        foreach ($leads as $lead) {
            if($lead['status'] === 'Follow-up Required'){
                $totalFollowUps++;
                if(Carbon::parse($lead['updated_at'])->diffInDays(Carbon::now()) >= 7) $oldFollowUps++;
            }
        }

        $totalFollowUpsWeeklyChange = $totalFollowUps - $oldFollowUps;

        $this->leadsData = [
            'thisMonthLeads' => $currMonthLeads,
            'thisWeekFollowUps' => $totalFollowUps,
            'monthlyChangeInLeads' => calculateChange($currMonthLeads, $prevMonthLeads),
            'weeklyChangeInFollowUps' => $totalFollowUpsWeeklyChange,
        ];
    }

    public function render(): Factory|View
    {
        return view('livewire.client-management.overview');
    }
}
