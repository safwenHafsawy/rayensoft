<?php

namespace App\Livewire\Main;

use App\Models\Client;
use App\Models\ExternalMeeting;
use App\Models\Leads;
use App\Models\Meeting;
use App\Models\Project;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Overview extends Component
{
    public array $projects = [];
    public array $invoices = [];
    public array $leads = [];
    public array $expenses = [];
    public array $payments = [];

    public array $meetings = [];

    protected function getProjectData(): array
    {
        $ongoing = Project::where('status', 'Ongoing')->count();
        $completed = Project::where('status', 'completed')->count();

        $currentMonth = Project::where('created_at', '>=', now()->subDays(30))->count();
        $previousMonth = Project::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();

        return [
            'ongoing' => $ongoing,
            'completed' => $completed,
            'projects_monthly_change' => calculateChange($currentMonth, $previousMonth),
        ];
    }

//    protected function getMonthlyIncome(): array
//    {
//        $pendingInvoices = Invoice::where('status', 'Pending')->count();
//        $monthlyInvoices = Invoice::where('created_at', '>=', now()->subDays(30))->count();
//        $previousInvoices = Invoice::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
//
//        return [
//            'pending_invoices' => $pendingInvoices,
//            'monthly_invoices' => $monthlyInvoices,
//            'monthly_invoice_change' => calculateChange($monthlyInvoices, $previousInvoices),
//        ];
//    }

    protected function getLeadsClientsData(): array
    {
        $totalClients = Client::count();
        $clientsThisMonth = Client::where('created_at', '>=', now()->subDays(30))->count();
        $clientsPreviousMonth = Client::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
        $clientsMonthlyChange = calculateChange($clientsThisMonth, $clientsPreviousMonth);

        $pendingFollowUps = Leads::where('status', 'Follow-up Required')->count();
        $leadsThisWeek = Leads::where('created_at', '>=', now()->subDays(7))->count();
        $leadsPreviousWeek = Leads::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $leadsWeeklyChange = calculateChange($leadsThisWeek, $leadsPreviousWeek);

        return [
            'total_clients' => $totalClients,
            'clients_this_month' => $clientsThisMonth,
            'clients_monthly_change' => $clientsMonthlyChange,
            'pending_follow_ups' => $pendingFollowUps,
            'leads_this_week' => $leadsThisWeek,
            'leads_previous_week' => $leadsPreviousWeek,
            'leads_weekly_change' => $leadsWeeklyChange,
        ];
    }

    protected function getMeetingsData(): array {
        $weeklyMeetings = ExternalMeeting::where('date', '>=', now()->subDays(7))->count();

        $prevWeekMeetings = ExternalMeeting::whereBetween('date', [
            now()->subDays(14),
            now()->subDays(7)
        ])->count();

        return [
            'weekly_meetings' => $weeklyMeetings,
            'weekly_meetings_change' => calculateChange($weeklyMeetings, $prevWeekMeetings),
        ];
    }


    public function mount(): void
    {
        $this->projects = $this->getProjectData();
        // $this->invoices = $this->getMonthlyIncome();
        $this->leads = $this->getLeadsClientsData();
        $this->meetings = $this->getMeetingsData();
    }
    public function render(): Factory|View
    {
        return view('livewire.main.overview');
    }
}
