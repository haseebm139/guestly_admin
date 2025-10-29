<?php

namespace App\Http\Controllers\Web\Studio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class StudioController extends Controller
{
    public function home()
    {
        return view('user.dashboard.studio.studio_home', [
            'pageTitle' => __('studio_dashboard_heading')
        ]);
    }

    public function chat()
    {
        try {
            $factory = (new Factory)
                ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
                ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

            $database = $factory->createDatabase();
            $auth = $factory->createAuth();

            $user = auth()->user();
            if (!$user) {
                return redirect('/login');
            }

            $firebaseToken = null;
            $currentFirebaseUid = null;

            $role = strtolower($user->role_id);
            $businessId = $user->id;
//            $role = 'studio';
//            $businessId = 26;

            if ($role && $businessId) {
                $path = "business_uid/{$role}/{$businessId}";
                $uids = $database->getReference($path)->getValue();

                if (!empty($uids)) {
                    $firebaseUid = array_key_first($uids);
                    $customToken = $auth->createCustomToken($firebaseUid);

                    $firebaseToken = $customToken->toString();
                    $currentFirebaseUid = $firebaseUid;

                    $database->getReference("users/{$firebaseUid}")->update([
                        'isOnline' => true,
                        'lastActive' => ['.sv' => 'timestamp'],
                    ]);
                }
            }

            return view('user.dashboard.studio.studio_chat', [
                'firebaseToken' => $firebaseToken,
                'currentUser' => $user,
                'currentFirebaseUid' => $currentFirebaseUid,
                'pageTitle' => __('messages_heading')
            ]);

        } catch (\Throwable $e) {
            if (env('APP_DEBUG', false)) {
                return "<h1>An Unexpected Error Occurred</h1><h2>" . $e->getMessage() . "</h2><pre>" . $e->getTraceAsString() . "</pre>";
            } else {
                return "<h1>Error</h1><p>Something went wrong while connecting to the chat service. Please try again later.</p>";
            }
        }
    }

    public function searchArtist()
    {
        return view('user.dashboard.studio.studio_search_artist', [
            'pageTitle' => __('studio_guest_artist_search_heading')
        ]);
    }
    public function studioRequest()
    {
        return view('user.dashboard.studio.studio_request', [
            'pageTitle' => __('studio_guest_artist_request_heading')
        ]);
    }
    public function studioSubscription()
    {
        return view('user.dashboard.studio.studio_subscription', [
            'pageTitle' => __('profile_heading')
        ]);
    }
    public function studioAvailability()
    {
        return view('user.dashboard.studio.studio_availability', [
            'pageTitle' => __('profile_heading')
        ]);
    }
    public function studioPromotion()
    {
        return view('user.dashboard.studio.studio_promotion', [
            'pageTitle' => __('profile_heading')
        ]);
    }

    public function profile()
    {
        return view('user.dashboard.studio.studio_profile', [
            'pageTitle' => __('profile_heading')
        ]);
    }

    public function rating()
    {
        return view('user.dashboard.studio.studio_rating', [
            'pageTitle' => __('profile_heading')
        ]);
    }

    public function payment()
    {
        return view('user.dashboard.studio.studio_payment', [
            'pageTitle' => __('profile_heading')
        ]);
    }

    public function security()
    {
        return view('user.dashboard.studio.studio_security', [
            'pageTitle' => __('profile_heading')
        ]);
    }
}
