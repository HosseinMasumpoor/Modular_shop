<?php

namespace Modules\Product\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\FAQ\Repositories\FAQRepository;
use Modules\Product\Enums\ProductStatus;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;

class ProductService
{
    public function __construct(protected ProductRepository $repository){}

    public function list(): Builder
    {
        return $this->repository->index();
    }

    public function findById(string $id): ?Product
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

    public function changeStatus(string $id, ProductStatus $status): bool
    {
        return $this->repository->updateItem($id, [
            'status' => $status->value
        ]);
    }
}
