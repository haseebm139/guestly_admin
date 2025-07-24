<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ImageUpload;
use App\Http\Controllers\DashboardController;


use App\Http\Controllers\Apps\ChatController;
use App\Http\Controllers\Apps\Admin\PlanManagementController;
use App\Http\Controllers\Apps\Admin\FeatureManagementController;
use App\Http\Controllers\Apps\Admin\SupplyController;
use App\Http\Controllers\Apps\Admin\StationAmenityController;
use App\Http\Controllers\Apps\Admin\TattooStyleController;
use App\Http\Controllers\Apps\Admin\DesignSpecialityController;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;
// apiDHL
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

Route::get('/dhl', [ImageUpload::class, 'apiDHL']);

Route::get('/dhl1112', [ImageUpload::class, 'apiDHL']);
Route::get('/dhl1112', [ImageUpload::class, 'apiDHL']);
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/maintenance/clear-caches', function () {
        // Only allow in local / staging or if you add auth
        if (! app()->isLocal()) {
            abort(403, 'Forbidden');
        }

        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');


        return response()->json([
            'message' => 'All caches cleared.',
            'output'  => Artisan::output(),
        ]);
    });

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/upload-image', [DashboardController::class, 'uploadImage'])->name('upload.image');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/store-token', [DashboardController::class, 'storeToken'])->name('store.token');
    Route::get('/web-push', [DashboardController::class, 'webPush']);
    Route::get('/my-profile', [DashboardController::class,'myProfile'])->name('myprofile');
    Route::get('/my-profile-update-email', [UserManagementController::class,'myProfileUpdateEmail'])->name('myprofileUpdateEmail');
    Route::get('/my-profile-update-name', [UserManagementController::class,'myProfileUpdateName'])->name('myprofileUpdateName');
    Route::get('/my-profile-update-password', [UserManagementController::class,'myProfileUpdatePassword'])->name('myprofileUpdatePassword');
    Route::controller(ChatController::class)->group(function () {
        Route::get('/chat', 'index')->name('chat');

    });
    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });
    Route::name('product-management.')->group(function () {

    });

    Route::name('plan-management.')->group(function () {
            Route::resource('plans', PlanManagementController::class);
            Route::get('plan-change-status', [PlanManagementController::class,'change_status'])->name('plans.change.status');
            Route::resource('/plan-management/features', FeatureManagementController::class);
            Route::get('feature-change-status', [FeatureManagementController::class,'change_status'])->name('features.change.status');

        });
        Route::name('creative-management.')->group(function () {
            Route::resource('supplies', SupplyController::class);
            Route::resource('station-amenities', StationAmenityController::class);
            Route::resource('tattoo-styles', TattooStyleController::class);
            Route::resource('design-specialities', DesignSpecialityController::class);


        });


    Route::resource('image/upload', ImageUpload::class);


        // Route::resource('vendor/product', ProductController::class);



});

Route::get('/error', function () {
    abort(500);
});




Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
