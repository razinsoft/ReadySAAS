<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserAuthenticationController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletController;

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

Route::post('/sign-in', [UserAuthenticationController::class, 'signIn']);
Route::post('/forgot/password', [UserAuthenticationController::class, 'forgotPassword']);
Route::post('/check/otp', [UserAuthenticationController::class, 'checkOtp']);
Route::put('/reset/password', [UserAuthenticationController::class, 'resetPassword']);
Route::middleware('auth:api')->group(function () {
    Route::get('/logout', [UserAuthenticationController::class, 'logout']);
    Route::get('/product/search', [ProductController::class, 'search']);
    Route::get('/category/product/{category}', [ProductController::class, 'categoryProduct']);
    Route::post('/apply/promo/code', [CouponController::class, 'applyPromoCode']);
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/details', 'details');
        Route::put('/user/profile/update', 'profileUpdate');
        Route::put('/user/password/change', 'passwordChange');
    });
    Route::controller(PosController::class)->group(function () {
        Route::get('/pos', 'pos');
        Route::get('/draft/details/{id}', 'details');
        Route::post('/pos/store', 'store');
    });
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer/search', 'search');
        Route::post('/customer/store', 'store');
    });
    Route::controller(WalletController::class)->group(function () {
        Route::get('/accounts', 'accounts');
        Route::get('/balance', 'balance');
        Route::post('/balance/transfer', 'balanceTransfer');
    });
});
