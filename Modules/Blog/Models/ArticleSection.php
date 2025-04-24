<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Blog\Database\Factories\ArticleSectionFactory;

class ArticleSection extends Model
{
    use HasFactory;
    protected $table = 'article_sections';

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    /**
     * Relations
     */

    public function article(): BelongsTo
    {
        return $this->belongsTo(Blog::class, 'article_id');
    }

    // protected static function newFactory(): ArticleSectionFactory
    // {
    //     // return ArticleSectionFactory::new();
    // }
}
