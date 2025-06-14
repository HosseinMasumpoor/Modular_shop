<?php

    declare(strict_types=1);

namespace Modules\Core\Enums;


use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ResponseCode extends Enum
{
    const WRONG_CODE = 422;
    const MANY_REQUEST = 405;
    const NOT_FOUND_DATA = 404;
    const DUPLICATE_ENTRIES = 406;
    const TO_MANY_SELECT = 420;
    const NOT_COMPLETE_PROFILE = 432;
    const NOT_ACCESS = 403;
    const FAILED_PAY = 312;
    const INVALID_PAYMENT = 419;
    const NOT_FOUND_TRANSACTION = 421;
    const  DISCOUNT_USED = 422;
    const  WRONG_INFO = 443;
    const  NOT_CONFIRM = 512;
    const ACCEPTED = 202;
    const OK = 200;
    const SERVER_ERROR = 500;
    const CREATED = 201;
}
