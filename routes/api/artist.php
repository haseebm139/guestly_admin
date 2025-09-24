<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Artist\ArtistController;
use App\Http\Controllers\Api\V1\Artist\CustomFormController;
use App\Http\Controllers\Api\V1\Artist\FlashTattooController;
use App\Http\Controllers\Api\V1\Artist\ClientController;
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
Route::middleware(['auth:sanctum', 'artist'])->group(function () {

    Route::controller(ArtistController::class)->group(function () {
        Route::get('/profile', 'show');
        Route::post('/profile/update', 'update');
        Route::post('/profile/update-image', 'updateImages');
        // List of all studios
        Route::get('studios','studios');
        Route::get('booked_studios','bookedStudios');

        Route::get('studio/{id}','studio');
        Route::post('/studios/favorite','toggle');
        Route::get('/studios/favorite','favStudios');

        Route::get('/upcoming-guest-spots','upcomingGuestSpots');
        Route::get('/past-guest-spots','pastGuestSpots');


    });
    Route::controller(CustomFormController::class)->group(function () {
        Route::get('/forms','index');
        Route::post('forms', 'store');
        Route::get('forms/{id}','show');
        Route::post('/forms/update/{id}', 'update');
        Route::delete('/forms/destroy/{id}', 'destroy');

        Route::post('/create/booking-url', 'bookingUrl');

    });

    Route::prefix('flash-tattoos')->group(function () {
        Route::get('/', [FlashTattooController::class, 'index']);   // list with search & pagination
        Route::post('/', [FlashTattooController::class, 'store']);  // create
        Route::post('update/{id}', [FlashTattooController::class, 'update']); // update
        Route::delete('/{id}', [FlashTattooController::class, 'destroy']); // delete
    });

    Route::prefix('clients')->controller(ClientController::class)->group(function () {
        Route::get('/calendar', 'artistCalendar');
        Route::get('requests', 'clientsRequests');
        Route::get('update-status/{id}/{status}', 'updateStatusClientRequest');
        Route::post('set_estimate/{id}', 'setEstimate');
    });






});
