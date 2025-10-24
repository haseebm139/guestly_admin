<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Studio\StudioController;
use App\Http\Controllers\Api\V1\Studio\BoostAdController;
use App\Http\Controllers\Api\V1\Studio\StudioBlockStationController;
use App\Http\Controllers\Api\V1\Studio\StudioAvailableDaysController;
 

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
Route::middleware(['auth:sanctum', 'studio'])->group(function () {

    Route::controller(StudioController::class)->group(function () {
        Route::get('/profile', 'show');
        Route::post('/profile/update', 'update');
        Route::post('/profile/update-image', 'updateImages');
        Route::get('/guests', 'getGuests');
        Route::get('/upcomming/guests', 'upcommingGuests');
        Route::get('/guest-requests', 'requestGuests');
        Route::get('/artist', 'artist');
    });

    Route::controller(BoostAdController::class)->group(function () {
        Route::get('/boost-ads-page', 'boosts');
        Route::get('/boost-ads', 'list');
        Route::post('/boost-ads', 'store');
        Route::post('/boost-ad/{id}/stop', 'stop');
        Route::post('/boost-ad/{id}/boost-again', 'boostAgain');
    });

    Route::controller(StudioBlockStationController::class)->group(function () {
        Route::get('/block-stations','index');
        Route::post('/block-stations','store');
        Route::post('/block-stations/bulk','storeBulk');
        Route::post('/unblock-stations/{id}','unblock');
        Route::delete('/block-stations/{id}','destroy');
    });

    Route::controller(StudioAvailableDaysController::class)->group(function () {
        Route::get('/weekly-availability','getWeeklyAvailability');
        Route::post('/weekly-availability','storeWeeklyAvailability'); 
        Route::get('/block-date','getBlockedDate'); 
        Route::post('/block-date','storeBlockedDate'); 
        Route::delete('/unblock-date/{id}','unblockDate'); 
    });


});
