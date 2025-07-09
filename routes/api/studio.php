<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Studio\StudioController;

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
    Route::post('/profile/update', [StudioController::class, 'update']);
    Route::post('/profile/update-image', [StudioController::class, 'updateImages']);
    Route::get('/profile', [StudioController::class, 'show']);
});
