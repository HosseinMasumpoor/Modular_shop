<?php

use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\V1\AuthController;
use Modules\User\Http\Controllers\V1\UserController;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('verify-code', [AuthController::class, 'verifyOTP']);
    });
});

Route::middleware(['auth:user'])->prefix('v1')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('me', [UserController::class, 'me']);
        Route::post('complete-profile', [UserController::class, 'completeProfile']);
        Route::post('set-password-otp', [UserController::class, 'setPasswordOTP']);
        Route::post('set-password', [UserController::class, 'setPassword']);
        Route::post('change-password', [UserController::class, 'changePassword']);
        Route::post('change-email', [UserController::class, 'changeEmail']);
    });
});
Route::get('/user/change-email-verify', [UserController::class, 'changeEmailVerify'])->name('user.email.verify');

