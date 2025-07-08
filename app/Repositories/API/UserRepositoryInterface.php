<?php
namespace App\Repositories\API;
use App\Models\User;
interface UserRepositoryInterface
{
    public function createUser(array $data);
    public function findByEmail(string $email);
    public function updateOtp(string $email, int $otp);
    public function createOrUpdateSocialUser(array $data);

    //DOCUMENT VERIFICATION
    public function updateVerificationImages(User $user, array $paths, string $type);
    public function confirmVerification(User $user);
    public function getVerificationStatus(User $user);
}
