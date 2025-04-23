<?php

namespace Modules\Category\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Repositories\CategoryRepository;

readonly class CategoryService
{
    public function __construct(private CategoryRepository $repository){}

    public function list(): Builder
    {
        return $this->repository->index();
    }


    public function store(array $data): Model
    {
        return $this->repository->newItem($data);
    }

    public function update(array $data, string $id): bool
    {
        return $this->repository->updateItem($data, $id);
    }

    public function delete(string $id): bool
    {
        return $this->repository->remove($id);
    }
}
