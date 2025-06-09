<?php

namespace Modules\User\Swagger;

/**
 * @OA\Schema(
 *     schema="LoginRequest",
 *     oneOf={
 *         @OA\Schema(
 *             required={"mobile"},
 *             @OA\Property(property="mobile", type="string", example="09121234567")
 *         ),
 *         @OA\Schema(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="12345678")
 *         )
 *     }
 * )
 */

class LoginSchema
{

}
