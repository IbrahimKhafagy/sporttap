<?php

use App\Http\Controllers\admin\ReservationAdminController;
use App\Http\Controllers\clients\ClientController;
use App\Http\Controllers\general\ServiceController;
use App\Http\Controllers\PlaygroundController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    // Define admin routes here

    Route::get('/getPlaygrounds', [PlaygroundController::class, 'getPlaygrounds']);
    Route::post('/playgrounds', [PlaygroundController::class, 'store'])->name('playgrounds.store');
    Route::post('/playgrounds/{playground}', [PlaygroundController::class, 'update'])->name('playgrounds.update');

    // get all clients
    Route::get('/allClient', [ClientController::class, 'getAllClient']);

    Route::get('/allServices', [ServiceController::class, 'getAllServices']);

    Route::post('/client/update/{id}', [ClientController::class, 'updateMissingData'])->name('client.update');
    Route::get('/getReservations', [ReservationAdminController::class, 'getReservations']);

});
