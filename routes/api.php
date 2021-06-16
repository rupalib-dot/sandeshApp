<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::namespace('ApiController')->group(function () {
        Route::post('register_otp', [UserController::class, 'register_otp']);
        Route::post('register_account', [UserController::class, 'register_account']);
        Route::post('update_account', [UserController::class, 'update_account']);
        Route::post('login_account', [UserController::class, 'login_account']);
        Route::post('resend_otp', [UserController::class, 'resend_otp']);
        Route::post('profile', [UserController::class, 'user_profile']);
        Route::post('change_password', [UserController::class, 'change_password']);
});