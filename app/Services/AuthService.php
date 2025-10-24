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
        $result['token'] =  $token;
        $result['user'] =  $user;
        return $result;
    }

    public function login(array $credentials)
    {

        $data['user'] = $this->userRepo->findByEmail($credentials['email']);
         
        if (! $data['user'] || ! Hash::check($credentials['password'], $data['user']->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }
         
        // if (isset($credentials['user_type'])) {
        //     # code...
        //     if ($credentials['user_type'] !== $data['user']->user_type) {
        //         return [
        //             'status' => 'error',
        //             'data'   => $data['user']->user_type
        //         ];
        //     }
        // }
        
        if ($data['user']->is_active == 0) {
            return [
                'status'  => 'error',
                'data' => 'Your account has been deactivated. Please contact support.'
            ];
        }

        if (isset($credentials['latitude']) && isset($credentials['longitude'])) {
            $data['user']->latitude = $credentials['latitude'];
            $data['user']->longitude = $credentials['longitude'];
            $data['user']->save();
        }
        if(isset($credentials['fcm_token']) ){
            $data['user']->fcm_token = $credentials['fcm_token'];
            $data['user']->save();
        }
        $data['token'] = $data['user']->createToken('guestly')->plainTextToken;

        return $data;

    }

    public function autoLoginOrRegister(array $request)
    {

        $user = $this->userRepo->findByEmail($request['email']);


        if ($user && Hash::check($request['password'], $user->password)) {
            if ( $request['user_type'] !== $user->user_type) {
                return [
                    'status' => 'errorUserType',
                    'data' => $user->user_type
                ];
            }
            if (isset($request['latitude']) && isset($request['longitude'])) {
                $user->latitude = $request['latitude'];
                $user->longitude = $request['longitude'];
                $user->save();
            }
            $token = $user->createToken('guestly')->plainTextToken;

            return [
                'status' => 'login',
                'data' => [
                    'token' => $token,
                    'name' => Str::upper($user->name),
                    'user' => $user,
                ]
            ];
        } elseif (!$user) {
            // New user registration
            $request['password'] = Hash::make($request['password']);
            $request['latitude'] = $request['latitude'] ?? null;
            $request['role_id'] = $request['user_type'] ?? null;
            $request['longitude'] = $request['longitude'] ?? null;

            $newUser = $this->userRepo->createUser($request);
            $token = $newUser->createToken('guestly')->plainTextToken;

            return [
                'status' => 'register',
                'data' => [
                    'token' => $token,
                    'name' => Str::upper($newUser->name),
                    'user' => $newUser,
                ]
            ];
        } else {
            return [
                'status' => 'error',
                'data' => []
            ];
        }
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
                    'user'  => $user

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
    public function resetPassword(string $email, string $code, string $password): bool
    {
        // Check if code is valid
        if (!$this->userRepo->verifyCode($email, $code)) {
            return false;
        }

        // Update password
        return $this->userRepo->updatePassword($email, $password);
    }


}
