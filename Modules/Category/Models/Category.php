<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Project\Models\Project;

class Category extends Model
{
    protected $guarded = [];


    /**
     * Relations
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }


    /**
     * Scopes
     */

    public function scopeLocale($query, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $query->where('locale', $locale);
    }
}
