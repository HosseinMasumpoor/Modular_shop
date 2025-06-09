<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Product\database\factories\ProductVariantTypeFactory;

class ProductVariantType extends Model
{
    use HasFactory;

    protected $table = 'variant_types';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
    ];

     protected static function newFactory(): ProductVariantTypeFactory
     {
          return ProductVariantTypeFactory::new();
     }

     /**
      * Relations
      */

     public function products(): HasMany
     {
         return $this->hasMany(Product::class, 'variant_type_id');
     }

     public function values(): HasMany
     {
         return $this->hasMany(ProductVariantTypeValue::class, 'variant_type_id');
     }
}
