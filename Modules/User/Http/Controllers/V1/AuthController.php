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
     *     path="/api/v1/auth/login",
     *     summary="Login user by email/password or mobile",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login or OTP sent",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login successful or OTP sent"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(property="errors", type="object")
     *         )
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

    /**
     * @OA\Post(
     *     path="/api/v1/auth/verify-code",
     *     summary="verify otp code",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VerifyOTP")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login is done and token returned",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object",
     *                  @OA\Property(property="token", type="string"),
     *                  @OA\Property(property="expires_in", type="integer")
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Invalid OTP",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean"),
     *              @OA\Property(property="message", type="string")
     *          )
     *      )
     * )
     */
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
