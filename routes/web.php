<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [EventController::class, 'index'])->name('index');
Route::get('/register', [RegisterationController::class, 'create'])->name('register');
Route::post('/register', [RegisterationController::class, 'store'])->name('register.store');
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [EventController::class, 'dashboard'])->name('dashboard');

    // Event Management
    Route::controller(EventController::class)->prefix('events')->name('event.')->group(function () {
        Route::get('/', 'adminIndex')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{event}/edit', 'edit')->name('edit');
        Route::put('/{event}', 'update')->name('update');
        Route::delete('/{event}', 'destroy')->name('delete');
    });

    // Registration Management
    Route::controller(RegisterationController::class)->prefix('registerations')->name('registerations.')->group(function () {
        Route::get('/event/{event}', 'index')->name('index');
        Route::patch('/{registeration}/payment-status', 'updatePaymentStatus')->name('update-payment');
        Route::patch('/{registeration}/cancel', 'cancel')->name('cancel');
    });

    // Profile Management
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});

require __DIR__.'/auth.php';
