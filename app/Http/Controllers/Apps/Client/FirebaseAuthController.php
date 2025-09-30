<?php

namespace App\Http\Controllers\Apps\Client;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirebaseAuthController extends Controller
{
    public function getFirebaseToken(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user) {
                // Authenticated user - use their ID
                return $this->generateTokenForUser($user);
            } else {
                // Guest user - generate a temporary token
                return $this->generateTokenForGuest($request);
            }

        } catch (\Exception $e) {
            \Log::error('Firebase token generation failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Token generation failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function generateTokenForUser($user)
    {
        $serviceAccount = $this->getServiceAccount();
        $uid = 'user_'.$user->id;

        $payload = [
            'iss' => $serviceAccount['client_email'],
            'sub' => $serviceAccount['client_email'],
            'aud' => 'https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit',
            'iat' => time(),
            'exp' => time() + 3600, // 1 hour
            'uid' => $uid,
            'claims' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'authenticated_user',
            ],
        ];

        $token = JWT::encode($payload, $serviceAccount['private_key'], 'RS256');

        return response()->json([
            'success' => true,
            'firebase_token' => $token,
            'uid' => $uid,
            'name' => $user->name ?? 'User',
            'email' => $user->email ?? '',
            'user_type' => 'authenticated',
        ]);
    }

    private function generateTokenForGuest(Request $request)
    {
        $serviceAccount = $this->getServiceAccount();

        // Generate a unique guest ID based on session or IP
        $guestId = 'guest_'.md5($request->ip().session()->getId());
        $uid = substr($guestId, 0, 28); // Firebase UID max length

        $payload = [
            'iss' => $serviceAccount['client_email'],
            'sub' => $serviceAccount['client_email'],
            'aud' => 'https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit',
            'iat' => time(),
            'exp' => time() + 3600, // 1 hour
            'uid' => $uid,
            'claims' => [
                'name' => 'Guest',
                'role' => 'guest_user',
            ],
        ];

        $token = JWT::encode($payload, $serviceAccount['private_key'], 'RS256');

        // Store guest ID in session for consistency
        session(['firebase_guest_id' => $uid]);

        return response()->json([
            'success' => true,
            'firebase_token' => $token,
            'uid' => $uid,
            'name' => 'Guest',
            'email' => '',
            'user_type' => 'guest',
        ]);
    }

    private function getServiceAccount1()
    {
        $credentialsPath = config('services.firebase.credentials');

        // Handle both absolute path and storage_path
        if (strpos($credentialsPath, 'storage/') === 0) {
            $credentialsPath = storage_path(str_replace('storage/', '', $credentialsPath));
        }

        if (! file_exists($credentialsPath)) {
            \Log::error('Firebase credentials not found at: '.$credentialsPath);
            throw new \Exception('Firebase credentials file not found. Please check your configuration.');
        }

        $credentials = json_decode(file_get_contents($credentialsPath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('Invalid JSON in Firebase credentials file');
            throw new \Exception('Invalid Firebase credentials file format.');
        }

        return $credentials;
    }

    private function getServiceAccount()
    {
        // Try multiple possible locations
        $possiblePaths = [
            config('services.firebase.credentials'),
            storage_path('firebase/firebase_credentials.json'),
            base_path('storage/firebase/firebase_credentials.json'),
            base_path('firebase_credentials.json'),
        ];

        $credentialsPath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $credentialsPath = $path;
                break;
            }
        }

        if (! $credentialsPath) {
            \Log::error('Firebase credentials not found in any location: '.implode(', ', $possiblePaths));
            throw new \Exception('Firebase credentials file not found. Checked: '.implode(', ', $possiblePaths));
        }

        \Log::info('Using Firebase credentials from: '.$credentialsPath);

        $credentials = json_decode(file_get_contents($credentialsPath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('Invalid JSON in Firebase credentials file: '.$credentialsPath);
            throw new \Exception('Invalid Firebase credentials file format.');
        }

        return $credentials;
    }
}
