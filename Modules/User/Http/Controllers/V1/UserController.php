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
    public function __construct(private readonly UserService $service)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user/me",
     *     summary="Get authenticated user info",
     *     description="Returns the currently authenticated user information.",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated user data",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example=""),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john@example.com"),
     *                 @OA\Property(property="mobile", type="string", example="09123456789"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */

    public function me(){
        $user = auth('user')->user();
        return successResponse($user);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/user/complete-profile",
     *     summary="Complete profile and activate account",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CompleteProfile")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Login successful or OTP sent")
     *          )
     *     )
     * )
     */

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
