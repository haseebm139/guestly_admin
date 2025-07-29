<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Artist\ArtistController;
use App\Http\Controllers\Api\V1\Artist\CustomFormController;
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
        Route::get('studio/{id}','studio');
    });
    Route::controller(CustomFormController::class)->group(function () {
        Route::get('/forms','index');
        Route::post('forms', 'store');
        Route::get('forms/{id}','show');
        Route::post('/forms/update/{id}', 'update');
        Route::delete('/forms/destroy/{id}', 'destroy');
    });







});
