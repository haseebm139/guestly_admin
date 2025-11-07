<?php

namespace App\Http\Controllers\Web\Artist;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Factory;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    protected $database;
    protected $auth;
    public function explore()
    {
        return view('user.dashboard.artist.explore', [
            'pageTitle' => __('explore_heading')
        ]);
    }

    public function studioDetail()
    {
        return view('user.dashboard.artist.studio_detail', [
            'pageTitle' => __('explore_heading')
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

    public function profile()
    {
        $user = Auth::user();
        return view('user.dashboard.artist.artist_profile',compact('user'), [
            'pageTitle' => __('profile_heading')
        ]);
    }

    public function artistProfileUpdate(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'emergency_phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Avatar upload using your preferred method
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('artists/avatar', 'public');
            $validated['avatar'] = $path;
        }

        // Update user data
        $user->update([
            'name' => $validated['name'] ?? $user->name,
            'country' => $validated['country'] ?? $user->country,
            'address' => $validated['address'] ?? $user->address,
            'phone' => $validated['phone'] ?? $user->phone,
            'emergency_phone' => $validated['emergency_phone'] ?? $user->emergency_phone,
            'avatar' => $validated['avatar'] ?? $user->avatar,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }


    public function security()
    {
        return view('user.dashboard.artist.artist_security', [
            'pageTitle' => __('profile_heading')
        ]);
    }

    public function bio()
    {
        return view('user.dashboard.artist.artist_bio', [
            'pageTitle' => __('profile_heading')
        ]);
    }

    public function subscription()
    {
        return view('user.dashboard.artist.artist_subscription', [
            'pageTitle' => __('profile_heading')
        ]);
    }

    public function rating()
    {
        return view('user.dashboard.artist.artist_rating', [
            'pageTitle' => __('profile_heading')
        ]);
    }

    public function payment()
    {
        return view('user.dashboard.artist.artist_payment', [
            'pageTitle' => __('profile_heading')
        ]);
    }

    public function booking()
    {
        return view('user.dashboard.artist.artist_booking', [
            'pageTitle' => __('bookings_heading')
        ]);
    }

    public function guestSpot()
    {
        return view('user.dashboard.artist.artist_guest_spot', [
            'pageTitle' => __('bookings_heading')
        ]);
    }

    public function request()
    {
        return view('user.dashboard.artist.artist_request', [
            'pageTitle' => __('requests_heading')
        ]);
    }

    public function tattoo()
    {
        return view('user.dashboard.artist.artist_tattoo', [
            'pageTitle' => __('flash_tattoos_heading')
        ]);
    }
}
