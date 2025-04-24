<?php

namespace Modules\Blog\Observers;

use Modules\Blog\Cache\BlogCache;

class BlogObserver
{
    /**
     * Handle the BlogObserver "created" event.
     */
    public function created(): void {
        $this->cacheData();
    }

    /**
     * Handle the BlogObserver "updated" event.
     */
    public function updated(): void {
        $this->cacheData();
    }

    /**
     * Handle the BlogObserver "deleted" event.
     */
    public function deleted(): void {
        $this->cacheData();
    }

    /**
     * Handle the BlogObserver "restored" event.
     */
    public function restored(): void {
        $this->cacheData();
    }

    /**
     * Handle the BlogObserver "force deleted" event.
     */
    public function forceDeleted(): void {
        $this->cacheData();
    }

    /**
     * @return void
     */
    private function cacheData(): void
    {
        BlogCache::setAllArticles();
    }
}
