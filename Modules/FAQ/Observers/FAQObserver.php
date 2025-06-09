<?php

namespace Modules\FAQ\Observers;


use Modules\FAQ\Cache\FAQCache;

class FAQObserver
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
        FAQCache::setAllFAQs();
    }
}
