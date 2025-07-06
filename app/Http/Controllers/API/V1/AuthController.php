<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\SocialAuthRequest;

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

        $data = $this->authService->register($request->validated());

        return $this->sendResponse($data =[],"User Register Successfully");



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
}
