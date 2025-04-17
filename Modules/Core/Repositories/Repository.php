<?php

namespace Modules\Core\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Interfaces\RepositoryInterface;

class Repository implements RepositoryInterface
{
    public string|Model $model;

    protected function query(): Builder
    {
        return $this->model::query();
    }
    public function getByFields($fields): Collection
    {
        $query = $this->query();
        foreach ($fields as $key => $value) {
            $query = $query->where($key, $value);
        }

        return $query->get();
    }

    public function findByField($field, $value)
    {
        return $this->query()->where($field, $value)->first();
    }

    public function newItem($data)
    {
        return $this->model::create($data);
    }

    public function updateItem($id, $data)
    {
        $record = $this->findByField("id", $id);
        foreach($data as $key => $value) {
            $record->{$key} = $value;
        }
        return $record->save();
    }

    public function remove($id): int
    {
        return $this->model::destroy($id);
    }

    public function index()
    {
        return $this->query()->orderByDesc('created_at');
    }
}
