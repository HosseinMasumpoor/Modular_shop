<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Modules\Blog\Database\Factories\ArticleCategoryFactory;

class ArticleCategory extends Model
{
    use HasFactory;
    protected $table = 'article_categories';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    /**
     * Relations
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    // protected static function newFactory(): ArticleCategoryFactory
    // {
    //     // return ArticleCategoryFactory::new();
    // }
}
