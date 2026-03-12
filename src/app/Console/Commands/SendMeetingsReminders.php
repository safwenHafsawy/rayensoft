<?php

namespace App\Console\Commands;

use App\Mail\MeetingReminder;
use App\Models\ExternalMeeting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMeetingsReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meetings:send-meetings-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for meetings';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $meetingsList = [];
        $date = Carbon::today();
        $meetings = ExternalMeeting::whereDate('date', $date)->with('lead')->get();

        if ($meetings->isEmpty()) {
            return;
        }

        foreach ($meetings as $meeting) {
            $meetingsList[] = [
                'title' => $meeting->title,
                'date' => $meeting->date,
                'time' => $meeting->hour,
                'status' => $meeting->status,
                'lead_name' => $meeting->lead->name,
            ];
        }
        
        Mail::to('safwenhafsawy@rayensoft.com')->cc('rihabbenali@rayensoft.com')->send(new MeetingReminder($meetingsList));
    }
}
