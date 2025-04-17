<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\api\v1\BlogController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('blog', BlogController::class)->names('blog');
});
