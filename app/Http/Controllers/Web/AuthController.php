<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string',
        ]);

        $roleName = $request->query('role', 'artist');

        $roleId = ($roleName === 'studio') ? 'studio' : 'artist';

        $user = User::create([
            'name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'country' => $request->country_region,
            'phone' => $request->phone_number,
            'role_id' => $roleId,
            'user_type' => $roleId,
        ]);

        Auth::login($user);

        if ($roleName === 'artist') {
            return redirect()->route('choose_plan');
        } else {
            return redirect()->route('studio_choose_plan');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|string',
        ]);

        $requestedRole = strtolower($request->input('role'));
        $validRoles = ['artist', 'studio'];

        if (!in_array($requestedRole, $validRoles)) {
            return back()->withErrors([
                'email' => 'Please select a valid role: Artist or Studio.',
            ])->onlyInput('email');
        }

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ])) {
            $request->session()->regenerate();

            $user = Auth::user();
            $userRole = strtolower($user->role_id);

            if ($userRole !== $requestedRole) {
                Auth::logout();
                return back()->withErrors([
                    'email' => "You cannot log in as $requestedRole with these credentials.",
                ])->onlyInput('email');
            }

            // ✅ Save Latitude & Longitude on login
            if ($request->filled('latitude') && $request->filled('longitude')) {
                $user->latitude = $request->latitude;
                $user->longitude = $request->longitude;
                $user->save();
            }

            // Redirect user according to role
            if ($userRole === 'artist') {
                return redirect()->intended(route('dashboard.explore'));
            } elseif ($userRole === 'studio') {
                return redirect()->intended(route('dashboard.studio_home'));
            }
        }

        // if login fail
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        $role = Auth::user()->role_id ?? null;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role == 'artist') {
            return redirect()->route('login', ['role' => 'artist']);
        } elseif ($role == 'studio') {
            return redirect()->route('login', ['role' => 'studio']);
        }
        return redirect()->route('login');
    }

}
