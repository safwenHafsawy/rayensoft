<?php

namespace App\Livewire\ClientManagement;

use App\Models\LeadActivity;
use App\Models\Leads;
use App\Models\LeadSocialMediaContact;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class LeadsTable extends Component
{
    use WithPagination;

    public bool $showJunk = false;

    protected $listeners = ['updateLeadsTable' => 'refreshTable'];

    public array $lead_statues = [
        'New',
        'Call Back',
        'Call Back Requested',
        'Inquiry',
        'Processing',
        'Proposition Sent',
        'Not Interested',
        'Won',
        'Junk'
    ];
    public array $leadSources = ['Booking Page', 'Referrals', 'Website', 'Email', 'Social Media', 'Direct Outreach'];
    public array $industries = ['Website : E-Commerce', 'Website : Services', 'Media Buyer', 'Consultation'];
    private LengthAwarePaginator $leads;

    public function getStatusClass($status): string
    {
        return match ($status) {
            'New' => 'text-white bg-blue-500',
            'Call Back Requested' => 'text-white bg-red-500',
            'Call Back' => 'text-amber-900 bg-amber-300',
            'Inquiry' => 'text-white bg-violet-600',
            'Processing' => 'text-white bg-sky-500',
            'Proposition Sent' => 'text-white bg-fuchsia-600',
            'Won' => 'text-white bg-emerald-500',
            'Not Interested' => 'text-stone-700 bg-stone-200',
            'Junk' => 'text-zinc-400 bg-zinc-100 line-through',
            default => 'text-gray-500',
        };
    }

    public function getStatusIcon($status): string
    {
        return match ($status) {
            'New' => 'fa-solid fa-star',
            'Call Back Requested' => 'fa-solid fa-phone-volume',
            'Call Back' => 'fa-solid fa-phone',
            'Inquiry' => 'fa-solid fa-circle-question',
            'Processing' => 'fa-solid fa-spinner',
            'Proposition Sent' => 'fa-solid fa-paper-plane',
            'Won' => 'fa-solid fa-trophy',
            'Not Interested' => 'fa-solid fa-ban',
            'Junk' => 'fa-solid fa-trash-can',
            default => 'fa-solid fa-circle',
        };
    }

    public array $filters = [
        'status' => '',
        'lead_source' => '',
        'lead_industry' => '',
        'search' => '',
    ];

    public function resetFilters(): void
    {
        $this->filters = [
            'status' => '',
            'lead_source' => '',
            'lead_industry' => '',
            'search' => '',
        ];
        $this->resetPage();
    }

    public function toggleShowJunk(): void
    {
        $this->showJunk = !$this->showJunk;
        $this->resetPage();
    }

    public function getLeadsData(): LengthAwarePaginator
    {

        $query = Leads::query()->with('found_by')->orderBy('created_at', 'desc');

        if (!$this->showJunk) {
            $query->where('status', '!=', 'Junk');
        }

        $socials = LeadSocialMediaContact::query()->with('lead')->orderBy('created_at', 'desc');
        $activities = LeadActivity::query()->with('lead')->orderBy('created_at', 'desc');

        // Apply status filter if not 'all'
        if ($this->filters['status'] !== '') {
            $query->where('status', strtolower($this->filters['status']));
        }

        // Apply lead source filter if not 'all'
        if ($this->filters['lead_source'] !== '') {
            $query->where('lead_source', strtolower($this->filters['lead_source']));
        }

        // Apply Industry Search if not 'all'
        if ($this->filters['lead_industry'] !== '') {
            $query->where('industry', strtolower($this->filters['lead_industry']));
        }

        // Apply search filter if not empty
        if (!empty($this->filters['search'])) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $this->filters['search'] . '%')
                    ->orWhere('industry', 'like', '%' . $this->filters['search'] . '%')
                    ->orWhere('lead_source', 'like', '%' . $this->filters['search'] . '%')
                    ->orWhere('phone', 'like', '%' . $this->filters['search'] . '%');
            });

            // $socials->where(function ($q) {
            //     $q->where('instagram', 'like', '%' . $this->filters['search'] . '%')
            //         ->orWhere('linkedin', 'like', '%' . $this->filters['search'] . '%')
            //         ->orWhere('facebook', 'like', '%' . $this->filters['search'] . '%');
            // });

            // $activities->where(function ($q) {
            //     $q->where('description', 'like', '%' . $this->filters['search'] . '%');
            // });
        }


        return $query->paginate(20);
    }

    public function mount(): void
    {
        $this->getLeadsData();
    }

    public function refreshTable(): void
    {
        $this->resetPage();
        $this->getLeadsData();
    }

    public function openLeadsUpsertModal($lead_id = null): void
    {
        $this->dispatch('openLeadsUpsertModal', $lead_id);
    }
    public function render(): Factory|View
    {
        return view('livewire.client-management.leads-table', [
            'leads' => $this->getLeadsData(),
        ]);
    }
}
