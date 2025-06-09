<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Product\Database\Factories\ProductAttributeFactory;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $table = 'product_attributes';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'name',
        'value',
        'order'
    ];

     protected static function newFactory(): ProductAttributeFactory
     {
          return ProductAttributeFactory::new();
     }

     /**
      * Relations
      */

     public function product(): BelongsTo
     {
         return $this->belongsTo(Product::class);
     }
}
