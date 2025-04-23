<?php

namespace Modules\User\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\User\Exceptions\AuthException;

class OTPService
{
    // TODO: move cache key and otp expires time to config
    const CACHE_KEY_PREFIX = 'user_mobile_';
    const OTP_EXPIRES_IN = 60;
    public  function send($mobile): array
    {
        if($this->checkIsSent($mobile)){
            throw AuthException::otpAlreadySent();
        }

        $code = random_int(100000, 999999);
        $result = Cache::put(self::CACHE_KEY_PREFIX.$mobile, $code, self::OTP_EXPIRES_IN);
        //TODO: Send otp code by SMS
        Log::info("Sending OTP to mobile number $mobile : $code");

        return [
            'expires_in' => self::OTP_EXPIRES_IN,
        ];
    }

    public function verify($mobile,$otp): bool
    {
        $cacheKey = self::CACHE_KEY_PREFIX.$mobile;
        if(Cache::get($cacheKey) == $otp){
            Cache::forget($cacheKey);
            return true;
        }
        return false;
    }

    private function checkIsSent($mobile): bool
    {
        return Cache::has(self::CACHE_KEY_PREFIX.$mobile);
    }
}
