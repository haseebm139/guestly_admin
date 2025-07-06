<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Interfaces\API\UserRepositoryInterface;
use App\Http\Controllers\API\BaseController as BaseController;
use Str;
use Auth;
class AuthService extends BaseController
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(array $data)
    {

        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepo->createUser($data);

        // $token = $user->createToken('guestly')->accessToken;

        return compact('user');
    }

    public function login(array $credentials)
    {
        $user = $this->userRepo->findByEmail($credentials['email']);

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $token = $user->createToken('guestly')->accessToken;

        return compact('user', 'token');
    }



    public function handleSocialLogin(array $data)
    {

        try {
            $providerField = $data['provider'] . '_id';

            $user = $this->userRepo->createOrUpdateSocialUser([
                'name' => $data['name'],
                'email' => $data['email'],
                'social_id' => $data['social_id'],
                'provider_field' => $providerField,
                'password' =>Hash::make($data['social_id']),
            ]);

            if (Auth::attempt(['email' => $user['email'], 'password' => $data['social_id']])) {
                $user = Auth::user();
                $success = [
                    'token' => $user->createToken('guestly')->accessToken,
                    'name'  => Str::upper($user['name']),

                ];
                return $this->sendResponse($success, 'User login successful.');
            }

            return $this->sendError('Authentication failed.');

        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong.', [$e->getMessage()]);
        }
    }
}
