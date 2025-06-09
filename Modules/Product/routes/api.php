<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\v1\ProductController;

Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::post('/products', [ProductController::class, 'store'])->name('product.store');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    });
});
