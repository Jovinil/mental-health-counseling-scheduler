<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentSessionController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\CounselorAppointmentController;
use App\Http\Controllers\CounselorAvailabilityController;
use App\Http\Controllers\CounselorDashboardController;
use App\Http\Controllers\CounselorAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserAuthController;

use App\Http\Middleware\IsUserMiddleware;
use App\Http\Middleware\IsCounselorMiddleware;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/user-register', [UserAuthController::class, 'showRegistrationForm'])
    ->name('user.register');
Route::post('/user-register', [UserAuthController::class, 'register'])
    ->name('user.register.store');

Route::get('/user-login', [UserAuthController::class, 'showLoginForm'])->name('user.login');
route::post('/user-login', [UserAuthController::class, 'authenticate'])->name('user.login.authenticate');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

route::post('/counselor-login', [CounselorAuthController::class, 'authenticate'])->name('counselor.login.authenticate');
Route::get('/counselor-login', [CounselorAuthController::class, 'showLoginForm'])->name('counselor.login');
Route::post('/counselor-logout', [CounselorAuthController::class, 'logout'])->name('counselor.logout');

Route::get('/counselor-register', [CounselorAuthController::class, 'showRegistrationForm'])
    ->name('counselor.register');
Route::post('/counselor-register', [CounselorAuthController::class, 'register'])
    ->name('counselor.register.store');

Route::get('/counselors', [HomeController::class, 'counselors'])->name('counselors.index');
Route::get('/counselors/{counselor}', [HomeController::class, 'showCounselor'])->name('counselors.show');

Route::middleware('is.user')->group(function (){

    Route::get('/user', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/user/bookings', [BookingsController::class, 'index'])->name('user.bookings');

    Route::get('/counselor/{id}/availability', [AppointmentController::class, 'getAvailability']);

    // Booking form
    Route::get('/book', [AppointmentController::class, 'create'])
        ->name('appointments.create');

    // Store new appointment
    Route::post('/book', [AppointmentController::class, 'store'])
        ->name('appointments.store');

    // User's appointments list
    Route::get('/user-appointments', [AppointmentController::class, 'index'])
        ->name('appointments.index');

    // Show a single appointment (optional)
    Route::get('/user-appointments/{appointment}', [AppointmentController::class, 'show'])
        ->name('appointments.show');

    // User reschedule or cancel
    Route::put('/user-appointments/{appointment}', [AppointmentController::class, 'update'])
        ->name('appointments.update');
    Route::delete('/user-appointments/{appointment}', [AppointmentController::class, 'destroy'])
        ->name('appointments.destroy');

    // AJAX: get available slots for a counselor on a date
    Route::get('/api/counselors/{counselor}/available-slots', [CounselorAvailabilityController::class, 'availableSlots'])
        ->name('counselors.available-slots');

});

Route::middleware('is.counselor')->group(function (){

    // Route::get('/counselor', function () {
    //     return view('pages.counselor.index');
    // });

    // Dashboard
    Route::get('/counselor', [CounselorDashboardController::class, 'index'])
        ->name('counselor.dashboard');

    // List all appointments for counselor
    Route::get('/counselor-appointments', [CounselorAppointmentController::class, 'index'])
        ->name('counselor.appointments.index');

    // Today’s appointments
    Route::get('/counselor-appointments/today', [CounselorAppointmentController::class, 'today'])
        ->name('counselor.appointments.today');
    // Update appointment status (confirmed, completed, cancelled)
    Route::put('/counselor-appointments/{appointment}', [CounselorAppointmentController::class, 'update'])
        ->name('counselor.appointments.update');

    // Counselor availability CRUD
    Route::get('/counselor-availability', [CounselorAvailabilityController::class, 'index'])
        ->name('counselor.availability.index');
    Route::get('/counselor-availability/create', [CounselorAvailabilityController::class, 'create'])
        ->name('counselor.availability.create');
    Route::post('/counselor-availability', [CounselorAvailabilityController::class, 'store'])
        ->name('counselor.availability.store');
    Route::delete('/counselor-availability/{availability}', [CounselorAvailabilityController::class, 'destroy'])
        ->name('counselor.availability.destroy');

});
