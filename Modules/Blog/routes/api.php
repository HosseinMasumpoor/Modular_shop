<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\api\v1\BlogController;


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::prefix('blog')->name('articles.')->group(function () {
        Route::get('/media/image/{id}', [BlogController::class, 'getImage'])->name('image');
        Route::get('/media/thumbnail/{id}', [BlogController::class, 'getThumbnail'])->name('thumbnail');
    });

    Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
        Route::apiResource('articles', BlogController::class);
    });

});
