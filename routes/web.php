<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Master\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard-analytics');
})->name('dashboard-analytics');

Route::get('/report', function () {
    return view('dashboard-ecommerce');
})->name('dashboard-ecommerce');

Route::get('/calendar', function () {
    return view('ticketing');
})->name('calendar');

Route::post('/calendar/store', [CalendarController::class, 'store'])->name('calendar.store');
Route::resource('/customers', CustomerController::class)->name('index', 'customers.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
