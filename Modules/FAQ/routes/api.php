<?php

use Illuminate\Support\Facades\Route;
use Modules\FAQ\Http\Controllers\v1\FAQController;

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

Route::prefix('v1')->group(function () {


    /**
     * Admin panel routes
     */

    Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
        Route::resource('faq', FAQController::class);
        Route::get('/faq/change-order/{id}/{substituteId}', [FAQController::class, 'changeOrder'])->name('faq.order');
    });
});
