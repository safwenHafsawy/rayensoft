<?php

namespace App\Console\Commands;

use App\Models\Goal;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateGoalsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-goals-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command is used to auto update the goals status at the end of evey week';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Fetch all goals
        $goals = Goal::all();

        foreach($goals as $goal) {
            $goal_end_date = Carbon::parse($goal->end_date);
            if($goal_end_date->isPast()) {
                if($goal->status === 'Pending' || $goal->status === 'In Progress') {
                    $goal->status = 'Failed';
                }
            }

            // if($goal_end_date->isTomorrow()) {

            // }

            if ($goal->isDirty()) {
                $goal->save();
            }

        }
    }
}
