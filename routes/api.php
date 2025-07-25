<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController  ;
use App\Http\Controllers\Api\V1\UserController  ;

use App\Http\Controllers\Api\V1\SubscriptionController;
use App\Http\Controllers\Api\V1\CardController;
use App\Http\Controllers\Api\V1\SpotBooking\SpotBookingController;
use App\Http\Controllers\Api\V1\Studio\HomeController;

use App\Http\Controllers\Api\V1\Chat\MessageController;
use App\Http\Controllers\Api\V1\Chat\ChatController;
use Illuminate\Support\Facades\Broadcast;
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
Broadcast::routes([
    'middleware' => ['auth:api'], // Use 'auth:sanctum' if you're using Sanctum
]);
Route::middleware('auth:api')->group(function () {

});

Route::prefix('v1')->group(function () {


    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('google_login', [AuthController::class, 'googleLogin']);
    Route::post('facebook_login', [AuthController::class, 'facebookLogin']);
    Route::post('apple_login', [AuthController::class, 'appleLogin']);
    Route::post('send-code-to-email', [AuthController::class, 'sendCodeToEmail']);
    Route::post('/auto-login-register',[AuthController::class, 'autoLoginOrRegister']);

    Route::middleware('auth:api')->group(function () {
        Route::get('user/profile', [AuthController::class, 'profile']);

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
            Route::get('/{id}', 'show');

            // Artist or studio can reschedule
            Route::post('/{id}/reschedule', 'reschedule');


            Route::get('/reschedule_post', 'reschedulePost');
            // reschedulePost
            // Studio can approve
            Route::post('/{id}/approve', 'approve') ;

            // Studio can reject
            Route::post('/{id}/reject', 'reject');

            // List all bookings for the current user (artist or studio)
            Route::get('/', 'index');


        });
        Route::prefix('chats')->group(function (){
            Route::post('/start', [ChatController::class,'startChat']);
            Route::get('/', [ChatController::class,'index']);

            Route::get('/{chat}/messages', [MessageController::class,'index']);
            Route::post('/{chat}/messages', [MessageController::class,'store']);
        });
        Route::get('lookups', [HomeController::class, 'lookups']);




        Route::post('logout', [AuthController::class, 'logout']);
    });
});




















