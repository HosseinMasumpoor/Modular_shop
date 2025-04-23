<?php

namespace Modules\User\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\CoreController;
use Modules\User\Enums\UserStatus;
use Modules\User\Http\Requests\V1\User\ChangeEmailRequest;
use Modules\User\Http\Requests\V1\User\ChangePasswordRequest;
use Modules\User\Http\Requests\V1\User\CompleteProfileRequest;
use Modules\User\Http\Requests\V1\User\SetPasswordRequest;
use Modules\User\Services\UserService;

class UserController extends CoreController
{
    public function __construct(private UserService $service)
    {
    }

    public function me(){
        $user = auth('user')->user();
        return successResponse($user);
    }

    public function completeProfile(CompleteProfileRequest $request){
        $data = $request->validated();
        $id = auth('user')->user()->id;
        $data['status'] = UserStatus::ACTIVE;
        $result = $this->service->updateProfile($id, $data);
        if($result){
            return successResponse([], __("user::messages.user.change_profile_success"));
        }
        return failedResponse(__("user::messages.user.change_profile_error"));
    }

    public function setPasswordOTP(Request $request){
        $id = auth('user')->user()->id;
        $result = $this->service->sendSetPasswordOTP($id);
        if($result){
            return successResponse([], __("user::messages.otp_sent"));
        }
        return failedResponse(__("user::messages.otp_send_error"));
    }

    public function setPassword(SetPasswordRequest $request){
        $data = $request->validated();
        $id = auth('user')->user()->id;
        try {
            $result = $this->service->setPassword($id, $data["code"], $data["password"]);
            if($result){
                return successResponse([], __("user::messages.user.change_password_success"));
            }
            return failedResponse(__("user::messages.user.change_password_error"));
        }catch (\Throwable $e){
            $code = $e->getCode() == 0 ? 500 : $e->getCode();
            return failedResponse($e->getMessage(), $code);
        }

    }

    public function changePassword(ChangePasswordRequest $request){
        $data = $request->validated();
        $id = auth('user')->user()->id;
        try {
            $result = $this->service->changePassword($id, $data["current_password"], $data["password"]);
            if($result){
                return successResponse([], __("user::messages.user.change_password_success"));
            }
            return failedResponse(__("user::messages.user.change_password_error"));
        }catch (\Throwable $e){
            $code = $e->getCode() == 0 ? 500 : $e->getCode();
            return failedResponse($e->getMessage(), $code);
        }
    }

    public function changeEmail(ChangeEmailRequest $request){
        $data = $request->validated();
        $id = auth('user')->user()->id;
        $this->service->changeEmail($id, $data["email"]);
        return successResponse([], __("user::messages.user.email_sent"));
    }

    public function changeEmailVerify(Request $request){
        if(!$request->hasValidSignature()){
            return failedResponse(__("user::messages.user.change_email_link_invalid"));
        }

        $result = $this->service->changeEmailVerify($request->query('user_id'), $request->query('email'));
        if($result){
            return successResponse([], __("user::messages.user.change_email_success"));
        }

        return failedResponse(__("user::messages.user.change_email_error"));
    }
}
