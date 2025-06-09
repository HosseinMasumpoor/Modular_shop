<?php

namespace Modules\FAQ\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $table = 'faq';
    protected $guarded = [];


    /**
     * Scopes
     */

    public function scopeLastOrder($query)
    {
        return $query->orderBy('order', 'desc')->first()->order ?? 0;
    }

    public function scopeLocale($query, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $query->where('locale', $locale);
    }
}
