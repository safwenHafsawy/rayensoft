<?php

namespace App\Services;

use App\Models\WorkSession;
use App\Models\WorkSessionBreaks;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class WorkSessionService {
    public function confirmFocus($workSessionId) {
        $workSession = WorkSession::find($workSessionId);

        if($workSession && $workSession->status === 'active') {
            $workSession->notification_confirmed = true;
            $workSession->save();
        }else if ($workSession && $workSession->status === 'paused') {
            // end the break
            WorkSessionBreaks::where('work_session_id', $workSession->id)
                ->whereNull('ended_at')
                ->update(['ended_at' => now()]);

            $workSession->notification_confirmed = true;
            $workSession->status = 'active';
            $workSession->save();
        }
    }

    public function pauseSession ($workSession) {
        $workSession->update(['status' => 'paused']);

        $workSession->refresh();
        $break =  WorkSessionBreaks::create([
            'work_session_id' => $workSession->id,
            'started_at' => now(),
        ]);

        return $break;

    }

    public function autoPauseSessions(): void
    {
        // Select sessions that are active and notification not confirmed
        $sessions = WorkSession::where('status', 'active')
            ->with('user')
            ->where('notification_confirmed', false)
            ->get();

        foreach ($sessions as $session) {

            if (abs(Carbon::now()->diffInMinutes($session->last_check_at)) >= 5) {
                Log::info('Session went over the limit');
                $this->pauseSession($session);

                // log the activity
                log_activity(' A session was pause due to inactivity at ' . now()->format('H:i:s'));
            }

        }
    }

    public function sessionCheckOut ($workSession, $workSessionBreak, $summaryData, $totalWorkedTime) {

        if ($workSession) {
            if ($workSession->status === 'paused') {
                $pauseTime = $workSessionBreak->started_at;
                $workSessionBreak = WorkSessionBreaks::where('work_session_id', $workSession->id)
                    ->where('ended_at', null)
                    ->first();
                $workSessionBreak->update([
                    'ended_at' => $pauseTime,
                ]);
            }
            $workSession->update([
                'check_out_time' => now(),
                'status' => 'completed',
                'summary' => $summaryData['summary'],
                'total_worked_time' => $totalWorkedTime,
            ]);


            $workSession->refresh();
            // create a new record in pivot table goal_work_session
            $workSession->goals()->attach($summaryData['goalsWorkedOn']);
        }

        $workSession = null;

        // Log the activity
        log_activity(auth()->user()->name . ' has finished a work session at ' . now()->format('H:i:s'));

        return [$workSession, $workSessionBreak];
    }
}

