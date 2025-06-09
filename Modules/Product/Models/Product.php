<?php

namespace Modules\Product\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Models\Category;
use Modules\Product\database\factories\ProductFactory;

class Product extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'brand_id',
        'category_id',
        'variant_type_id',
        'name',
        'slug',
        'description',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $table = 'products';


     protected static function newFactory(): ProductFactory
     {
          return ProductFactory::new();
     }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Relations
     */

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variantType(): BelongsTo
    {
        return $this->belongsTo(ProductVariantType::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

}
