<?php

use App\Http\Controllers\Apps\Admin\DesignSpecialityController;
use App\Http\Controllers\Apps\Admin\FeatureManagementController;
use App\Http\Controllers\Apps\Admin\PaymentController;
use App\Http\Controllers\Apps\Admin\PlanManagementController;
use App\Http\Controllers\Apps\Admin\StationAmenityController;
use App\Http\Controllers\Apps\Admin\StripeConnectController;
use App\Http\Controllers\Apps\Admin\SupplyController;
use App\Http\Controllers\Apps\Admin\TattooStyleController;
use App\Http\Controllers\Apps\ArtistManagementController;
use App\Http\Controllers\Apps\ChatController;
use App\Http\Controllers\Apps\Client\ClientController;
use App\Http\Controllers\Apps\Client\FirebaseAuthController;
use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\StudioManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageUpload;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
Route::get('/thankyou', function () {
    return view('user.pages.client.thank_you');
});
Route::get('/test-email', function () {
    Mail::raw('This is a test email from Laravel using privateemail.com SMTP.', function ($message) {
        $message->to('recipient@example.com')
            ->subject('Test Email - PrivateEmail SMTP');
    });

    return 'Email sent!';
});
Route::get('booking/{artist_id}/{artist_name}/{shared_code}', [ClientController::class, 'index'])->name('client.index');
Route::post('/booking/{shared_code}/submit', [ClientController::class, 'submitForm'])->name('client.booking.submit');
Route::get('/booking/done', [ClientController::class, 'thankyouPage'])->name('client.done');
Route::get('/client/{shared_code}/profile/{token}', [ClientController::class, 'profile'])->name('client.profile');
Route::post('/client/booking/{id}/payment', [ClientController::class, 'payDeposit'])
    ->name('client.booking.payment');
Route::post('chat/imageUpload', [ClientController::class, 'imageUpload'])->name('chat.uploadImage');
Route::post('/client/booking/{id}/payment-intent', [ClientController::class, 'createPaymentIntent'])
    ->name('client.booking.createPaymentIntent');
Route::get('/firebase/token', [FirebaseAuthController::class, 'getFirebaseToken']);
Route::get('/check-firebase-config', function () {
    $path = config('services.firebase.credentials');
    $exists = file_exists($path);

    return response()->json([
        'config_path' => $path,
        'file_exists' => $exists,
        'absolute_path' => realpath($path) ?: 'Not found',
        'storage_path' => storage_path(),
    ]);
});
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {

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
            'output' => Artisan::output(),
        ]);
    });

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/upload-image', [DashboardController::class, 'uploadImage'])->name('upload.image');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/store-token', [DashboardController::class, 'storeToken'])->name('store.token');
    Route::get('/web-push', [DashboardController::class, 'webPush']);
    Route::get('/my-profile', [DashboardController::class, 'myProfile'])->name('myprofile');
    Route::get('/my-profile-update-email', [UserManagementController::class, 'myProfileUpdateEmail'])->name('myprofileUpdateEmail');
    Route::get('/my-profile-update-name', [UserManagementController::class, 'myProfileUpdateName'])->name('myprofileUpdateName');
    Route::get('/my-profile-update-password', [UserManagementController::class, 'myProfileUpdatePassword'])->name('myprofileUpdatePassword');
    Route::controller(ChatController::class)->group(function () {
        Route::get('/chat', 'index')->name('chat');

    });
    Route::name('user-management.')->group(function () {
        // Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/administrators', UserManagementController::class);
        Route::put('/{id}/update-email', [UserManagementController::class, 'updateEmail'])->name('update-email');
        Route::put('/user-management/{id}/update-password', [UserManagementController::class, 'updatePassword'])->name('update-password');
        Route::patch('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('toggle-status');
        Route::put('/users/verification-status/{user}', [UserManagementController::class, 'updateVerificationStatus'])->name('update-verification-status');
        Route::resource('/user-management/studios', StudioManagementController::class);
        Route::resource('/user-management/artists', ArtistManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });
    Route::name('product-management.')->group(function () {});

    Route::name('plan-management.')->group(function () {
        Route::resource('plans', PlanManagementController::class);
        Route::get('plan-change-status', [PlanManagementController::class, 'change_status'])->name('plans.change.status');
        Route::resource('/plan-management/features', FeatureManagementController::class);
        Route::get('feature-change-status', [FeatureManagementController::class, 'change_status'])->name('features.change.status');

    });
    Route::name('creative-management.')->group(function () {
        Route::resource('supplies', SupplyController::class);
        Route::resource('station-amenities', StationAmenityController::class);
        Route::resource('tattoo-styles', TattooStyleController::class);
        Route::resource('design-specialities', DesignSpecialityController::class);

    });

    // Payments
    Route::name('payments.')->group(function () {
        Route::get('/payments/deposits', [PaymentController::class, 'deposits'])
            ->name('deposits.index');
        Route::get('/payments/deposits/{payment}', [PaymentController::class, 'showDeposit'])
            ->name('deposits.show');
        Route::post('/payments/deposits/{payment}/transfer', [PaymentController::class, 'transferDeposit'])
            ->name('deposits.transfer');
    });

    // Stripe Connect onboarding (artists)
    Route::get('/artists/{user}/stripe/connect', [StripeConnectController::class, 'start'])
        ->name('artists.stripe.connect');
    Route::get('/stripe/connect/refresh', [StripeConnectController::class, 'refresh'])
        ->name('stripe.connect.refresh');
    Route::get('/stripe/connect/return', [StripeConnectController::class, 'returned'])
        ->name('stripe.connect.return');

    Route::resource('image/upload', ImageUpload::class);

    // Route::resource('vendor/product', ProductController::class);

});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__.'/auth.php';
require __DIR__.'/user.php';
