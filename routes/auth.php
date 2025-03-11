<?php

use App\Http\Controllers\App\Auth\AuthenticatedSessionController;
use App\Http\Controllers\App\Auth\ConfirmablePasswordController;
use App\Http\Controllers\App\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\App\Auth\EmailVerificationPromptController;
use App\Http\Controllers\App\Auth\NewPasswordController;
use App\Http\Controllers\App\Auth\PasswordController;
use App\Http\Controllers\App\Auth\PasswordResetLinkController;
use App\Http\Controllers\App\Auth\RegisteredUserController;
use App\Http\Controllers\App\Auth\VerifyEmailController;
use App\Http\Controllers\App\LoginController;
use App\Http\Controllers\App\ProfileController;
use Illuminate\Support\Facades\Route;

//==== not logged in ====
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    //ToDo
    //Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    //Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    //Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    //Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

//==== logged in ====
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    //ToDo
    //Route::get('/verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    //Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    //Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    //Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    //Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);
    //Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
});
