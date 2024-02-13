<?php

use App\Http\Controllers\User\AuthController;
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

Route::prefix('user')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');

        Route::group(['middleware' => 'user'], function () {
            Route::post('/logout', 'logout');
        });
    });
});
