<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Include client routes
require __DIR__.'/client.php';

// Include admin routes
require __DIR__.'/admin.php';
require __DIR__.'/provider.php';

require __DIR__.'/general.php';

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
