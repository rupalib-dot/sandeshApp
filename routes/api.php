<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\CustomerApi\CustomerController;
use App\Http\Controllers\ApiController\CustomerApi\ProductsController;
use App\Http\Controllers\ApiController\CustomerApi\OrderController;
use App\Http\Controllers\ApiController\CustomerApi\VendorController;
use App\Http\Controllers\ApiController\DriverApi\DriverController;
use App\Http\Controllers\ApiController\DriverApi\OrderController as DriverOrder;

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
    Route::namespace('CustomerApi')->prefix('customer')->group(function () {
        Route::post('create_account', [CustomerController::class, 'CreateAcount']);
        Route::post('resend_otp', [CustomerController::class, 'ResendOTP']);
        Route::post('login_account', [CustomerController::class, 'LoginAcount']);
        Route::post('customer_profile', [CustomerController::class, 'CustomerProfile']);
        Route::post('create_address', [CustomerController::class, 'CreateAddress']);
        Route::post('address_list', [CustomerController::class, 'AddressList']);
        Route::post('address_delete', [CustomerController::class, 'AddressDelete']);
        Route::post('update_address', [CustomerController::class, 'UpdateAddress']);
        Route::post('update_profile_image', [CustomerController::class, 'UpdateProfileImage']);
        Route::post('feedback', [CustomerController::class, 'SaveFeedback']);

        Route::post('home', [ProductsController::class, 'HomePage']);
        Route::get('category_list', [ProductsController::class, 'CategoryList']);
        
        Route::post('vendor_list', [VendorController::class, 'VendorList']);

        Route::post('place_order', [OrderController::class, 'PlaceOrder']);
        Route::post('order_list', [OrderController::class, 'OrderList']);
        Route::post('order_detail', [OrderController::class, 'OrderDetail']);

        Route::post('apply_coupon', [OrderController::class, 'ApplyCoupon']);

        Route::get('cancel_reason', [OrderController::class, 'CancelReason']);
    });

    Route::namespace('DriverApi')->prefix('driver')->group(function () {
        Route::post('resend_otp', [DriverController::class, 'ResendOTP']);
        Route::post('login_account', [DriverController::class, 'LoginAcount']);
        Route::post('driver_profile', [DriverController::class, 'DriverProfile']);
        Route::post('driver_token', [DriverController::class, 'UpdateToken']);
        Route::post('driver_status', [DriverController::class, 'ChangeStatus']);

        Route::post('assign_order', [DriverOrder::class, 'AssignOrder']);
        Route::post('accept_reject_order', [DriverOrder::class, 'AcceptRejectOrder']);
        Route::post('ongoing_order', [DriverOrder::class, 'OngoingOrder']);
        Route::post('completed_order', [DriverOrder::class, 'CompletedOrder']);
        Route::post('complete_order', [DriverOrder::class, 'CompleteOrder']);
    });
});