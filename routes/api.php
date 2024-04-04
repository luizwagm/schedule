<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('V1')->group(function () {
    Route::middleware(['auth:api'])->group(function() {
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'get'])->name('user.get');
            Route::put('/', [UserController::class, 'update'])->name('user.update');
            Route::post('/delete', [UserController::class, 'delete'])->name('user.delete');
        });

        Route::prefix('schedule')->group(function () {
            Route::get('/all', [ScheduleController::class, 'all'])->name('schedule.all');
            Route::get('/{id}', [ScheduleController::class, 'get'])->name('schedule.get');
            Route::post('/', [ScheduleController::class, 'create'])->name('schedule.create');
            Route::put('/{id}', [ScheduleController::class, 'update'])->name('schedule.update');
            Route::post('/delete/{id}', [ScheduleController::class, 'delete'])->name('schedule.delete');
            Route::post('/filter', [ScheduleController::class, 'filter'])->name('schedule.filter');
        });
    });

    Route::post('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});
