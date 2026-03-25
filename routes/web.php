<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Middleware\EnsureSystemIsUninitialized;

Route::get('/', function () {
    return view('welcome');
});

// Admin Initialization
Route::middleware([EnsureSystemIsUninitialized::class])->group(function () {
    Route::get('/create-admin', [AuthController::class, 'showCreateAdmin'])->name('admin.create');
    Route::post('/create-admin', [AuthController::class, 'createAdmin']);
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');

    Route::resource('members', MemberController::class);

    Route::resource('trainers', \App\Http\Controllers\TrainerController::class);

    Route::resource('classes', \App\Http\Controllers\GymClassController::class);

    Route::get('/receipt', function () {
        return view('receipt');
    })->name('receipt');

    Route::resource('payments', \App\Http\Controllers\PaymentController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});