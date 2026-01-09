<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index'])->name('index');

// Admin Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $events = Event::paginate(perPage: 10);

        return view('admin.dashboard', compact('events'));
    })->name('dashboard');
    Route::get('/admin/create', [EventController::class, 'create'])->name('create.event');
    Route::post('/admin/create', [EventController::class, 'store'])->name('event.store');

    Route::get('/admin/edit/{event}', [EventController::class, 'edit'])->name('edit.event');
    Route::post('/admin/edit/{event}', [EventController::class, 'update'])->name('event.update');

    Route::delete('/admin/delete/{event}', [EventController::class, 'destroy'])->name('delete.event');

    Route::get('/admin/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
