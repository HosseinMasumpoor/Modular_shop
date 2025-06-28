<?php

namespace Modules\Product\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Product\Database\Factories\BrandFactory;

class Brand extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'brands';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

     protected static function newFactory(): BrandFactory
     {
          return BrandFactory::new();
     }

     /**
      * Relations
      */

     public function products(): HasMany
     {
         return $this->hasMany(Product::class);
     }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
