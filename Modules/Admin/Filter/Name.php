<?php

namespace Modules\Admin\Filter;

use Modules\Core\Filter\Filter;

class Name extends Filter
{

    protected function applyFilter($builder)
    {
        return $builder->where('name','like', '%' . request($this->filterName()) . '%');

    }
}
