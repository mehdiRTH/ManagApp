<?php

use App\Http\Controllers\AnnounceController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SectionController;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $breadcrum=Breadcrumbs::render('dashboard');
    return Inertia::render('Dashboard',[
        'breadcrumbs'=> $breadcrum->breadcrumbs
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

    //Announces
    Route::resource('announces',AnnounceController::class)->middleware(['role:responsible|admin|super admin']);


    //Notifications
    Route::put('read/{notification}', [NotificationController::class,'readNotification'])->name('read.notification');
    Route::delete('delete/{notification}', [NotificationController::class,'deleteNotification'])->name('delete.notification');
});

require __DIR__.'/auth.php';
