<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Product\database\factories\ProductVariantTypeValueFactory;

class ProductVariantTypeValue extends Model
{
    use HasFactory;

    protected $table = 'variant_type_values';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'variant_type_id',
        'value',
        'meta',
        'slug'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

     protected static function newFactory(): ProductVariantTypeValueFactory
     {
          return ProductVariantTypeValueFactory::new();
     }

     /**
      * Relations
      */
     public function variantType(): BelongsTo
     {
         return $this->belongsTo(ProductVariantType::class);
     }
}
