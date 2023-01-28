<?php

use App\Http\Controllers\Auth\AuthenticatedTokenController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UsernameController;
use App\Http\Controllers\Auth\VerifyEmailController;

use Illuminate\Support\Facades\Route;

// Registration
Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('email', [EmailController::class, 'show']);
Route::get('username', [UsernameController::class, 'show']);

// Authentication
Route::post('login', [
    AuthenticatedTokenController::class, 'store'
]);

Route::get('user', [AuthenticatedTokenController::class, 'show']);

Route::delete('logout', [
    AuthenticatedTokenController::class, 'destroy'
])->middleware('auth:api');

// Email verification
Route::get('email/verify/{id}/{hash}', [
    VerifyEmailController::class, '__invoke'
])->middleware(['auth:api', 'signed'])
    ->name('verification.verify');

Route::post('email/verification-notification', [
    EmailVerificationNotificationController::class,
    'store'
])->middleware(['auth:api', 'throttle:6,1']);

// Password reset
Route::post('forgot-password', [
    PasswordResetLinkController::class, 'store'
]);

Route::post('reset-password', [
    NewPasswordController::class, 'store'
]);

// Password confirmation 
Route::post('confirm-password', [
    ConfirmablePasswordController::class, 'store'
])->middleware(['auth:api', 'throttle:6,1']);
