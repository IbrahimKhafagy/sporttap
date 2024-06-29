<?php

use App\Http\Controllers\OpenClosedDayController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\provider\auth\AuthController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::prefix('provider')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify', [AuthController::class, 'verifyUser']);
    Route::post('/resendCode', [AuthController::class, 'resendCode']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgotPassword', [AuthController::class, 'forgotPassword']);
    Route::post('/verifyForgetPassword', [AuthController::class, 'verifyUserPassword']);
    Route::post('/resetPassword', [AuthController::class, 'resetPassword'])->middleware('auth:sanctum');
    Route::post('/updateProfile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/places', [PlaceController::class, 'store']);
        Route::put('/places/{id}', [PlaceController::class, 'update']);
        Route::post('/places/playgrounds',  [PlaceController::class, 'storePlayground']);
        Route::get('/providerPlaces', [PlaceController::class, 'providerPlaces']);
        Route::get('/reservations', [ReservationController::class, 'getProviderReservations']);
        Route::get('reservations/{id}',  [ReservationController::class, 'show']);
        Route::post('/reservations/{id}', [ReservationController::class, 'updateReservation']);
        Route::get('/stats', [ReservationController::class, 'getProviderStats']);

        Route::post('/open-closed-days', [OpenClosedDayController::class, 'store']);
        Route::get('/open-closed-days', [OpenClosedDayController::class, 'index']);
        Route::get('/profile', [AuthController::class, 'show']);
        Route::post('/ChangePhone', [AuthController::class, 'sendOTPChangePhone']);
        Route::post('/VerifyChangePhone', [AuthController::class, 'verifyChangePhone']);
        Route::post('/ChangeEmail', [AuthController::class, 'sendOTPChangeEmail']);
        Route::post('/VerifyChangeEmail', [AuthController::class, 'verifyChangeEmail']);

    });
});
