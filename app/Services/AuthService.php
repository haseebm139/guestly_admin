<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Repositories\API\UserRepositoryInterface;
use App\Http\Controllers\Api\BaseController as BaseController;
use Str;
use Auth;
use Validator;
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
        $data['role_id'] = $data['user_type'] ?? null;
        $data['latitude'] = $data['latitude'] ?? null;
        $data['longitude'] = $data['longitude'] ?? null;
        $user = $this->userRepo->createUser($data);
        $token = $user->createToken('guestly')->plainTextToken;

         return compact('user', 'token');
    }

    public function login(array $credentials)
    {

        $user = $this->userRepo->findByEmail($credentials['email']);

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }
        if (isset($credentials['latitude']) && isset($credentials['longitude'])) {
            $user->latitude = $credentials['latitude'];
            $user->longitude = $credentials['longitude'];
            $user->save();
        }
        $token = $user->createToken('guestly')->plainTextToken;

        return compact('user', 'token');
    }

    public function autoLoginOrRegister(array $data)
    {

        $user = $this->userRepo->findByEmail($data['email']);

        if ($user && Hash::check($data['password'], $user->password)) {
            if (isset($data['latitude']) && isset($data['longitude'])) {
                $user->latitude = $data['latitude'];
                $user->longitude = $data['longitude'];
                $user->save();
            }
            $token = $user->createToken('guestly')->plainTextToken;

            return [
                'status' => 'login',
                'data' => [
                    'token' => $token,
                    'name'  => Str::upper($user->name),
                ]
            ];
        }

        // New user registration
        $data['password'] = Hash::make($data['password']);
        $data['latitude'] = $data['latitude'] ?? null;
        $data['role_id'] = $data['user_type'] ?? null;
        $data['longitude'] = $data['longitude'] ?? null;
        $newUser = $this->userRepo->createUser($data);
        $token = $newUser->createToken('guestly')->plainTextToken;

        return [
            'status' => 'register',
            'data' => [
                'token' => $token,
                'name'  => Str::upper($newUser->name),
            ]
        ];
    }

    public function handleSocialLogin(array $data)
    {

        try {
            $providerField = $data['provider'] . '_id';

            $user = $this->userRepo->createOrUpdateSocialUser([
                'name' => $data['name'],
                'email' => $data['email'],
                'user_type' => $data['user_type'],
                'role_id' => $data['user_type'],
                'social_id' => $data['social_id'],
                'provider_field' => $providerField,
                'password' =>Hash::make($data['social_id']),
                'latitude'        => $data['latitude'] ?? null,
                'longitude'       => $data['longitude'] ?? null,
            ]);

            if (Auth::attempt(['email' => $user['email'], 'password' => $data['social_id']])) {
                $user = Auth::user();
                $success = [
                    'token' => $user->createToken('guestly')->plainTextToken,
                    'name'  => Str::upper($user['name']),

                ];
                return $this->sendResponse($success, 'User login successful.');
            }

            return $this->sendError('Authentication failed.');

        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong.', [$e->getMessage()]);
        }
    }

    public function sendOtpToEmail(array $data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user = $this->userRepo->findByEmail($data['email']);

        if (!$user) {
            return $this->sendError('Invalid Email Address');
        }

        $otp = rand(1000, 9999);
        $this->userRepo->updateOtp($data['email'], $otp);

        // Send email (assuming helper function works)
        sendVerificationMail($otp, $data['email']);

        return $this->sendResponse(['otp' => $otp], 'Code sent successfully');
    }
}
