<?php

namespace Modules\Blog\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Modules\Blog\Database\Factories\BlogFactory;

class Blog extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'articles';

    protected $appends = [
        'image_url',
        'thumbnail_url',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    /**
     * Accessors
     */

    public function getImageUrlAttribute(): string
    {
        return route('api.articles.image', $this->id);
    }

    public function getThumbnailUrlAttribute(): string
    {
        return route('api.articles.thumbnail', $this->id);
    }

    /**
     * Relations
     */

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(ArticleSection::class, 'article_id');
    }

    // protected static function newFactory(): BlogFactory
    // {
    //     // return BlogFactory::new();
    // }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }
}
