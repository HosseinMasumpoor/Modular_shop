<?php

namespace Modules\User\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Exceptions\AuthException;
use Modules\User\Http\Requests\V1\Auth\LoginRequest;
use Modules\User\Http\Requests\V1\Auth\VerifyOTPRequest;
use Modules\User\Models\User;
use Modules\User\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $service){}



    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="user login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(ref="#/components/schemas/LoginWithEmail"),
     *                 @OA\Schema(ref="#/components/schemas/LoginWithMobile"),
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="email or password is invalid"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Please fill all fields"
     *     )
     * )
     */

    public function login(LoginRequest $request){
        $data = $request->validated();
        try {
            if(isset($data["mobile"])){
                $result = $this->service->loginUsingOTP($data["mobile"]);
                return successResponse($result, __("user::messages.otp_sent"));
            }else{
                $token = $this->service->loginUsingEmail($data["email"], $data["password"]);
                return authSuccessResponse($token, config('sanctum.expiration'), __("user::messages.login_successful"));
            }
        }catch (AuthException $e){
            return failedResponse($e->getMessage(), $e->getCode());
        }
    }

    public function verifyOTP(VerifyOTPRequest $request){
        $data = $request->validated();
        try {
            $data = $this->service->verifyOTP($data["mobile"], $data["code"]);
            $token = $data["token"];
            $message = $data["registered"] ? __("user::messages.complete_profile") : __("user::messages.login_successful");
            return authSuccessResponse("Bearer $token", config('sanctum.expiration'), $message);
        }catch (AuthException $e){
            return failedResponse($e->getMessage(), $e->getCode());
        }
    }



}
