<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;
use Spatie\Holidays\Holidays;

use function Symfony\Component\Clock\now;

class InsertAvailableMeetingTimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insert-available-times {month? : Current or Next}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert new available times for booking';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $times = ['09:00', '10:00', '11:00', '12:00'];
        $restDays = [
            \Carbon\Carbon::SATURDAY,
            \Carbon\Carbon::SUNDAY,
        ];
        $holidayChecker = Holidays::for('tn');
        $records = [];

        $month = $this->argument('month')
            ?? $this->choice('Current Or Next Month ?', ['Current', 'Next'], 1);
        $monthStart = $month === 'Next' ? Carbon::now()->startOfMonth()->addMonth() : Carbon::now()->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();
        $period = CarbonPeriod::create($monthStart, $monthEnd);

        foreach ($period as $day) {

            if (in_array($day->dayOfWeek, $restDays)) {
                \Log::info($day->toDateString());
                continue;
            }

            if ($holidayChecker->isHoliday($day)) {
                \Log::info("Skipping $day beacuse its a holiday");
                continue;
            }

            $currentDate = $day->toDateString(); // 'Y-m-d'

            foreach ($times as $time) {
                $records[] = [
                    'date' => $currentDate,
                    'time' => $time,
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // insert records 
        try {
            $insertedCount = DB::table('availble_meeting_dates')->insertOrIgnore($records);

            if ($insertedCount === 0 && count($records) > 0) {
                $this->warn("No new slots were inserted (all dates were likely duplicates).");
            } else {
                $this->info("Successfully inserted $insertedCount new slots.");
            }
        } catch (\Throwable $e) {
            Log::critical("System error: " . $e->getMessage());
            $this->error("An unexpected error occurred.");
            return Command::FAILURE;
        }
    }
}
