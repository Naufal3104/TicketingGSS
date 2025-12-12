<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Master\CustomerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Operational\TicketController;
use App\Http\Controllers\Operational\AssignmentController;
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
    Route::resource('users', UserController::class);

    // Operational Routes
    Route::resource('tickets', TicketController::class);
    Route::get('/assignments/open', [AssignmentController::class, 'index'])->name('assignments.open');
    Route::post('/assignments/take', [AssignmentController::class, 'takeJob'])->name('assignments.take');
    Route::get('/assignments/{ticket}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('/monitoring', [App\Http\Controllers\Operational\MonitoringController::class, 'index'])->name('monitoring.index');

    // Attendance
    Route::post('/attendance/check-in', [App\Http\Controllers\Operational\AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
    Route::post('/attendance/check-out', [App\Http\Controllers\Operational\AttendanceController::class, 'checkOut'])->name('attendance.checkOut');

    // Documents
    Route::post('/documents/upload', [App\Http\Controllers\Operational\DocumentController::class, 'upload'])->name('documents.upload');
    Route::get('/documents/{ticket}/surat-tugas', [App\Http\Controllers\Operational\DocumentController::class, 'downloadSuratTugas'])->name('documents.surat-tugas');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
