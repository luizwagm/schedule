<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('V2')->group(function () {
    Route::middleware(['auth:api'])->group(function() {
        Route::prefix('user')->group(function () {
            Route::get('/{id}', [UserController::class, 'get'])->name('user.get');
        });
    });

    Route::post('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});
