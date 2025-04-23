<?php

namespace Modules\User\traits;

trait LoginField
{
    public function getLoginField($value)
    {
        if(preg_match('/^(?:\+98|0)?9\d{9}$/', $value)){

        }
    }
}
