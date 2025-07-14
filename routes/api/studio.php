<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Studio\StudioController;
use App\Http\Controllers\API\V1\Studio\BoostAdController;


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
Route::middleware(['auth:api', 'studio'])->group(function () {

    Route::controller(StudioController::class)->group(function () {
        Route::get('/profile', 'show');
        Route::post('/profile/update', 'update');
        Route::post('/profile/update-image', 'updateImages');
        Route::get('/guests', 'getGuests');
        Route::get('/upcomming/guests', 'upcommingGuests');
        Route::get('/guest-requests', 'requestGuests');
    });

    Route::controller(BoostAdController::class)->group(function () {
        Route::get('/boost-ads', 'list');
        Route::post('/boost-ads', 'store');
        Route::post('/boost-ad/{id}/stop', 'stop');
        Route::post('/boost-ad/{id}/boost-again', 'boostAgain');
    });
});
