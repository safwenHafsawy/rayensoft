<?php

namespace App\Livewire\Main;

use App\Models\Leads;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LeadsFunnel extends Component
{
    public array $leadsFunnel = [
        'New' => 0,
        'Call Back Requested' => 0,
        'Processing' => 0,
        'Proposition Sent' => 0,
        'Won' => 0,
        'Not Interested' => 0,
    ];
    public function mount()
    {
        $leadsData = Leads::select('status', DB::raw('COUNT(id) as total_leads'))
            ->groupBy('status')
            ->get();

        foreach ($leadsData as $data) {
            $status = $data->status;
            $total = $data->total_leads;

            if (array_key_exists($status, $this->leadsFunnel)) {
                $this->leadsFunnel[$status] = $total;
            }
        }
    }
    public function render(): Factory|View
    {
        return view('livewire.main.leads-funnel');
    }
}
