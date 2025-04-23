<?php

namespace Modules\Category\Cache;

use Illuminate\Support\Facades\Cache;
use Modules\Category\Repositories\CategoryRepository;

class CategoryCache
{
    const CACHE_KEY = 'categories';
    public static function getAllCategories()
    {
        if(!Cache::has(self::CACHE_KEY)){
            self::setAllCategories();
        }
        return Cache::get(self::CACHE_KEY);
    }

    public static function setAllCategories(): bool
    {
        $repository = app(CategoryRepository::class);
        $data = $repository->index()->get();
        return Cache::put(self::CACHE_KEY, $data);
    }
}
