<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class SendUnreadNotificationsThroughtTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:send-unread-notifications-throught-telegram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send unread notifications throught telegram';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      // get unread notifications by user
        $users = User::all();

        foreach ($users as $user) {
          $unreadNotifications = $user->unreadNotifications()->count();
          $this->sendTelegramMessage($user, $unreadNotifications);
        }
    }

    private function sendTelegramMessage($user, $unreadNotifications)
    {
      Http::post("https://api.telegram.org/bot" . config('services.telegram.bot_key') . "/sendMessage", [
        'chat_id' => $user->telegram_chat_id,
        'text' => "You have $unreadNotifications unread notifications ! \n\n Please check the dashboard to see them.",
      ]);
    }
}
