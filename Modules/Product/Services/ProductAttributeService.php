<?php

namespace Modules\Product\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\FAQ\Repositories\FAQRepository;
use Modules\Product\Enums\ProductStatus;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAttribute;
use Modules\Product\Repositories\ProductAttributeRepository;
use Modules\Product\Repositories\ProductRepository;

class ProductAttributeService
{
    public function __construct(protected ProductAttributeRepository $repository){}

    public function findByProductId(string $productId): Collection
    {
        return $this->repository->getByFields([
            'product_id' => $productId
        ]);
    }

    public function findById(string $id)
    {
        return $this->repository->findByField('id', $id);
    }

    public function store(array $data): bool
    {
        return (bool) $this->repository->newItem($data);
    }

    public function update(string $id, array $data): bool
    {
        return $this->repository->updateItem($id, $data);
    }

    public function delete(string $id): bool
    {
        return $this->repository->remove($id);
    }

}
