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

Route::get('/', [FrontEventController::class, 'index'])->name('home');
Route::get('/event/{id}', [FrontEventController::class, 'show'])->name('front.event.show');
// 1. Halaman Pilih Tiket (Awal)
Route::get('/event/{id}/ticket', [CheckoutController::class, 'showTicketPage'])
    ->name('front.checkout.ticket');

// 2. Aksi POST dari form tiket untuk memotong stok pertama kali
Route::post('/event/{id}/checkout-form', [CheckoutController::class, 'showCustomerForm'])
    ->name('front.checkout.form');

// 3. PERBAIKAN UTAMA: Tambahkan parameter {invoice} pada rute GET pendaratan form data diri
Route::get('/event/{id}/checkout-form/{invoice}', [CheckoutController::class, 'renderCustomerForm'])
    ->name('front.checkout.form.get');

// 4. Proses simpan akhir data pelari saat klik "Bayar Sekarang"
Route::post('/checkout/process/{invoice}', [CheckoutController::class, 'store'])
    ->name('front.checkout.store');

// 5. Halaman Sukses Pembelian
Route::get('/checkout/success/{invoice_number}', [CheckoutController::class, 'showSuccessPage'])
    ->name('front.checkout.success');

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
