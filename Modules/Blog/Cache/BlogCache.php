<?php

namespace Modules\Blog\Cache;

use Illuminate\Support\Facades\Cache;
use Modules\Blog\Repositories\BlogRepository;

class BlogCache
{
    const LIST_CACHE_KEY = 'articles:list';
    const TOP_CACHE_KEY = 'articles:top';

    public static function setAllArticles(): void
    {
        $repository = app(BlogRepository::class);
        $articles = $repository->index()->get();
        Cache::put(self::LIST_CACHE_KEY, $articles);
    }

    public static function getAllArticles(){
        if(!Cache::has(self::LIST_CACHE_KEY)){
            self::setAllArticles();
        }
        return Cache::get(self::LIST_CACHE_KEY);
    }

}
