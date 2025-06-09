<?php

namespace Modules\Product\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Modules\Core\Repositories\Repository;
use Modules\FAQ\Models\FAQ;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAttribute;
use Modules\Product\Models\ProductImage;

class ProductImageRepository extends Repository
{
    public string|Model $model = ProductImage::class;

    public function Index(): Builder
    {
        return app(Pipeline::class)
            ->send(
                $this->query()
            )
            ->thenReturn()
            ->orderByDesc('created_at');
    }

    public function getByProduct(string $productId): Builder
    {
        return app(Pipeline::class)
            ->send(
                $this->query()->where('product_id', $productId)
            )
            ->thenReturn()
            ->orderBy('order');
    }
}
