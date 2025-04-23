<?php

namespace Modules\User\Swagger;

/**
 * @OA\Schema(
 *  schema="LoginWithEmail",
 *  title="Login using email and password",
 *  required={"email", "password"},
 * 	@OA\Property(
 * 		property="email",
 * 		type="string",
 *      format="email",
 *      example="user@example.com"
 * 	),
 * 	@OA\Property(
 * 		property="password",
 * 		type="string",
 *      example="12345678"
 * 	)
 * )
 */

/**
 * @OA\Schema(
 *  schema="LoginWithMobile",
 *  title="Login using mobile and get OTP",
 *  required={"mobile"},
 * 	@OA\Property(
 * 		property="mobile",
 * 		type="string",
 *      example="09121231212"
 * 	)
 * )
 */
class AuthSchema
{

}
