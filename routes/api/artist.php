<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\Artist\ArtistController;
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
Route::middleware(['auth:api', 'artist'])->group(function () {

    Route::controller(ArtistController::class)->group(function () {
        Route::get('/profile', 'show');
        Route::post('/profile/update', 'update');
        Route::post('/profile/update-image', 'updateImages');
        // List of all studios
        Route::get('studios','studios');
        Route::get('studio/{id}','studio');
    });


});
