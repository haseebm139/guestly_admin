<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\SocialAuthRequest;
use App\Http\Requests\API\Auth\VerifyEmailRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;

class AuthController extends BaseController
{
    protected $authService;

    public function __construct(AuthService $authService)
    {

        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {

        $user = $this->authService->register($request->validated());
        $data['token'] = $user['token'];
        $data['name'] = Str::upper($user['user']['name']);
        $data['user'] = $user['user'];

        return $this->sendResponse($data, 'User Register Successfully');

    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
            'code' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        if (! $this->authService->resetPassword($request->email, $request->code, $request->password)) {
            return $this->sendError('Invalid or expired code');
        }

        return $this->sendResponse([], 'Password updated successfully');
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authService->login($request->validated());

            if (isset($user['status']) && $user['status'] === 'error') {
                return $this->sendError('This email is already registered as a '.$user['data']);
            }

            return $this->sendResponse($user, 'Login Successfully');
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage() ?: 'Login failed.');
        }
    }

    public function autoLoginOrRegister(LoginRequest $request)
    {

        $result = $this->authService->autoLoginOrRegister($request->only('name', 'email', 'password', 'latitude', 'longitude', 'user_type'));
        $data = $result['data'];

        if ($result['status'] === 'login') {
            return $this->sendResponse($data, 'Login successful');
        } elseif ($result['status'] === 'register') {
            return $this->sendResponse($data, 'User registered and logged in successfully');
        } elseif ($result['status'] === 'errorUserType') {
            return $this->sendError('This email is already registered as a '.$data);
        } else {

            return $this->sendError('Invalid credentials. Please check your email or password.');
        }

        return $this->sendError('Authentication failed.');
    }

    public function googleLogin(SocialAuthRequest $request)
    {
        $data = $request->validated();
        $data['provider'] = 'google';

        return $this->authService->handleSocialLogin($data);
    }

    public function facebookLogin(SocialAuthRequest $request)
    {
        $data = $request->validated();
        $data['provider'] = 'facebook';

        return $this->authService->handleSocialLogin($data);
    }

    public function appleLogin(SocialAuthRequest $request)
    {
        $data = $request->validated();
        $data['provider'] = 'apple';

        return $this->authService->handleSocialLogin($data);
    }

    public function sendCodeToEmail(VerifyEmailRequest $request)
    {
        return $this->authService->sendOtpToEmail($request->all());
    }

    public function profile()
    {
        $user = auth()->user();

        return $this->sendResponse($user, 'Profile fetched successfully');
    }

    public function deleteAccount(Request $request)
    {
          $user = $request->user();

        if (! $user) {
            return $this->sendError('User not found.');
        }
        
        $user->delete(); // soft delete (sets deleted_at timestamp)

        if (method_exists($user, 'tokens')) {
            $user->tokens()->delete(); 
        }

        return $this->sendResponse([], 'Account has been deleted successfully.');

    }
}
