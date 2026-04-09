<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Events routes
    Route::resource('events', \App\Http\Controllers\EventController::class);

    // Registration route with Rate Limiting (Measure 3 of US33)
    Route::post('/events/{event}/toggle-registration', [\App\Http\Controllers\RegistrationController::class, 'toggle'])
        ->middleware('throttle:5,1')
        ->name('events.register.toggle');
});

require __DIR__.'/auth.php';
