<?php

namespace Modules\User\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Modules\User\Exceptions\AuthException;
use Modules\User\Repositories\UserRepository;

class AuthService
{
    public function __construct(protected UserRepository $repository, protected OTPService $otpService){}

    public function loginUsingEmail(string $email, string $password): string
    {
        $user = $this->repository->findByField("email", $email);
        if(!$user || !Hash::check($password, $user->password)){
            throw AuthException::invalidCredentials();
        }
        return $this->generateToken($user);
    }

    public function loginUsingOTP(string $mobile): array
    {
        return $this->otpService->send(convertToValidMobileNumber($mobile));
    }

    public function verifyOTP(string $mobile, string $code){
        $registered = false;
        $mobile = convertToValidMobileNumber($mobile);
        $result = $this->otpService->verify($mobile, $code);
        if(!$result){
            throw AuthException::otpInvalid();
        }

        $user = $this->repository->findByField("mobile", $mobile);
        if(!$user){
            $user = $this->repository->newItem([
                "mobile" => $mobile,
            ]);
            $registered = true;
        }

        $token = $this->generateToken($user);

        return [
            "token" => $token,
            "registered" => $registered
        ];
    }

    private function generateToken($user): string
    {
        return $user->createToken('authTokenUser')->plainTextToken;
    }
}
