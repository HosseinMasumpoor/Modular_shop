<?php

use Illuminate\Support\Facades\Route;
use Modules\Role\Http\Controllers\v1\RoleController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('role', RoleController::class)->names('role');
});
