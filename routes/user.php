 <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController as WebAuthController;
use App\Http\Controllers\Web\LanguageController as WebLanguageController;
use App\Http\Controllers\Web\WebsiteController;
use App\Http\Controllers\Web\Artist\ArtistController as WebArtistController;
use App\Http\Controllers\Web\Studio\StudioController as WebStudioController;
use App\Http\Controllers\Web\Stripe\StripePaymentController as WebStripePaymentController;
use App\Http\Controllers\Web\Chat\ChatController as WebChatController;


Route::get('/', function () {
    return view('user.welcome');
});

 Route::middleware('guest')->group(function () {

     Route::get('form_slider', [WebsiteController::class, 'formSlider'])->name('form_slider');
     Route::get('form_slider_two', [WebsiteController::class, 'formSliderTwo'])->name('form_slider_two');
     Route::get('form_login_signup', [WebsiteController::class, 'formLoginSignup'])->name('form_login_signup');
//Route::get('choose_plan', [WebsiteController::class, 'choosePlan'])->name('choose_plan');
//Route::get('studio_choose_plan', [WebsiteController::class, 'studioChoosePlan'])->name('studio_choose_plan');
//Route::get('user_identification', [WebsiteController::class, 'userIdentification'])->name('user_identification');
//Route::get('doc_verification', [WebsiteController::class, 'docVerification'])->name('doc_verification');
//Route::get('phone_email_verification', [WebsiteController::class, 'phoneEmailVerification'])->name('phone_email_verification');
//Route::get('studio_step_form', [WebsiteController::class, 'studioStepForm'])->name('studio_step_form');
//Route::get('boost_studio', [WebsiteController::class, 'boostStudio'])->name('boost_studio');
     Route::get('forgot_password', [WebsiteController::class, 'forgotPassword'])->name('forgot_password');
     Route::get('reset_password', [WebsiteController::class, 'resetPassword'])->name('reset_password');
     Route::get('verify_otp', [WebsiteController::class, 'verifyOtp'])->name('verify_otp');
     Route::post('forgot_password_submit', [WebsiteController::class, 'forgotPasswordSubmit'])->name('forgot_password_submit');
     Route::post('verify_otp_submit', [WebsiteController::class, 'verifyOtpSubmit'])->name('verify_otp_submit');
     Route::post('reset_password_submit', [WebsiteController::class, 'resetPasswordSubmit'])->name('reset_password_submit');
     Route::post('resend_otp', [WebsiteController::class, 'resendOtp'])->name('resend_otp');
 });

// -- Artist Dashboard Routes

 Route::middleware(['auth', 'ensure.verified'])->group(function () {

     // ------------------------------------------------------------------
     // Route #1: Logout
     // Yeh hamesha kaam karna chahiye, chahe user ka status kuch bhi ho.
     // Humari middleware ki logic isko hamesha allow karti hai.
     // ------------------------------------------------------------------
     Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');


     // ------------------------------------------------------------------
     // Route #2: Onboarding, Verification, aur Payment ke Routes
     // User ko in pages par uske status ke hisab se bheja jayega.
     // Middleware inko pichle steps par wapas jaane se bhi rokega.
     // ------------------------------------------------------------------
     Route::get('choose_plan', [WebsiteController::class, 'choosePlan'])->name('choose_plan');
     Route::get('user_identification', [WebsiteController::class, 'userIdentification'])->name('user_identification');
     Route::get('studio_step_form', [WebsiteController::class, 'studioStepForm'])->name('studio_step_form');
     Route::get('boost_studio', [WebsiteController::class, 'boostStudio'])->name('boost_studio');
     Route::post('verify-documents', [WebsiteController::class, 'verifyDocuments'])->name('verify.documents');
     Route::post('generate-otp', [WebsiteController::class, 'generateOtp'])->name('generate.otp');
     Route::post('auth-verify-otp', [WebsiteController::class, 'authVerifyOtpSubmit'])->name('auth.verify.otp');
     Route::post('auth-resend-otp', [WebsiteController::class, 'authResendOtp'])->name('auth.resend.otp');
     Route::post('auth-verify-phone', [WebsiteController::class, 'authVerifyPhone'])->name('auth.verify.phone');
     // Stripe Payment Routes
     Route::post('/stripe/create-payment-intent', [WebStripePaymentController::class, 'createPaymentIntent'])->name('stripe.create_intent');
     Route::post('/stripe/confirm-payment', [WebStripePaymentController::class, 'confirmPayment'])->name('stripe.confirm_payment');

//     Route::get('/chat', [WebChatController::class, 'showChat'])->name('chat.show');
     Route::post('/send-message', [WebChatController::class, 'sendMessage'])->name('chat.send');


     // ------------------------------------------------------------------
     // Route #3: Main Dashboard Routes
     // In pages par user tab hi aa sakta hai jab uska status 2 (complete) ho.
     // Agar status 0 ya 1 hoga, toh middleware usko upar wale pages par bhej dega.
     // ------------------------------------------------------------------

     // -- Artist Dashboard Routes
     Route::middleware('role:artist')->prefix('dashboard')->name('dashboard.')->group(function () {
         Route::get('/explore', [WebArtistController::class, 'explore'])->name('explore');
         Route::get('/studio_detail', [WebArtistController::class, 'studioDetail'])->name('studio_detail');
         Route::get('/artist_chat', [WebArtistController::class, 'chat'])->name('artist_chat');
         Route::get('/artist_profile', [WebArtistController::class, 'profile'])->name('artist_profile');
         Route::get('/artist_security', [WebArtistController::class, 'security'])->name('artist_security');
         Route::get('/artist_bio', [WebArtistController::class, 'bio'])->name('artist_bio');
         Route::get('/artist_subscription', [WebArtistController::class, 'subscription'])->name('artist_subscription');
         Route::get('/artist_rating', [WebArtistController::class, 'rating'])->name('artist_rating');
         Route::get('/artist_payment', [WebArtistController::class, 'payment'])->name('artist_payment');
         Route::get('/artist_booking', [WebArtistController::class, 'booking'])->name('artist_booking');
         Route::get('/artist_guest_spot', [WebArtistController::class, 'guestSpot'])->name('artist_guest_spot');
         Route::get('/artist_request', [WebArtistController::class, 'request'])->name('artist_request');
         Route::get('/artist_tattoo', [WebArtistController::class, 'tattoo'])->name('artist_tattoo');
         Route::get('/create-test-chat/{artistId}/{studioId}', [WebArtistController::class, 'createTestChat'])->name('test.chat.create');
     });

     // -- Studio Dashboard Routes
     Route::middleware('role:studio')->prefix('dashboard')->name('dashboard.')->group(function () {
         Route::get('/studio_home', [WebStudioController::class, 'home'])->name('studio_home');
         Route::get('/studio_chat', [WebStudioController::class, 'chat'])->name('studio_chat');
//         Route::get('/artist_chat', [WebStudioController::class, 'chat'])->name('artist_chat');

         Route::get('/studio_search_artist', [WebStudioController::class, 'searchArtist'])->name('studio_search_artist');
         Route::get('/studio_request', [WebStudioController::class, 'studioRequest'])->name('studio_request');
         Route::get('/studio_profile', [WebStudioController::class, 'profile'])->name('studio_profile');
         Route::get('/studio_subscription', [WebStudioController::class, 'studioSubscription'])->name('studio_subscription');
         Route::get('/studio_availability', [WebStudioController::class, 'studioAvailability'])->name('studio_availability');
         Route::get('/studio_promotion', [WebStudioController::class, 'studioPromotion'])->name('studio_promotion');
         Route::get('/studio_rating', [WebStudioController::class, 'rating'])->name('studio_rating');
         Route::get('/studio_payment', [WebStudioController::class, 'payment'])->name('studio_payment');
         Route::get('/studio_security', [WebStudioController::class, 'security'])->name('studio_security');
     });

     // -- Common Dashboard Routes (Notification, etc.)
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
//Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

Route::post('/language-switch', [WebLanguageController::class, 'ajaxSwitch'])->name('lang.ajaxSwitch');

