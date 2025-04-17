<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\v1\AdminController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::prefix('v1/admin')->group(function () {
    Route::post('login', [AdminController::class, "loginAdmin"]);
    Route::get('/', [AdminController::class, 'index'])->name('index');

    /**
     * Admin panel routes
     */
    Route::middleware(['auth:admin'])->group(function () {
        Route::apiResource('admin', AdminController::class)->names('admin');
        Route::put('adminRoles/{admin}', [AdminController::class, "setRole"]);
    });
});

