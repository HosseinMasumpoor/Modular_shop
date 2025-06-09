<?php

namespace Modules\Product\Enums;

use BenSampo\Enum\Enum;

final class DiscountType extends Enum
{
    const PERCENTAGE = "percentage";
    const FIXED = "fixed";
}
