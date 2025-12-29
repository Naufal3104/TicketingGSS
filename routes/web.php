<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Master\CustomerController;
use App\Http\Controllers\CustomerService\UserController;
use App\Http\Controllers\TechnicalSupport\TicketController;
use App\Http\Controllers\TechnicalSupport\AssignmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});



Route::get('/calendar', function () {
    return view('ticketing');
})->name('calendar');

Route::post('/calendar/store', [CalendarController::class, 'store'])->name('calendar.store');


Route::get('/dashboard', function () {
    return view('dashboard-analytics');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Admin & CS Group (Master Data & User Management)
    Route::group(['middleware' => ['role:Admin|CS']], function () {
        Route::resource('users', UserController::class);
        Route::resource('customers', CustomerController::class)->name('index', 'customers.index');
        Route::get('/report', [App\Http\Controllers\CustomerService\ReportController::class, 'index'])->name('dashboard-ecommerce');
    });

    // Technical Support Group (Operational)
    Route::group(['middleware' => ['role:TS|Admin|CS']], function () {
        Route::resource('tickets', TicketController::class);
        Route::get('/assignments/open', [AssignmentController::class, 'index'])->name('assignments.open');
        Route::post('/assignments/take', [AssignmentController::class, 'takeJob'])->name('assignments.take');
        Route::get('/assignments/{ticket}', [AssignmentController::class, 'show'])->name('assignments.show');
        Route::get('/monitoring', [App\Http\Controllers\TechnicalSupport\MonitoringController::class, 'index'])->name('monitoring.index');

        // Attendance
        Route::post('/attendance/check-in', [App\Http\Controllers\TechnicalSupport\AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
        Route::post('/attendance/check-out', [App\Http\Controllers\TechnicalSupport\AttendanceController::class, 'checkOut'])->name('attendance.checkOut');

        // Documents
        Route::post('/documents/upload', [App\Http\Controllers\TechnicalSupport\DocumentController::class, 'upload'])->name('documents.upload');
        Route::get('/documents/{ticket}/surat-tugas', [App\Http\Controllers\TechnicalSupport\DocumentController::class, 'downloadSuratTugas'])->name('documents.surat-tugas');
    });

    // Sales Group (Finance)
    Route::group(['middleware' => ['role:Sales|Admin|CS']], function () {
        Route::resource('invoices', App\Http\Controllers\Sales\InvoiceController::class);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
