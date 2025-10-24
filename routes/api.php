<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController  ;
use App\Http\Controllers\Api\V1\UserController  ;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\V1\SubscriptionController;
use App\Http\Controllers\Api\V1\CardController;
// use App\Http\Controllers\Api\V1\NotificationController;
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
    'middleware' => ['auth:sanctum'], // Use 'auth:sanctum' if you're using Sanctum
]);
Route::middleware('auth:sanctum')->group(function () {

});

Route::prefix('v1')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('google_login', [AuthController::class, 'googleLogin']);
    Route::post('facebook_login', [AuthController::class, 'facebookLogin']);
    Route::post('apple_login', [AuthController::class, 'appleLogin']);
    Route::post('send-code-to-email', [AuthController::class, 'sendCodeToEmail']);
    Route::post('/update-password',[AuthController::class, 'updatePassword']);
    Route::post('/auto-login-register',[AuthController::class, 'autoLoginOrRegister']); 
    Route::middleware('auth:sanctum')->delete('/del-account', [AuthController::class, 'deleteAccount']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user/profile', [AuthController::class, 'profile']);
        Route::post('/send-bulk-notification', [NotificationController::class, 'sendToMany']);
        Route::post('/send-notification', [NotificationController::class, 'sendToUser']);

        Route::prefix('user/')->group(function () {

            Route::get('verification/options', [UserController::class, 'getVerificationOptions']);
            Route::post('verification/upload', [UserController::class, 'uploadVerificationDocument']);
            Route::post('verification/confirm', [UserController::class, 'confirmVerification']);
            Route::get('verification/status', [UserController::class, 'getVerificationStatus']);
        });
        Route::post('upload/chat-image', [UserController::class, 'uploadChatImage']);
        Route::controller(SubscriptionController::class)->group(function () {
            Route::get('plans', 'index');
            Route::post('plans/{planId}/subscribe', 'buyPlan');
        });
        Route::apiResource('cards', CardController::class);
        Route::controller(CardController::class)->group(function () {
            Route::get('cards/change_status', 'changeStatus');
        });
        Route::controller(SpotBookingController::class)->prefix('bookings')->group(function () {
            Route::get('/monthly-bookings-calandar/{studio_id}', 'monthlyCalendar');
            Route::get('/monthly-bookings-calandar-artist', 'clientBookingCalendar');
            // Artist books a new spot
            Route::post('/', 'store');

            // View a specific booking
            Route::get('/{id}', 'show');

            // Artist or studio can reschedule
            Route::post('/{id}/reschedule', 'reschedule');


            Route::get('/reschedule_post', 'reschedulePost');
            // reschedulePost
            // Studio can approve
            Route::get('/{id}/approve', 'approve') ;

            // Studio can reject
            Route::get('/{id}/reject', 'reject');

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
        Route::controller(NotificationController::class)->prefix('notification')->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/read/{id}', 'markAsRead');
        });




        Route::post('logout', [AuthController::class, 'logout']);
    });
});




















