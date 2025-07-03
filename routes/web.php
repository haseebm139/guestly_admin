<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ImageUpload;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/upload-image', [DashboardController::class, 'uploadImage'])->name('upload.image');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/store-token', [DashboardController::class, 'storeToken'])->name('store.token');
    Route::get('/web-push', [DashboardController::class, 'webPush']);
    Route::get('/my-profile', [DashboardController::class,'myProfile'])->name('myprofile');
    Route::get('/my-profile-update-email', [UserManagementController::class,'myProfileUpdateEmail'])->name('myprofileUpdateEmail');
    Route::get('/my-profile-update-name', [UserManagementController::class,'myProfileUpdateName'])->name('myprofileUpdateName');
    Route::get('/my-profile-update-password', [UserManagementController::class,'myProfileUpdatePassword'])->name('myprofileUpdatePassword');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });
    Route::name('product-management.')->group(function () {

    });




    Route::resource('image/upload', ImageUpload::class);


        // Route::resource('vendor/product', ProductController::class);



});

Route::get('/error', function () {
    abort(500);
});


Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
