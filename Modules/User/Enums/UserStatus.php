<?php

namespace Modules\User\Enums;

use BenSampo\Enum\Enum;

final class UserStatus extends Enum
{
    const INACTIVE = "inactive";
    const ACTIVE = "active";
    const BLOCKED = "blocked";
}

enum UserStatusS: string
{
    case ACTIVE = "active";
    case INACTIVE = "inactive";
    case BLOCKED = "blocked";
}

UserStatusS::ACTIVE;
