<?php

namespace Modules\FAQ\Cache;

use Illuminate\Support\Facades\Cache;
use Modules\FAQ\Repositories\FAQRepository;

class FAQCache
{
    const LIST_CACHE_KEY = 'FAQ:list';

    public static function getAllFAQs()
    {
        if(!Cache::has(self::LIST_CACHE_KEY)){
            self::setAllFAQs();
        }
        return Cache::get(self::LIST_CACHE_KEY);
    }

    public static function setAllFAQs(): bool
    {
        $repository = app(FAQRepository::class);
        $data = $repository->index()->get();
        return Cache::put(self::LIST_CACHE_KEY, $data);
    }

}
