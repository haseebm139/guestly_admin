<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class FirebaseAuthController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function customToken(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $claims = [
            'email' => $user->email,
            'role' => $user->roles->pluck('name')->first() ?? null,
        ];

        $token = $this->firebase->createCustomToken((string) $user->id, array_filter($claims));

        return response()->json([
            'customToken' => $token,
        ]);
    }
}

