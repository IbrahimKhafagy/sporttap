<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaygroundController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\admin\Auth\LoginController;
use App\Http\Controllers\admin\Auth\ResetPasswordController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\admin\Auth\ForgotPasswordController;
use App\Http\Controllers\PlaceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/tables', function () {
//     return view('icons-boxicons');
// });


Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');


Route::get('/', [HomeController::class, 'root'])->name('root');


    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);

        Route::middleware('auth:admin')->group(function () {

            Route::post('logout', [LoginController::class, 'logout'])->name('logout');
            Route::get('/home', [HomeController::class, 'index'])->name('home');
            Route::get('/Clients', [HomeController::class, 'view']);

            Route::get('/playgrounds', [PlaygroundController::class, 'index'])->name('playgrounds.index');
            Route::get('/playgrounds/create', [PlaygroundController::class, 'create'])->name('playgrounds.create');
            Route::post('/playgrounds', [PlaygroundController::class, 'store'])->name('playgrounds.store');
            Route::get('/playgrounds/{id}/edit', [PlaygroundController::class, 'edit']);
            Route::put('/playgrounds/{id}', [PlaygroundController::class, 'update'])->name('playgrounds.update');
            Route::delete('/playgrounds/{id}', [PlaygroundController::class, 'destroy']);
            Route::get('playgrounds/{playground}/reservations', [PlaygroundController::class, 'reservations']);

            Route::get('/places', [PlaceController::class, 'index'])->name('places.index');
            Route::get('/places/{id}', [PlaceController::class, 'show'])->name('places.show');


        });


    });



Route::prefix('admin')->group(function () {
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    });







