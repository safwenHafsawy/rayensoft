<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PushSubscriptionController;
use App\Http\Controllers\TelegramBotController;
use App\Http\Controllers\WorkSessionController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\Site\BlogController;
use App\Models\Leads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('site.welcome');
})->name('welcome');

Route::get('/services', fn () => view('site.services'))->name('services');
Route::get('/about', fn () => view('site.about'))->name('about');
Route::get('/portfolio', fn () => view('site.portfolio'))->name('portfolio');
Route::get('/contact', fn () => view('site.contact'))->name('contact');
Route::get('/book', fn () => view('site.book'))->name('book');

// Blog (public site)
Route::get('/blog', [BlogController::class, 'showBlog'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'showArticle'])->name('blog.singleArticle');
Route::get('/blog/next-article/{index}', [BlogController::class, 'nextArticle'])->name('blog.nextArticle');
Route::get('/blog/prev-article/{index}', [BlogController::class, 'previousArticle'])->name('blog.previousArticle');


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard/projects', function () {
        return view('projects');
    })->name('projects');

    Route::get('/dashboard/client-management', fn() => view('client-management/index'))->name('client-management');

    Route::get('/dashboard/leads/{lead}', fn(Leads $lead) => view('client-management/lead-info', ['lead' => $lead]))->name('lead-info');
    Route::get('/dashboard/team-management', fn() => view('team-management/index'))->name('team-management');

    Route::get('/dashboard/finances', fn() => view('finances/index'))->name('finances');

    Route::get('/dashboard/messages', [MessagesController::class, 'index'])->name('messages');
    Route::get('/dashboard/messages/{message}', [MessagesController::class, 'details'])->name('messages.details');

    Route::get('/dashboard/meetings', fn() => view('meetings'))->name('meetings');

    Route::get('/dashboard/performance', fn() => view('performance'))->name('performance');

    Route::get('/dashboard/blog', fn() => view('blog'))->name('dashboard.blog');


    // Notifications
    Route::get('/api/notifications', function () {
        return response()->json([
            'notifications' => auth()->user()->unreadNotifications()->take(10)->get(),
            'unreadCount' => auth()->user()->unreadNotifications()->count()
        ]);
    });

    Route::post('/api/notifications/{id}/read', function ($id) {
        auth()->user()->notifications()->findOrFail($id)->markAsRead();
        return response()->json(['success' => true]);
    });

    Route::post('/api/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    });

    // profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/api/fetch-vapid-public-key', [PushSubscriptionController::class, 'fetchPublicKey']);


Route::post('/api/store-subscription', [PushSubscriptionController::class, 'store']);

Route::put('/api/confirm-focus', [WorkSessionController::class, 'confirmFocus']);

require __DIR__ . '/auth.php';
