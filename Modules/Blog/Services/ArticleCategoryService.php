<?php

namespace Modules\Blog\Services;

use Illuminate\Database\Eloquent\Builder;
use Modules\Blog\Repositories\ArticleCategoryRepository;

class ArticleCategoryService
{
    public function __construct(protected ArticleCategoryRepository $repository)
    {
    }

    public function list(): Builder
    {
        return $this->repository->index();
    }

    public function store($data){
        return $this->repository->newItem($data);
    }

    public function update($id, $data){
        return $this->repository->updateItem($id, $data);
    }

    public function delete($id){
        return $this->repository->remove($id);
    }
}
