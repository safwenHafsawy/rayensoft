<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('work-session:send-focus-check-in-notification')->everyFifteenMinutes();
Schedule::command('work-sessions:pause-unchecked')->EveryFiveMinutes();
Schedule::command('notification:send-unread-notifications-throught-telegram')->everyFifteenMinutes()->unlessBetween('00:00', '08:00');

Schedule::command('leads:auto-update-lead-status')->dailyAt('04:00');

Schedule::command('leads:send-follow-up-lead-reminder')->dailyAt('04:30');

Schedule::command('meetings:send-meetings-reminders')->dailyAt('05:00');

Schedule::command('work-sessions:generate-daily-report dailyReport')->dailyAt('03:30');

Schedule::command('app:update-goals-status')->weeklyOn(1, '00:00');

Schedule::command('app:insert-available-times Next')->monthlyOn(20, '00:00');
