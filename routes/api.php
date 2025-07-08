<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\UserController;

// use App\Http\Controllers\API\GalleryController;
// use App\Http\Controllers\API\EventController;
use App\Http\Controllers\Api\V1\AuthController as UserAuthController;
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
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('google_login', [UserAuthController::class, 'googleLogin']);
    Route::post('facebook_login', [UserAuthController::class, 'facebookLogin']);
    Route::post('apple_login', [UserAuthController::class, 'appleLogin']);
    Route::post('send-code-to-email', [UserAuthController::class, 'sendCodeToEmail']);

    Route::middleware('auth:api')->group(function () {
        Route::get('plans', [SubscriptionController::class, 'index']);
        Route::post('plans/{planId}/subscribe', [SubscriptionController::class, 'buyPlan']);
        Route::get('profile', [UserAuthController::class, 'profile']);
        Route::post('logout', [UserAuthController::class, 'logout']);
    });
});




















