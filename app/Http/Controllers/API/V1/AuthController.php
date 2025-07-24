<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\SocialAuthRequest;
use App\Http\Requests\API\Auth\VerifyEmailRequest;

use App\Services\AuthService;
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
        $data['name'] =Str::upper($user['user']['name']);
        return $this->sendResponse($data,"User Register Successfully");



    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authService->login($request->validated());
            $data['token'] = $user['token'];
            $data['name'] =Str::upper($user['user']['name']);
            return $this->sendResponse($data, 'Login Successfully');
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage() ?: 'Login failed.');
        }
    }

    public function autoLoginOrRegister(LoginRequest $request)
    {


        $result = $this->authService->autoLoginOrRegister($request->only('name', 'email', 'password'));

        if ($result['status'] === 'login') {
            return $this->sendResponse($result['data'], 'Login successful');
        } elseif ($result['status'] === 'register') {
            return $this->sendResponse($result['data'], 'User registered and logged in successfully');
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
}
