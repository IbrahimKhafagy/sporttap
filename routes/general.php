<?php

use App\Http\Controllers\general\ContactusController;
use App\Http\Controllers\general\GeneralController;
use App\Http\Controllers\general\ServiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

Route::prefix('general')->group(function () {
    Route::post('/StoreMedia', [GeneralController::class, 'store']);
    Route::post('/countries', [GeneralController::class, 'storeCountry']);
    Route::post('/cities', [GeneralController::class, 'storeCity']);
    Route::post('/areas', [GeneralController::class, 'storeArea']);

    Route::get('/cities/{country_id}', [GeneralController::class, 'getCities']);
    Route::get('/areas/{city_id}', [GeneralController::class, 'getAreas']);

    Route::post('/services', [ServiceController::class, 'store']);
    Route::get('/services', [ServiceController::class, 'getActiveServices']);
    Route::get('/placeSettings', [GeneralController::class, 'placeSetting']);
    Route::post('/reasons', [ReasonController::class, 'store']);

    Route::get('/reasons', [ReasonController::class, 'reasons']);

    Route::get('static-page/{name}', [StaticPageController::class, 'getPage']);

    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::post('/contactus', [ContactusController::class, 'store']);
        Route::get('/notifications', [NotificationController::class, 'getProviderNotifications']);
        Route::post('/notifications', [NotificationController::class, 'deleteProviderNotifications']);


    });



});
