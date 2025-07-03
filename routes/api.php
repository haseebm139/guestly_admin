<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\EventController;

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(AuthController::class)->group(function () {
    Route::POST('/register', 'register');
    Route::POST('/login', 'login');
    Route::POST('/verify-email', 'VerifyEmail');
    Route::POST('/verify-code', 'VerifyEmailCode');
    Route::POST('/change_password', 'changePassword');


});

Route::middleware('auth:api')->group( function () {
    Route::controller(UserController::class)->group(function () {
        Route::POST('/profile', 'updateProfile'); 
        Route::GET('/profile', 'getProfile'); 
        Route::GET('/subscription', 'listSubscription'); 
        Route::GET('/users', 'homeScreenApi');
        Route::GET('/friends-list', 'friendsList');
        Route::POST('/send-friend-request', 'sendFriendRequest');
        Route::GET('/friend-requests', 'receiveFriendRequest');
        Route::POST('/accept-friend-request', 'acceptFriendRequest');
        Route::POST('/reject-friend-request', 'rejectFriendRequest');
        Route::POST('/search-user', 'userSearch');
        Route::GET('/new-match-users', 'newMatchUser');
        Route::GET('/near-users', 'nearUser');
        Route::GET('/recent-partners-users', 'recentPartnerUser'); 
        
    });

    Route::controller(GalleryController::class)->group(function () {         
        Route::POST('/upload_gallery', 'uploadGallery'); 
        Route::POST('/like-post', 'postLike'); 
        Route::POST('/comment-post', 'postComment');       
        Route::GET('/get-user-images', 'getUserImages');      
        Route::GET('/get-user-video', 'getUserVideo');     
        Route::GET('/get-post-comments', 'postComments');     
        
    });

    Route::prefix('events')->group(function () {
        Route::get('/', [EventController::class, 'index']);
        Route::get('/my-events', [EventController::class, 'index1']);
        Route::post('/', [EventController::class, 'store']);
        Route::get('/{id}', [EventController::class, 'show']);
        Route::POST('/{id}', [EventController::class, 'update']);
        Route::delete('/{id}', [EventController::class, 'destroy']);
        Route::get('/accept/{id}', [EventController::class, 'accept']);
        Route::get('/reject/{id}', [EventController::class, 'reject']);
    });
});