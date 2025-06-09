<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Product\Database\Factories\ProductVariantFactory;

class ProductVariant extends Model
{
    use HasFactory;
    protected $table = 'product_variants';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'variant_type_value_id',
        'price',
        'quantity',
        'sku',
    ];

     protected static function newFactory(): ProductVariantFactory
     {
          return ProductVariantFactory::new();
     }

     /**
      * Relations
      */

     public function product(): BelongsTo
     {
         return $this->belongsTo(Product::class);
     }

     public function variant(): BelongsTo
     {
         return $this->belongsTo(ProductVariantTypeValue::class, 'variant_type_value_id');
     }
}
