<?php

namespace App\Http\Controllers\Web\Artist;

use App\Http\Controllers\Controller;
use App\Models\User;
use Kreait\Firebase\Factory;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    protected $database;
    protected $auth;
    public function explore()
    {
        return view('user.dashboard.artist.explore', [
            'pageTitle' => 'Explore'
        ]);
    }

    public function studioDetail()
    {
        return view('user.dashboard.artist.studio_detail', [
            'pageTitle' => 'Explore'
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

            return view('user.dashboard.artist.artist_chat', [
                'firebaseToken' => $firebaseToken,
                'currentUser' => $user,
                'currentFirebaseUid' => $currentFirebaseUid,
                'pageTitle' => 'Messages'
            ]);

        } catch (\Throwable $e) {
            if (env('APP_DEBUG', false)) {
                return "<h1>An Unexpected Error Occurred</h1><h2>" . $e->getMessage() . "</h2><pre>" . $e->getTraceAsString() . "</pre>";
            } else {
                return "<h1>Error</h1><p>Something went wrong while connecting to the chat service. Please try again later.</p>";
            }
        }
    }

    public function profile()
    {
        return view('user.dashboard.artist.artist_profile', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function security()
    {
        return view('user.dashboard.artist.artist_security', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function bio()
    {
        return view('user.dashboard.artist.artist_bio', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function subscription()
    {
        return view('user.dashboard.artist.artist_subscription', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function rating()
    {
        return view('user.dashboard.artist.artist_rating', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function payment()
    {
        return view('user.dashboard.artist.artist_payment', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function booking()
    {
        return view('user.dashboard.artist.artist_booking', [
            'pageTitle' => 'Bookings'
        ]);
    }

    public function guestSpot()
    {
        return view('user.dashboard.artist.artist_guest_spot', [
            'pageTitle' => 'Bookings'
        ]);
    }

    public function request()
    {
        return view('user.dashboard.artist.artist_request', [
            'pageTitle' => 'Requests'
        ]);
    }

    public function tattoo()
    {
        return view('user.dashboard.artist.artist_tattoo', [
            'pageTitle' => 'Flash Tattoos'
        ]);
    }
}
