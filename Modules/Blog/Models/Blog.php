<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Blog\Database\Factories\BlogFactory;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'articles';

    protected $appends = [
        'image_url',
        'thumbnail_url',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    /**
     * Accessors
     */

    public function getImageUrlAttribute(){
        return route('api.articles.image', $this->id);
    }

    public function getThumbnailUrlAttribute(){
        return route('api.articles.thumbnail', $this->id);
    }

    /**
     * Relations
     */

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    // protected static function newFactory(): BlogFactory
    // {
    //     // return BlogFactory::new();
    // }
}
