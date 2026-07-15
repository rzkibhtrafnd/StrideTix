<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\RaceCategoryController;
use App\Http\Controllers\Admin\TicketTierController;
use App\Http\Controllers\FrontEventController;

Route::get('/', [FrontEventController::class, 'index'])->name('home');
Route::get('/event/{id}', [FrontEventController::class, 'show'])->name('front.event.show');

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('organizers', OrganizerController::class);
        Route::resource('events', EventController::class);
        Route::resource('race-categories', RaceCategoryController::class);
        Route::resource('ticket-tiers', TicketTierController::class);
    });

    Route::prefix('organizer')->name('organizer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('organizer.dashboard');
        })->name('dashboard');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
