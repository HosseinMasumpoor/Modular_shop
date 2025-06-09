<?php

namespace Modules\Product\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Modules\Core\Repositories\Repository;
use Modules\FAQ\Models\FAQ;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAttribute;
use Modules\Product\Models\ProductVariant;
use Modules\Product\Models\ProductVariantTypeValue;

class ProductVariantTypeValueRepository extends Repository
{
    public string|Model $model = ProductVariantTypeValue::class;

    public function Index(): Builder
    {
        return app(Pipeline::class)
            ->send(
                $this->query()
            )
            ->thenReturn()
            ->orderByDesc('created_at');
    }

    public function getByType(string $typeId): Builder
    {
        return app(Pipeline::class)
            ->send(
                $this->query()->where('variant_type_id', $typeId)
            )
            ->thenReturn()
            ->orderBy('order')->orderBy('name');
    }
}
