<?php

use Illuminate\Support\Facades\Route;
use Modules\Role\Http\Controllers\v1\RoleController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('role', RoleController::class)->names('role');
});
