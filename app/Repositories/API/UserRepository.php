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

    public function updateVerificationImages(User $user, array $paths, string $type)
    {
        $user->verification_type = $type;

        if (isset($paths['front'])) {
            $user->document_front = $paths['front'];
        }

        if (isset($paths['back'])) {
            $user->document_back = $paths['back'];
        }

        $user->verification_status = '0';

        $user->save();

        return $user;
    }


    public function confirmVerification(User $user)
    {
        $user->verification_status = '1';
        $user->save();

        return $user;
    }

    public function getVerificationStatus(User $user)
    {

        return [
            'status' => $user->verification_status,
            'type' => $user->verification_type,
            'front' => $user->document_front,
            'back' => $user->document_back,
        ];
    }
}
