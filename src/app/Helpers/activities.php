<?php


use App\Models\RecentActivities as RecentActivity;
use Illuminate\Database\Eloquent\Model;

function log_activity(string $message): void
{
    RecentActivity::create([
        'user_name' => auth()->user()?->name ?? 'System',
        'details' => $message,
    ]);
}
