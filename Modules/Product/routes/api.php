<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\v1\BrandController;
use Modules\Product\Http\Controllers\v1\ProductAttributeController;
use Modules\Product\Http\Controllers\v1\ProductController;
use Modules\Product\Http\Controllers\v1\ProductImageController;

Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/products/images/{productId}', [ProductImageController::class, 'index'])->name('index');

    Route::get('/brands', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/brands/{id}', [BrandController::class, 'show'])->name('brand.show');

    Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
        Route::prefix('/products')->name('product.')->group(function () {
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::put('/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');

            Route::get('{productId}/attributes', [ProductAttributeController::class, 'index'])->name('attributes.index');
            Route::get('/attributes/{id}', [ProductAttributeController::class, 'show'])->name('attributes.show');
            Route::post('/attributes', [ProductAttributeController::class, 'store'])->name('attributes.store');
            Route::put('/attributes/{id}', [ProductAttributeController::class, 'update'])->name('attributes.update');
            Route::delete('/attributes/{id}', [ProductAttributeController::class, 'destroy'])->name('attributes.destroy');

            Route::prefix('images')->name('images.')->group(function () {
                Route::post('/', [ProductImageController::class, 'store'])->name('store');
                Route::put('/{id}', [ProductImageController::class, 'update'])->name('update');
            });
        });

        Route::prefix('brands')->name('brand.')->group(function () {
            Route::post('/', [BrandController::class, 'store'])->name('store');
            Route::put('/{id}', [BrandController::class, 'update'])->name('update');
            Route::delete('/{id}', [BrandController::class, 'destroy'])->name('destroy');
        });

    });


    Route::get('products/images/media/image/{id}', [ProductImageController::class, 'getImage'])->name('products.image.get-image');
    Route::get('products/images/media/thumbnail/{id}', [ProductImageController::class, 'getThumbnail'])->name('products.image.get-thumbnail');
});
