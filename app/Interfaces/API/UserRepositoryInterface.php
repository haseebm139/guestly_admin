<?php
namespace App\Interfaces\API;

interface UserRepositoryInterface
{
    public function createUser(array $data);
    public function findByEmail(string $email);
    public function updateOtp(string $email, int $otp);
    public function createOrUpdateSocialUser(array $data);
}
