<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Profile\SecurityController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // Profile Route
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/security', [SecurityController::class, 'index'])->name('profile.security');

    // Admin Rute
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::patch('/users/{user}/reset-password', [UserController::class, 'forceResetPassword'])->name('users.reset-password');
        Route::resource('users', UserController::class);
    });
});
