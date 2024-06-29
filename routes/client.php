<?php

use App\Http\Controllers\clints\clintController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\user\auth\AuthUserController;
use App\Http\Controllers\user\HomeController;
use Illuminate\Support\Facades\Route;


Route::prefix('client')->group(function () {

    Route::post('/login', [AuthUserController::class, 'login']);
    Route::post('/register', [AuthUserController::class, 'register']);
    Route::post('/verify', [AuthUserController::class, 'verify']);

    Route::post('/reservations', [ReservationController::class, 'store']);

    Route::get('/home', [HomeController::class, 'getHome']);


    // Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::put('/update/{id}', [AuthUserController::class, 'update']);
        Route::get('/profile', [AuthUserController::class, 'show']);

        // Route::post('/users', [clintController::class, 'store']);
        Route::post('/client/users', [clintController::class, 'store'])->name('users.store');
        Route::get('/clients', [clintController::class, 'index'])->name('clients.index');
        Route::put('/users/{id}', [clintController::class, 'update'])->name('users.update');
        Route::get('{user}/edit', [clintController::class, 'edit'])->name('users.edit');
        Route::delete('{user}', [clintController::class, 'destroy'])->name('users.destroy');


    // });
});



