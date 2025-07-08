<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController  ;
use App\Http\Controllers\Api\V1\UserController  ;

use App\Http\Controllers\API\V1\SubscriptionController;
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

Route::prefix('v1')->group(function () {
    Route::any('test', function () {
        return 'test';
    });
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('google_login', [AuthController::class, 'googleLogin']);
    Route::post('facebook_login', [AuthController::class, 'facebookLogin']);
    Route::post('apple_login', [AuthController::class, 'appleLogin']);
    Route::post('send-code-to-email', [AuthController::class, 'sendCodeToEmail']);

    Route::middleware('auth:api')->group(function () {
        Route::prefix('user/')->group(function () {

            Route::get('verification/options', [UserController::class, 'getVerificationOptions']);
            Route::post('verification/upload', [UserController::class, 'uploadVerificationDocument']);
            Route::post('verification/confirm', [UserController::class, 'confirmVerification']);
            Route::get('verification/status', [UserController::class, 'getVerificationStatus']);
        });
        Route::get('plans', [SubscriptionController::class, 'index']);
        Route::post('plans/{planId}/subscribe', [SubscriptionController::class, 'buyPlan']);






        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});




















