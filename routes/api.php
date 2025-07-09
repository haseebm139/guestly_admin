<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController  ;
use App\Http\Controllers\Api\V1\UserController  ;

use App\Http\Controllers\API\V1\SubscriptionController;
use App\Http\Controllers\API\V1\CardController;
use App\Http\Controllers\API\V1\SpotBooking\SpotBookingController;

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
        Route::controller(SubscriptionController::class)->group(function () {
            Route::get('plans', 'index');
            Route::post('plans/{planId}/subscribe', 'buyPlan');
        });
        Route::apiResource('cards', CardController::class);
        Route::controller(SpotBookingController::class)->prefix('bookings')->group(function () {

            // Artist books a new spot
            Route::post('/', 'store');

            // View a specific booking
            Route::get('/{id}', ['show']);

            // Artist or studio can reschedule
            Route::put('/{id}/reschedule', 'reschedule');

            // Studio can approve
            Route::post('/{id}/approve', 'approve')->middleware('studio');

            // Studio can reject
            Route::post('/{id}/reject', 'reject');

            // List all bookings for the current user (artist or studio)
            Route::get('/', 'index');
        });






        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});




















