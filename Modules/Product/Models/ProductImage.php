<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Product\Database\Factories\ProductImageFactory;

class ProductImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'image_path',
        'thumbnail_path',
        'type',
        'alt',
        'order',
    ];

     protected static function newFactory(): ProductImageFactory
     {
          return ProductImageFactory::new();
     }

     /**
      * Relations
      */

     public function product(): BelongsTo
     {
         return $this->belongsTo(Product::class);
     }
}
