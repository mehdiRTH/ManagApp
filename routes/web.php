<?php

use App\Http\Controllers\AnnounceController;
use App\Http\Controllers\DailyActivityController;
use App\Http\Controllers\DayOffRequestController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SectionController;
use App\Models\DailyActivity;
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {

    return Inertia::render('Dashboard',[
        'breadcrumbs'=> Breadcrumbs::generate('dashboard')
    ]);
})->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {

    return Inertia::render('Dashboard',[
        'breadcrumbs'=> Breadcrumbs::generate('dashboard')
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Users
    Route::resource('users',UserController::class)->middleware(['role:admin|super admin']);

    //Meetings
    Route::resource('meetings',MeetingController::class);

    //Sections
    Route::resource('sections',SectionController::class)->middleware(['role:admin|super admin']);

    //Holidays
    Route::resource('holidays',HolidayController::class);

    //Off Requests
    Route::resource('off_requests',DayOffRequestController::class);

    //Announces
    Route::resource('announces',AnnounceController::class)->middleware(['role:responsible|admin|super admin']);

    //Daily Activities
    Route::prefix('daily_activities')->group(function(){
        Route::get('',[DailyActivityController::class,'index'])->name('daily_activities.index')->middleware(['role:responsible|admin|HR|super admin']);
        Route::get('/read_qr',[DailyActivityController::class,'readQr'])->name('daily_activities.read_qr');
        Route::get('/{user}',[DailyActivityController::class,'show'])->name('daily_activities.show');
        Route::get('/check_qr/{qr_code}',[DailyActivityController::class,'checkQr'])->name('daily_activities.check_qr');

    });

    //Notifications
    Route::put('read/{notification}', [NotificationController::class,'readNotification'])->name('read.notification');
    Route::delete('delete/{notification}', [NotificationController::class,'deleteNotification'])->name('delete.notification');
});

require __DIR__.'/auth.php';
