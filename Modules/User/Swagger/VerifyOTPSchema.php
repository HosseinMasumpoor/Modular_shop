<?php

namespace Modules\User\Swagger;

/**
 * @OA\Schema(
 *     schema="VerifyOTP",
 *     required={"mobile", "code"},
 *     @OA\Property(property="mobile", type="string", example="09121231212"),
 *     @OA\Property(property="code", type="string", example="123456")
 * )
 */

class VerifyOTPSchema
{

}
