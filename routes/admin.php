<?php

use App\Http\Controllers\clints\clintController;
use App\Http\Controllers\events\EventController;
use App\Http\Controllers\general\CategoryController;
use App\Http\Controllers\general\CouponController;
use App\Http\Controllers\general\MediaController;
use App\Http\Controllers\general\PlanController;
use App\Http\Controllers\general\SliderController;
use App\Http\Controllers\general\StaticPageController;
use App\Http\Controllers\general\ZoneController;
use App\Http\Controllers\PlaygroundController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    // Define admin routes here
    Route::get('/getData', [clintController::class, 'getClients']);

    Route::get('/getPlaygrounds', [PlaygroundController::class, 'getPlaygrounds']);
    Route::post('/playgrounds', [PlaygroundController::class, 'store'])->name('playgrounds.store');
    Route::post('/playgrounds/{playground}', [PlaygroundController::class, 'update'])->name('playgrounds.update');



});
