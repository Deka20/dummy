<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListBarangController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [HomeController::class, 'show'])->name('index');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// });

Route::get('/listbarang', [ListBarangController::class, 'tampilkan']);

// Registrasi
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/bookings/create', [BookingController::class, 'showBookingForm'])->name('bookings.form');
Route::post('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/studios', [DashboardController::class, 'studios'])->name('dashboard.studios');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard.index');
});

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/create', [StudioController::class, 'create'])->name('create');
    Route::get('/customers', [DashboardController::class, 'customers'])->name('customers');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/store', [StudioController::class, 'store'])->name('store');
    Route::get('/{studio}/edit', [StudioController::class, 'edit'])->name('edit');
    Route::put('/{studio}', [StudioController::class, 'update'])->name('update');
    Route::delete('/{studio}', [StudioController::class, 'destroy'])->name('destroy');
});

Route::put('/bookings/{booking}/status', [BookingController::class, 'updateStatus']);

// Route::prefix('dashboard/customers')->name('dashboard.customers.')->group(function () {
Route::get('/customers/{user}/edit', [CustomerController::class, 'edit'])->name('dashboard.customers.edit');
Route::put('/customers/{user}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customers/{user}', [CustomerController::class, 'destroy'])->name('dashboard.customers.destroy');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('settings')->group(function () {
        // GET Routes (Menampilkan Halaman)
        // Route::get('/', [SettingsController::class, 'index'])->name('settings');
        Route::get('/security', [SettingsController::class, 'security'])->name('settings.security');
        Route::get('/preferences', [SettingsController::class, 'preferences'])->name('settings.preferences');
        Route::get('/notifications', [SettingsController::class, 'notifications'])->name('settings.notifications');

        // Route untuk memproses update password (POST)
        Route::post('/security/update', [SettingsController::class, 'updatePassword'])->name('settings.security.update');
    });
});

// routes/web.php
Route::post('/set-theme', function (\Illuminate\Http\Request $request) {
    $request->validate(['theme' => 'in:light,dark,cupcake,synthwave']);
    session(['theme' => $request->theme]);
    return response()->json(['status' => 'ok']);
})->name('set.theme');

// web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/purchase-history', [BookingController::class, 'purchaseHistory'])->name('purchase.history');
    Route::get('/purchase/{id}', [BookingController::class, 'purchaseDetail'])->name('purchase.detail');

    // routes/web.php
    // routes/web.php
    Route::post('/bookings/{id}/request-cancel', [BookingController::class, 'requestCancel'])->middleware('auth')->name('bookings.request-cancel');
});

Route::post('/bookings/{booking}/submit-review', [BookingController::class, 'submitReview'])->name('bookings.submit-review');
Route::put('/bookings/{booking}', [BookingController::class, 'updateBooking'])->name('bookings.update');

// routes/web.php
Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('show')->middleware('auth');

Route::put('/reviews/{booking}', [BookingController::class, 'update'])->name('reviews.update')->middleware('auth');
Route::delete('/reviews/{booking}', [BookingController::class, 'destroy'])->name('reviews.destroy')->middleware('auth');

Route::get('/dashboard/portfolio', [DashboardController::class, 'settings'])->name('dashboard.settings');

// Portfolio management routes
Route::post('/dashboard/portfolio/save', [DashboardController::class, 'save'])->name('dashboard.portfolio.save');
Route::delete('/dashboard/portfolio/delete/{id}', [DashboardController::class, 'delete'])->name('dashboard.portfolio.delete');
Route::post('/dashboard/portfolio/update-order', [DashboardController::class, 'updateOrder'])->name('dashboard.portfolio.update-order');

Route::post('/bookings/{booking}/upload-payment', [BookingController::class, 'uploadPayment'])
    ->name('bookings.upload-payment');


Route::get('/dashboard/payments', [DashboardController::class, 'payments'])
    ->name('dashboard.payments');

Route::post('/dashboard/payments/{booking}/verify', [DashboardController::class, 'verifyPayment'])
    ->name('dashboard.payments.verify');

Route::post('/dashboard/payments/{booking}/reject', [DashboardController::class, 'rejectPayment'])
    ->name('dashboard.payments.reject');

    Route::get('/dashboard/earnings', [DashboardController::class, 'earnings'])->name('dashboard.earnings');