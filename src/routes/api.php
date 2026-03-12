<?php

use Illuminate\Http\Request;
use App\Http\Controllers\TelegramBotController;
use Illuminate\Support\Facades\Route;


Route::post('telegram/' . config('services.telegram.bot_key'), [TelegramBotController::class, 'handle']);
