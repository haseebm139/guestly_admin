 <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController as WebAuthController;
use App\Http\Controllers\Web\LanguageController as WebLanguageController;
use App\Http\Controllers\Web\WebsiteController;
use App\Http\Controllers\Web\Artist\ArtistController as WebArtistController;
use App\Http\Controllers\Web\Artist\StudioController as WebStudioController;


Route::get('/', function () {
    return view('user.welcome');
});


Route::get('form_slider', [WebsiteController::class, 'formSlider'])->name('form_slider');
Route::get('form_slider_two', [WebsiteController::class, 'formSliderTwo'])->name('form_slider_two');
Route::get('form_login_signup', [WebsiteController::class, 'formLoginSignup'])->name('form_login_signup');
Route::get('choose_plan', [WebsiteController::class, 'choosePlan'])->name('choose_plan');
Route::get('studio_choose_plan', [WebsiteController::class, 'studioChoosePlan'])->name('studio_choose_plan');
Route::get('user_identification', [WebsiteController::class, 'userIdentification'])->name('user_identification');
Route::get('doc_verification', [WebsiteController::class, 'docVerification'])->name('doc_verification');
Route::get('phone_email_verification', [WebsiteController::class, 'phoneEmailVerification'])->name('phone_email_verification');
Route::get('studio_step_form', [WebsiteController::class, 'studioStepForm'])->name('studio_step_form');
Route::get('boost_studio', [WebsiteController::class, 'boostStudio'])->name('boost_studio');
Route::get('forgot_password', [WebsiteController::class, 'forgotPassword'])->name('forgot_password');
Route::get('reset_password', [WebsiteController::class, 'resetPassword'])->name('reset_password');
Route::get('verify_otp', [WebsiteController::class, 'verifyOtp'])->name('verify_otp');


// -- Artist Dashboard Routes

Route::middleware('auth')->middleware('role:artist')->group(function () {
    // routes here
    Route::get('/dashboard/explore', [WebArtistController::class, 'explore'])->name('dashboard.explore');
    Route::get('/dashboard/studio_detail', [WebArtistController::class, 'studioDetail'])->name('dashboard.studio_detail');
    Route::get('/dashboard/artist_chat', [WebArtistController::class, 'chat'])->name('dashboard.artist_chat');
    Route::get('/dashboard/artist_profile', [WebArtistController::class, 'profile'])->name('dashboard.artist_profile');
    Route::get('/dashboard/artist_security', [WebArtistController::class, 'security'])->name('dashboard.artist_security');
    Route::get('/dashboard/artist_bio', [WebArtistController::class, 'bio'])->name('dashboard.artist_bio');
    Route::get('/dashboard/artist_subscription', [WebArtistController::class, 'subscription'])->name('dashboard.artist_subscription');
    Route::get('/dashboard/artist_rating', [WebArtistController::class, 'rating'])->name('dashboard.artist_rating');
    Route::get('/dashboard/artist_payment', [WebArtistController::class, 'payment'])->name('dashboard.artist_payment');
    Route::get('/dashboard/artist_booking', [WebArtistController::class, 'booking'])->name('dashboard.artist_booking');
    Route::get('/dashboard/artist_guest_spot', [WebArtistController::class, 'guestSpot'])->name('dashboard.artist_guest_spot');
    Route::get('/dashboard/artist_request', [WebArtistController::class, 'request'])->name('dashboard.artist_request');
    Route::get('/dashboard/artist_tattoo', [WebArtistController::class, 'tattoo'])->name('dashboard.artist_tattoo');
});
//            == > End Artist



// -- Dashboard Studio
Route::middleware('auth')->middleware('role:studio')->group(function () {
    Route::get('/dashboard/studio_home', [WebStudioController::class, 'home'])->name('dashboard.studio_home');
    Route::get('/dashboard/studio_chat', [WebStudioController::class, 'chat'])->name('dashboard.studio_chat');
    Route::get('/dashboard/studio_search_artist', [WebStudioController::class, 'searchArtist'])->name('dashboard.studio_search_artist');
    Route::get('/dashboard/studio_request', [WebStudioController::class, 'studioRequest'])->name('dashboard.studio_request');
    Route::get('/dashboard/studio_profile', [WebStudioController::class, 'profile'])->name('dashboard.studio_profile');
    Route::get('/dashboard/studio_subscription', [WebStudioController::class, 'studioSubscription'])->name('dashboard.studio_subscription');
    Route::get('/dashboard/studio_availability', [WebStudioController::class, 'studioAvailability'])->name('dashboard.studio_availability');
    Route::get('/dashboard/studio_promotion', [WebStudioController::class, 'studioPromotion'])->name('dashboard.studio_promotion');
    Route::get('/dashboard/studio_rating', [WebStudioController::class, 'rating'])->name('dashboard.studio_rating');
    Route::get('/dashboard/studio_payment', [WebStudioController::class, 'payment'])->name('dashboard.studio_payment');
    Route::get('/dashboard/studio_security', [WebStudioController::class, 'security'])->name('dashboard.studio_security');
});
//            == > End Studio

//            == > Notification
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/notification', function () {
        return view('user.dashboard.notification', [
            'pageTitle' => 'Notifications'
        ]);
    })->name('dashboard.notification');
});
//            == > End Notification


// -- For Testing

Route::get('/map_test', function () {
    return view('user.common.map_test');
})->name('map_test');


Route::get('/login', function () {
return view('user.common.form_login_signup');
})->name('login')->middleware('guest');

Route::post('/signup', [WebAuthController::class, 'signup'])->name('signup');

// Login
Route::post('/login', [WebAuthController::class, 'login'])->name('login');

// Logout
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

Route::post('/language-switch', [WebLanguageController::class, 'ajaxSwitch'])->name('lang.ajaxSwitch');

