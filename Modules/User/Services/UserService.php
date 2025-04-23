<?php

namespace Modules\User\Services;

use App\Notifications\ChangeEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Modules\User\Exceptions\UserException;
use Modules\User\Jobs\SendVerificationEmailJob;
use Modules\User\Repositories\UserRepository;

class UserService
{
    public function __construct(protected UserRepository $repository, protected OTPService $otpService){}

    public function updateProfile(string $id, array $data){
        return $this->repository->updateItem($id, $data);
    }

    public function changeEmail(string $id, string $email): void
    {
        $user = $this->repository->findByField('id', $id);
        $url = URL::temporarySignedRoute('api.user.email.verify', now()->addMinutes(30), [
            'email' => $email,
            'user_id' => $user->id,
        ]);

        dispatch(new SendVerificationEmailJob($email, $url));
    }

    public function changeEmailVerify(string $id, string $email){
        return $this->repository->updateItem($id, [
            'email' => $email,
            'email_verified_at' => now(),
        ]);
    }

    public function sendSetPasswordOTP(string $id){
        $user = $this->repository->findByField('id', $id);
        return $this->otpService->send($user["mobile"]);
    }

    public function setPassword(string $id, string $code, string $password){
        $user = $this->repository->findByField('id', $id);
        $result = $this->otpService->verify($user["mobile"], $code);
        if(!$result) {
            throw UserException::invalidOTPCode();
        }
        $password = Hash::make($password);
        return $this->repository->updateItem($id, compact('password'));
    }

    public function changePassword(string $id, string $currentPassword, string $password){
        $user = $this->repository->findByField('id', $id);
        if($user->password && !Hash::check($currentPassword, $user->password)){
            throw UserException::invalidCredentials();
        }
        $password = Hash::make($password);
        return $this->repository->updateItem($id, compact('password'));
    }

}
