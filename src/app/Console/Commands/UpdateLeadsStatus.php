<?php

namespace App\Console\Commands;

use App\Models\Leads;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateLeadsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * This is the command name you will use when running it in the terminal.
     * Example: php artisan leads:auto-update-lead-status
     *
     * @var string
     */
    protected $signature = 'leads:auto-update-lead-status';

    /**
     * The console command description.
     *
     * This description is displayed when you run "php artisan list".
     * It helps other developers understand what this command does.
     *
     * @var string
     */
    protected $description = 'Automatically updates the status of leads that require follow-up';

    /**
     * Execute the console command.
     *
     * This method contains the logic that runs when the command is executed.
     */
    public function handle(): void
    {
        // Fetch all leads with the status "Contacted" from the database.
        $leads = Leads::where('status', 'Contacted')->get();

        // Iterate over each lead that was fetched.
        foreach ($leads as $lead) {
            // Parse the "last_contacted" date of the lead and set it to the start of the day.
            $leadLastContacted = Carbon::parse($lead->last_contacted)->startOfDay();

            // Get the current date and set it to the start of the day.
            $currentDate = Carbon::now()->startOfDay();

            // Check if the number of days since the lead was last contacted exceeds 10.
            if ($leadLastContacted->diffInDays($currentDate) > 10) {
                // Update the lead's status to "Follow-up Required".
                $lead->status = 'Follow-up Required';

                // Set a follow-up date 5 days from now.
                $lead->follow_up_date = Carbon::now()->addDays(10)->toDateString();

                // Save the updated lead back to the database.
                $lead->save();
            }
        }
    }
}
