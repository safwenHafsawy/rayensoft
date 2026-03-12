<?php

namespace App\Console\Commands;

use App\Mail\FollowUpLeadReminder;
use App\Models\Leads;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class sendFollowUpReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leads:send-follow-up-lead-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to users before lead follow-up dates';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $reminderDate = Carbon::now()->startOfDay();

        // Retrieve leads with their 'found_by' relationship
        $leads = Leads::with('found_by')
            ->whereDate('follow_up_date', $reminderDate)
            ->where('status', 'Follow-up Required')
            ->get();

        // Group leads by 'found_by' user email
        $groupedLeads = $leads->groupBy(function ($lead) {
            return $lead->found_by->email; // Ensure the 'found_by' exists
        });

        foreach ($groupedLeads as $founder_mail => $groupedLead) {
            // Extract founder's name from the first lead in the group
            $firstLead = $groupedLead->first(); // Get the first lead in the group
            $founderName = $firstLead->found_by->name;

            $leadsToRemind = $groupedLead->filter(function ($lead) use ($reminderDate) {
                $followUpDate = Carbon::parse($lead->follow_up_date)->startOfDay();
                return $followUpDate->diffInDays($reminderDate) == 0 && $lead->status === 'Follow-up Required';
            });

            if ($leadsToRemind->isNotEmpty()) {
                Mail::to($founder_mail)->send(new FollowUpLeadReminder($leadsToRemind,$founderName));
            }
        }

        return 0;
    }
}
