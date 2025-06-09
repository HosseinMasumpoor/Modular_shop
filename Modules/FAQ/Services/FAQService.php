<?php

namespace Modules\FAQ\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\FAQ\Repositories\FAQRepository;

class FAQService
{
    public function __construct(protected FAQRepository $repository){}

    public function list(): Builder
    {
        return $this->repository->index();
    }

    public function store(array $data): bool
    {
        return (bool) $this->repository->newItem($data);
    }

    public function update(string $id, array $data): bool
    {
        return $this->repository->updateItem($id, $data);
    }

    public function changeOrder(string $id, string $substituteId): bool
    {
        $substituteOrder = $this->repository->FindByField('id', $substituteId)->order;
        $itemOrder = $this->repository->FindByField('id', $id)->order;

        try {
            DB::beginTransaction();

            $this->repository->UpdateItem([
                'order' => $substituteOrder
            ], $id);

            $this->repository->UpdateItem([
                'order' => $itemOrder
            ], $substituteId);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function delete(string $id): bool
    {
        return $this->repository->remove($id);
    }
}
