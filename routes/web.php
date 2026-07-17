<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\RaceCategoryController;
use App\Http\Controllers\Admin\TicketTierController;
use App\Http\Controllers\FrontEventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;

Route::get('/', [FrontEventController::class, 'index'])->name('home');
Route::get('/event/{id}', [FrontEventController::class, 'show'])->name('front.event.show');
Route::get('/event/{id}/ticket', [CheckoutController::class, 'showTicketPage'])->name('front.checkout.ticket');
Route::post('/event/{id}/checkout-form', [CheckoutController::class, 'showCustomerForm'])->name('front.checkout.form');
Route::get('/event/{id}/checkout-form/{invoice}', [CheckoutController::class, 'renderCustomerForm'])->name('front.checkout.form.get');

// Alur Proses Akhir Form -> Menuju Rute Pembayaran
Route::post('/checkout/process/{invoice}', [CheckoutController::class, 'store'])->name('front.checkout.store');
Route::get('/checkout/payment/{invoice}', [PaymentController::class, 'show'])->name('front.checkout.payment');

// Webhook Otomatis Midtrans & Halaman Sukses
Route::post('/midtrans/notification', [PaymentController::class, 'notification'])->name('midtrans.notification');
Route::get('/checkout/success/{invoice_number}', [CheckoutController::class, 'showSuccessPage'])->name('front.checkout.success');
Route::get('/checkout/invoice/{invoice_number}/download', [CheckoutController::class, 'downloadInvoice'])->name('front.checkout.invoice.download');

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
