<?php

namespace Modules\Core\Filter;

use Closure;
use Illuminate\Support\Str;

abstract class Filter
{
    public function handle($request, Closure $next){
        if(!$request->has($this->filterName())){
            return $next($request);
        }

        $builder = $next($request);
        return $this->applyFilter($builder);
    }

    abstract protected function applyFilter($builder);

    private function filterName(): string
    {
        return Str::snake(class_basename($this));
    }
}
