<?php

namespace App\Console\Commands;

use App\Models\PushSubscription;
use App\Models\WorkSession;
use App\Models\WorkSessionBreaks;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class sendFocusCheckNotifications extends Command
{
    public array $sessionsToNotify = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work-session:send-focus-check-in-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command is used to send random check-in during active work sessions';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::info('starting the check process');
        // Retrieve all active work sessions from the database
        $activeSessions = WorkSession::where('status', 'active')->get();


        // Define minimum and maximum cooldown periods (in minutes) for checking sessions
        $minCooldown = 15; // Minimum time before a session can be checked again
        $maxCooldown = 35; // Maximum time before a session can be checked again


        foreach ($activeSessions as $session) {

            // Calculate how many minutes have passed since the session was last checked
            $minutesSinceLastChecked = abs(now()->diffInMinutes($session->last_check_at));
            // Generate a random cooldown period for this specific session
            $randomCooldown = rand($minCooldown, $maxCooldown);

            // Check if enough time has passed since the last check
            if ($minutesSinceLastChecked >= $randomCooldown) {
                $this->sessionsToNotify[] = $session;
            }
        }

        $this->sendPushNotification();

    }

    public function sendPushNotification(): void {

        if(empty($this->sessionsToNotify)) {
            Log::info('No Sessions Will Be Notified');
            return;
        }

        $auth = [
            'VAPID' => [
                'subject' => 'mailto:error@rayensoft.com',
                'publicKey' => trim(config('services.vapid.public_key')),
                'privateKey' => trim(config('services.vapid.private_key')),
            ]
        ];

        $webPush = new WebPush($auth);

        // Preload subscriptions for selected sessions
        $userIds = collect($this->sessionsToNotify)->pluck('user_id');
        $subscriptions = PushSubscription::whereIn('user_id', $userIds)
            ->get()
            ->keyBy('user_id');

        foreach($this->sessionsToNotify as $session) {
            $subModel = $subscriptions[$session->user_id] ?? null;

            if (!$subModel) continue;

            // Convert to WebPush Subscription object
            $subscription = Subscription::create([
                'endpoint' => $subModel->endpoint,
                'keys' => json_decode($subModel->keys, true),
            ]);

            $payload = json_encode([
                'title' => 'Focus Check-in 🌟',
                'body' => 'Are you still at your desk '. $session->user->name .'? Click to confirm! 🖱️',
                'workSessionId' => $session->id,
                'actions' => [
                    [
                        'action' => 'confirm',       // internal identifier
                        'title' => 'I\'m Here! ✅'   // text shown on the button
                    ],
                ]
            ]);

            $webPush->queueNotification($subscription, $payload);

            $session->update(['last_check_at' => now(), 'notification_confirmed' => false]);
        }

        // Send all queued notifications
        $reports = $webPush->flush();

        foreach ($reports as $report) {
            if (!$report->isSuccess()) {
                Log::info('Could Not Send Notification');
                PushSubscription::where('endpoint', $report->getRequest()->getUri())->delete();
            } else {
                Log::info('Notification sent successful');
            }
        }
    }
}
