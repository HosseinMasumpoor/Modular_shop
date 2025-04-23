<?php

namespace Modules\Category\Observers;

use Modules\Category\Cache\CategoryCache;

class CategoryObserver
{
    public function created (): void
    {
        $this->cacheData();
    }

    public function updated (): void
    {
        $this->cacheData();
    }

    public function deleted (): void
    {
        $this->cacheData();
    }

    /**
     * @return void
     */
    private function cacheData(): void
    {
        CategoryCache::setAllCategories();
    }
}
