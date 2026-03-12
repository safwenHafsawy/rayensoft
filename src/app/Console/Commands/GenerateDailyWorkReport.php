<?php

namespace App\Console\Commands;

use App\Mail\SendDailyReport;
use App\Models\User;
use App\Models\WorkSession;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class GenerateDailyWorkReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work-sessions:generate-daily-report {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and send daily work session report as PDF via email';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $pdfPaths = [];

        // $users = User::all();

        $yesterday = Carbon::yesterday()->toDateString();

        $workSessionsData = WorkSession::with('goals') // eager load avoids duplicates
        ->where('status', 'completed')
            ->whereDate('check_out_time', $yesterday)
            ->get()
            ->groupBy('user_id');

        foreach ($workSessionsData as $userId => $sessions) {
            $user = User::find($userId);
            $userSessionData = [];

            // Remove duplicate sessions based on 'id'
            $uniqueSessions = $sessions->unique('id');

            // Log::info('User: ' . $user->name);
            // Log::info('Total Work Sessions: ' . $uniqueSessions->count());

            $totalWorkedTime = $uniqueSessions->sum(function ($session) {
                return $session->total_worked_time;
            });

            // Log::info('Total Worked Time: ' . $totalWorkedTime . ' minutes');

            foreach ($uniqueSessions as $session) {
                $userSessionData[] = [
                    'id' => $session->id,
                    'check_in_time' => $session->check_in_time,
                    'check_out_time' => $session->check_out_time,
                    'summary' => $session->summary,
                    'goals' => $session->goals->map(function ($goal) {
                        return [
                            'id' => $goal->id,
                            'title' => $goal->title,
                        ];
                    })->toArray(),
                ];

            }

            $data = [
                'title' => 'Work Session Summary Report',
                'content' => [
                    'totalWorkTime' => $totalWorkedTime,
                    'numberWorkSessions' => $uniqueSessions->count(),
                    '' => $user->name,
                    'workSessions' => $userSessionData,
                    'date' => now()->toDateString(),
                ],
            ];

            // Generate the PDF using a Blade view
            $pdf = PDF::loadView('pdf.daily_work_report', ['data' => $data]);

            // Ensure the storage folder exists
            if (!Storage::exists('public')) {
                Storage::makeDirectory('public');
            }

            $relativePath = "public/daily_report_{$user->name}.pdf";
            Storage::put($relativePath, $pdf->output());

            $fullPath = storage_path("app/" . $relativePath);
            $pdfPaths[] = $fullPath;

        }

        Mail::to('safwenhafsawy@rayensoft.com')->cc('rihabbenali@rayensoft.com')->send(new SendDailyReport($pdfPaths));

        $this->info('Daily report has been sent successfully');

        // Delete the temporary PDF files
        foreach ($pdfPaths as $pdfPath) {
            if (file_exists($pdfPath)) {
                unlink($pdfPath); // Deletes the file
            }
        }

        $this->info('Temporary PDF files have been deleted');
    }
}
