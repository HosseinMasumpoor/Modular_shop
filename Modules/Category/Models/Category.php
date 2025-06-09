<?php

namespace Modules\Category\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Category\database\factories\CategoryFactory;

class Category extends Model
{
    use Sluggable, HasFactory;
    protected $table = 'categories';
    protected $guarded = [];


    /**
     * Relations
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

     protected static function newFactory(): CategoryFactory
     {
          return CategoryFactory::new();
     }
}
