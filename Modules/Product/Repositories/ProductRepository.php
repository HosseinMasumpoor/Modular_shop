<?php

namespace Modules\Product\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Modules\Core\Repositories\Repository;
use Modules\FAQ\Models\FAQ;
use Modules\Product\Models\Product;

class ProductRepository extends Repository
{
    public string|Model $model = Product::class;

    public function Index(): Builder
    {
        return app(Pipeline::class)
            ->send(
                $this->query()
            )
            ->thenReturn()
            ->orderByDesc('created_at');
    }
}
