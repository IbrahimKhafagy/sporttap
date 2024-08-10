<?php

use App\Http\Controllers\clients\ClientController;
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

         Route::post('/users', [ClientController::class, 'store']);
        Route::post('/client/users', [ClientController::class, 'store'])->name('users.store');
//        Route::get('/clients', [clientController::class, 'index'])->name('clients.index');
        Route::post('/users/{id}', [ClientController::class, 'update'])->name('users.update');
        // Route::get('{user}/edit', [clientController::class, 'edit'])->name('users.edit');
        Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');

        Route::delete('{user}', [ClientController::class, 'destroy'])->name('users.destroy');


    // });
});



