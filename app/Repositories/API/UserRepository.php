<?php
namespace App\Repositories\API;

use App\Models\User;
use App\Repositories\API\UserRepositoryInterface;


class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data)
    {

        return User::create($data);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function updateOtp(string $email, int $otp)
    {
        return User::where('email', $email)->update(['otp' => $otp]);
    }
    public function createOrUpdateSocialUser(array $data)
    {


        $user = $this->findByEmail($data['email']);

        $providerField = $data['provider_field'];
        $data[$providerField] = $data['social_id'];

        unset($data['social_id']);
        unset($data['provider_field']);

        if ($user) {
            $user->update($data);
            return $user;
        }

        return User::create($data);


    }
}
